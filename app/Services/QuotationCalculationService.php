<?php

namespace App\Services;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\ShippingConfiguration;

class QuotationCalculationService
{
    /**
     * Calculate all costs for a quotation
     */
    public function calculateQuotation(Quotation $quotation): void
    {
        $quotation->calculateShippingCosts();
    }

    /**
     * Recalculate all items in a quotation
     */
    public function recalculateAllItems(Quotation $quotation): void
    {
        $config = ShippingConfiguration::getActiveConfig($quotation->shipping_method);

        if (! $config) {
            return;
        }

        foreach ($quotation->items as $item) {
            $this->calculateItem($item, $quotation, $config);
        }

        $quotation->calculateTotals();
    }

    /**
     * Calculate a single quotation item
     */
    private function calculateItem(QuotationItem $item, Quotation $quotation, ShippingConfiguration $config): void
    {
        $item->calculateItemCosts(
            $quotation->pricing_tier,
            $config,
            $quotation->conversion_rate,
            (float) $item->margin_percentage,
            (float) ($item->tax_percent * 100),
            (float) ($item->vat_percent * 100)
            // Note: calculateItemCosts on model needs update if we want to support discount usage there too, 
            // but the builder uses calculateMatrix directly.
        );
    }

    /**
     * Calculate a matrix of incoterms based on provided parameters
     */
    public function calculateMatrix(float $base, array $conf, float $conversionRate, float $margin, float $tax, float $vat, float $discount = 0): array
    {
        $c_ef = $base * ((float) ($conf['export_freight_rate'] ?? 0) / 100);
        $c_ec = $base * ((float) ($conf['export_clearance_rate'] ?? 0) / 100); // Unit Price * Input %
        $c_oh = (float) ($conf['origin_thc_rate'] ?? 0) * (float) ($conf['origin_thc_qty'] ?? 0);
        $c_if = (float) ($conf['int_freight_cbm'] ?? 0) * (float) ($conf['int_freight_kg'] ?? 0); // Input 1 * Input 2
        $c_ins = $base * ((float) ($conf['insurance_rate'] ?? 0) / 100); // Input % * Unit Price
        $c_id = (float) ($conf['import_duties_fixed'] ?? 0) * (float) ($conf['import_duties_multiplier'] ?? 1); // Input 1 * Input 2
        
        $hc_global = (float) ($conf['handling_charges_global'] ?? 200);
        $it_global = (float) ($conf['inland_transport_global'] ?? 200);

        $incotermsConfig = [
            'Exwork' => ['ef' => 0, 'ec' => 0, 'oh' => 0, 'inf' => 0, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
            'FOB' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => 0, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
            'CFR' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
            'CIF' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => 0, 'hc' => 0, 'it' => 0],
            'DDU/DAP' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => 0, 'hc' => $hc_global, 'it' => $it_global],
            'DDP' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => $c_id, 'hc' => $hc_global, 'it' => $it_global],
            'BDT' => ['is_bdt' => true, 'ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => $c_id, 'hc' => $hc_global, 'it' => $it_global],
            'BDT (Local)' => ['is_local' => true, 'ef' => 0, 'ec' => 0, 'oh' => 0, 'inf' => 0, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
        ];

        $results = [];
        foreach ($incotermsConfig as $name => $v) {
            if (isset($v['is_local'])) {
                $cf = 0;
                $up = $base * $conversionRate;
                $cf_disp = '—';
            } else {
                $cf = $v['ef'] + $v['ec'] + $v['oh'] + $v['inf'] + $v['ins'] + $v['id'] + $v['hc'] + $v['it'];
                $up = $base + $cf;
                $cf_disp = number_format($cf, 0);
            }

            if (isset($v['is_bdt'])) {
                $up = $up * $conversionRate;
                $cf_disp = $base > 0 ? number_format($cf / $base, 2) : '0.00';
            }

            $up_mg = $up * (1 + $margin / 100);
            $tax_vat_multiplier = 1 + ($tax + $vat) / 100;
            $final = ($up_mg * $tax_vat_multiplier) * (1 - $discount / 100);

            $results[$name] = [
                'costs' => $v,
                'cf' => $cf,
                'cf_disp' => $cf_disp,
                'up' => $up,
                'up_mg' => $up_mg,
                'final' => $final,
                'is_bdt_row' => isset($v['is_bdt']) || isset($v['is_local']),
                'formulas' => [
                    'Export Freight' => "Base ($base) * (" . ($conf['export_freight_rate'] ?? 0) . " / 100) = " . number_format($v['ef'], 2),
                    'Export Clearance' => "Base ($base) * (" . ($conf['export_clearance_rate'] ?? 0) . " / 100) = " . number_format($v['ec'], 2),
                    'Origin THC' => "Rate (" . ($conf['origin_thc_rate'] ?? 0) . ") * Qty (" . ($conf['origin_thc_qty'] ?? 0) . ") = " . number_format($v['oh'], 2),
                    'Int. Freight' => "CBM (" . ($conf['int_freight_cbm'] ?? 0) . ") * KG (" . ($conf['int_freight_kg'] ?? 0) . ") = " . number_format($v['inf'], 2),
                    'Insurance' => "Base ($base) * (" . ($conf['insurance_rate'] ?? 0) . " / 100) = " . number_format($v['ins'], 2),
                    'Import Duties' => "Fixed (" . ($conf['import_duties_fixed'] ?? 0) . ") * Mult (" . ($conf['import_duties_multiplier'] ?? 1) . ") = " . number_format($v['id'], 2),
                    'Handling' => number_format($v['hc'], 2),
                    'Inland' => number_format($v['it'], 2),
                    'Total CF' => implode(' + ', array_filter([
                        $v['ef'] ? number_format($v['ef'], 2) : null,
                        $v['ec'] ? number_format($v['ec'], 2) : null,
                        $v['oh'] ? number_format($v['oh'], 2) : null,
                        $v['inf'] ? number_format($v['inf'], 2) : null,
                        $v['ins'] ? number_format($v['ins'], 2) : null,
                        $v['id'] ? number_format($v['id'], 2) : null,
                        $v['hc'] ? number_format($v['hc'], 2) : null,
                        $v['it'] ? number_format($v['it'], 2) : null,
                    ])) . " = " . number_format($cf, 2),
                    'Unit Price' => "Base ($base) + CF (" . number_format($cf, 2) . ") = " . number_format($up, 2),
                    'Price + MG' => "UP (" . number_format($up, 2) . ") * (1 + $margin/100) = " . number_format($up_mg, 2),
                    'Final Price' => "UP+MG (" . number_format($up_mg, 2) . ") * (1 + ($tax+$vat)/100) * (1 - $discount/100) = " . number_format($final, 2),
                ],
            ];
        }

        return $results;
    }
}
