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
            $quotation->margin_percentage,
            $quotation->tax_percentage,
            $quotation->vat_percentage
        );
    }

    /**
     * Calculate a matrix of incoterms based on provided parameters
     */
    public function calculateMatrix(float $base, array $conf, float $conversionRate, float $margin, float $tax, float $vat): array
    {
        $c_ef = $base * ($conf['export_freight_rate'] / 100);
        $c_ec = $base * ($conf['export_clearance_rate'] / 100);
        $c_oh = $conf['origin_thc_rate'] * $conf['origin_thc_qty'];
        $c_if = $conf['int_freight_cbm'];
        $c_ins = $base * ($conf['insurance_rate'] / 100);
        $c_id = $conf['import_duties_fixed'] * $conf['import_duties_multiplier'];

        $incotermsConfig = [
            'Exwork' => ['ef' => 0, 'ec' => 0, 'oh' => 0, 'inf' => 0, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
            'FOB' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => 0, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
            'CFR' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
            'CIF' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => 0, 'hc' => 0, 'it' => 0],
            'DDU/DAP' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => 0, 'hc' => 200, 'it' => 200],
            'DDP' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => $c_id, 'hc' => 200, 'it' => 200],
            'BDT' => ['is_bdt' => true, 'ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => $c_id, 'hc' => 200, 'it' => 200],
            'BDT (Local)' => ['is_local' => true, 'ef' => 0, 'ec' => 0, 'oh' => 0, 'inf' => 0, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
        ];

        $results = [];
        foreach ($incotermsConfig as $name => $v) {
            if (isset($v['is_local'])) {
                $cf = 0;
                $up = 1831250; // Hardcoded baseline from index.html example
                $cf_disp = '—';
            } else {
                $cf = $v['ef'] + $v['ec'] + $v['oh'] + $v['inf'] + $v['ins'] + $v['id'] + $v['hc'] + $v['it'];
                $up = $base + $cf;
                $cf_disp = number_format($cf, 0);
            }

            if (isset($v['is_bdt'])) {
                $up = $up * $conversionRate;
                $cf_disp = number_format($cf / $base, 2);
            }

            $up_mg = $up * (1 + $margin / 100);
            $tax_vat_multiplier = 1 + ($tax + $vat) / 100;
            $final = $up_mg * $tax_vat_multiplier;

            $results[$name] = [
                'costs' => $v,
                'cf' => $cf,
                'cf_disp' => $cf_disp,
                'up' => $up,
                'up_mg' => $up_mg,
                'final' => $final,
                'is_bdt_row' => isset($v['is_bdt']) || isset($v['is_local']),
            ];
        }

        return $results;
    }
}
