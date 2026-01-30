<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference_number',
        'quotation_date',
        'customer_name',
        'customer_email',
        'shipping_method',
        'pricing_tier',
        'currency',
        'conversion_rate',
        'margin_percentage',
        'tax_percentage',
        'vat_percentage',
        'status',
        'subtotal',
        'discount_total',
        'tax_total',
        'grand_total',
        'export_freight_total',
        'export_clearance_total',
        'origin_handling_total',
        'international_freight_total',
        'insurance_total',
        'import_duties_total',
        'handling_charges_total',
        'inland_transport_total',
        'cost_factor',
        'unit_price_with_margin',
        'notes',
        'expires_at',
    ];

    protected static function booted()
    {
        static::creating(function ($quotation) {
            if (empty($quotation->reference_number)) {
                $latest = static::latest('id')->first();
                $nextId = $latest ? $latest->id + 1 : 1;
                $quotation->reference_number = 'QT-'.date('Ymd').'-'.str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'quotation_date' => 'date',
            'expires_at' => 'datetime',
            'conversion_rate' => 'decimal:4',
            'margin_percentage' => 'decimal:2',
            'tax_percentage' => 'decimal:4',
            'vat_percentage' => 'decimal:4',
            'subtotal' => 'decimal:6',
            'discount_total' => 'decimal:6',
            'tax_total' => 'decimal:6',
            'grand_total' => 'decimal:6',
            'export_freight_total' => 'decimal:6',
            'export_clearance_total' => 'decimal:6',
            'origin_handling_total' => 'decimal:6',
            'international_freight_total' => 'decimal:6',
            'insurance_total' => 'decimal:6',
            'import_duties_total' => 'decimal:6',
            'handling_charges_total' => 'decimal:6',
            'inland_transport_total' => 'decimal:6',
            'cost_factor' => 'decimal:6',
            'unit_price_with_margin' => 'decimal:6',
        ];
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    /**
     * Calculate shipping costs for all items based on pricing tier
     */
    public function calculateShippingCosts(): void
    {
        $config = ShippingConfiguration::getActiveConfig($this->shipping_method);
        if (! $config) {
            return;
        }

        $totals = [
            'export_freight' => 0,
            'export_clearance' => 0,
            'origin_handling' => 0,
            'international_freight' => 0,
            'insurance' => 0,
            'import_duties' => 0,
            'handling_charges' => 0,
            'inland_transport' => 0,
        ];

        foreach ($this->items as $item) {
            $item->calculateItemCosts(
                $this->pricing_tier,
                $config,
                $this->conversion_rate,
                $this->margin_percentage,
                $this->tax_percentage,
                $this->vat_percentage
            );

            // Aggregate totals
            $totals['export_freight'] += $item->export_freight_local;
            $totals['export_clearance'] += $item->export_clearance;
            $totals['origin_handling'] += $item->origin_thc;
            $totals['international_freight'] += $item->international_freight;
            $totals['insurance'] += $item->insurance;
            $totals['import_duties'] += $item->import_duties_taxes;
            $totals['handling_charges'] += $item->handling_charges_import;
            $totals['inland_transport'] += $item->inland_transport;
        }

        // Update quotation totals
        $this->export_freight_total = $totals['export_freight'];
        $this->export_clearance_total = $totals['export_clearance'];
        $this->origin_handling_total = $totals['origin_handling'];
        $this->international_freight_total = $totals['international_freight'];
        $this->insurance_total = $totals['insurance'];
        $this->import_duties_total = $totals['import_duties'];
        $this->handling_charges_total = $totals['handling_charges'];
        $this->inland_transport_total = $totals['inland_transport'];

        $this->calculateTotals();
    }

    public function calculateTotals(): void
    {
        $this->subtotal = $this->items()->sum('row_total');
        $this->grand_total = $this->subtotal - $this->discount_total + $this->tax_total;
        $this->save();
    }
}
