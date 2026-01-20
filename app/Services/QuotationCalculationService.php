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
}
