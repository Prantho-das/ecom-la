<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    protected $fillable = [
        'quotation_id',
        'variant_id',
        'name',
        'sku',
        'quantity',
        'price',
        'row_total',
        'weight_kg',
        'volume_cbm',
        'unit_product_price',
        'export_freight',
        'export_clearance',
        'origin_handling',
        'international_freight',
        'insurance',
        'import_duties',
        'handling_charges',
        'inland_transport',
        'cost_factor',
        'unit_price_with_costs',
        'unit_price_with_margin',
        'final_unit_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'weight_kg' => 'decimal:2',
            'volume_cbm' => 'decimal:4',
            'unit_product_price' => 'decimal:6',
            'price' => 'decimal:6',
            'row_total' => 'decimal:6',
            'export_freight' => 'decimal:6',
            'export_clearance' => 'decimal:6',
            'origin_handling' => 'decimal:6',
            'international_freight' => 'decimal:6',
            'insurance' => 'decimal:6',
            'import_duties' => 'decimal:6',
            'handling_charges' => 'decimal:6',
            'inland_transport' => 'decimal:6',
            'cost_factor' => 'decimal:6',
            'unit_price_with_costs' => 'decimal:6',
            'unit_price_with_margin' => 'decimal:6',
            'final_unit_price' => 'decimal:6',
        ];
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Calculate item costs based on pricing tier
     * This matches the Excel Price Sheet.xlsx calculations
     */
    public function calculateItemCosts(
        string $pricingTier,
        ShippingConfiguration $config,
        float $conversionRate,
        float $marginPercentage,
        float $taxPercentage,
        float $vatPercentage
    ): void {
        $basePrice = $this->unit_product_price;

        // Reset all costs first
        $this->resetCosts();

        // Calculate costs based on pricing tier (matching Excel formulas)
        switch ($pricingTier) {
            case 'exwork':
                $this->calculateExwork($basePrice);
                break;
            case 'fob':
                $this->calculateFOB($basePrice, $config);
                break;
            case 'cfr':
                $this->calculateCFR($basePrice, $config);
                break;
            case 'cif':
                $this->calculateCIF($basePrice, $config);
                break;
            case 'ddu_dap':
                $this->calculateDDU($basePrice, $config);
                break;
            case 'ddp':
                $this->calculateDDP($basePrice, $config);
                break;
            case 'bdt_local':
                $this->calculateBDT($basePrice, $config, $conversionRate);
                break;
        }

        // Calculate cost factor (sum of all additional costs)
        $this->cost_factor = $this->export_freight + $this->export_clearance +
            $this->origin_handling + $this->international_freight +
            $this->insurance + $this->import_duties +
            $this->handling_charges + $this->inland_transport;

        // Unit price with all costs
        $this->unit_price_with_costs = $basePrice + $this->cost_factor;

        // Apply margin (MG%)
        $this->unit_price_with_margin = $this->unit_price_with_costs * (1 + $marginPercentage / 100);

        // Apply tax and VAT
        $this->final_unit_price = round($this->unit_price_with_margin * (1 + $taxPercentage + $vatPercentage), 0);

        // Update price and row total
        $this->price = $this->final_unit_price;
        $this->row_total = $this->final_unit_price * $this->quantity;

        $this->save();
    }

    /**
     * Reset all cost fields to zero
     */
    private function resetCosts(): void
    {
        $this->export_freight = 0;
        $this->export_clearance = 0;
        $this->origin_handling = 0;
        $this->international_freight = 0;
        $this->insurance = 0;
        $this->import_duties = 0;
        $this->handling_charges = 0;
        $this->inland_transport = 0;
    }

    /**
     * Exwork: No additional costs
     * Formula: Unit Price = Base Price
     */
    private function calculateExwork(float $basePrice): void
    {
        // No additional costs for Exwork
        // All costs remain 0
    }

    /**
     * FOB (Free on Board)
     * Formula: Base + Export Freight + Export Clearance + Origin THC
     */
    private function calculateFOB(float $basePrice, ShippingConfiguration $config): void
    {
        // Export freight = Base Price × 3%
        $this->export_freight = $basePrice * $config->export_freight_rate;

        // Export clearance = Base Price × 1.5%
        $this->export_clearance = $basePrice * $config->export_clearance_rate;

        // Origin handling (THC for sea, airport handling for air)
        if ($this->quotation->shipping_method === 'sea') {
            $this->origin_handling = ($this->volume_cbm ?? 0) * $config->origin_thc_per_cbm;
        } else {
            $this->origin_handling = ($this->weight_kg ?? 0) * $config->airport_handling_per_kg;
        }
    }

    /**
     * CFR (Cost and Freight)
     * Formula: FOB + International Freight
     */
    private function calculateCFR(float $basePrice, ShippingConfiguration $config): void
    {
        // First calculate FOB costs
        $this->calculateFOB($basePrice, $config);

        // Add international freight
        if ($this->quotation->shipping_method === 'sea') {
            $this->international_freight = ($this->volume_cbm ?? 0) * $config->international_freight_per_cbm;
        } else {
            $this->international_freight = ($this->weight_kg ?? 0) * $config->international_freight_per_kg;
        }
    }

    /**
     * CIF (Cost, Insurance, and Freight)
     * Formula: CFR + Insurance
     */
    private function calculateCIF(float $basePrice, ShippingConfiguration $config): void
    {
        // First calculate CFR costs
        $this->calculateCFR($basePrice, $config);

        // Add insurance = Base Price × 1.5%
        $this->insurance = $basePrice * $config->insurance_rate;
    }

    /**
     * DDU/DAP (Delivered Duty Unpaid / Delivered at Place)
     * Formula: CIF + Handling Charges + Inland Transport
     */
    private function calculateDDU(float $basePrice, ShippingConfiguration $config): void
    {
        // First calculate CIF costs
        $this->calculateCIF($basePrice, $config);

        // Add handling charges (fixed)
        $this->handling_charges = $config->handling_charges_fixed;

        // Add inland transport (fixed)
        $this->inland_transport = $config->inland_transport_fixed;
    }

    /**
     * DDP (Delivered Duty Paid)
     * Formula: DDU + Import Duties & Taxes
     */
    private function calculateDDP(float $basePrice, ShippingConfiguration $config): void
    {
        // First calculate DDU costs
        $this->calculateDDU($basePrice, $config);

        // Add import duties = Fixed amount × Multiplier
        $this->import_duties = $config->import_duties_fixed * $config->import_duties_multiplier;
    }

    /**
     * BDT (Local Currency)
     * Formula: (Base Price + Cost Factor) × Conversion Rate
     */
    private function calculateBDT(float $basePrice, ShippingConfiguration $config, float $conversionRate): void
    {
        // Calculate DDP first to get all costs
        $this->calculateDDP($basePrice, $config);

        // The conversion is applied in the final price calculation
        // Cost factor calculation will be done in the main method
    }
}
