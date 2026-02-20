<?php

namespace App\Filament\DarkAdmin\Resources\Quotations\Pages;

use App\Filament\DarkAdmin\Resources\Quotations\QuotationResource;
use App\Services\QuotationCalculationService;
use BackedEnum;
use Filament\Resources\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class QuotationBuilder extends Page
{
    protected static string $resource = QuotationResource::class;

    protected string $view = 'livewire.filament.dark-admin.resources.quotations.pages.quotation-builder';

    protected static ?string $title = 'Quotation System';

    protected static ?string $navigationLabel = 'Quotation System';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = -1;

    public $customer_name = '';

    public $customer_email = '';

    public $customer_address = '';

    public $customer_phone = '';

    public $customer_fax = '';

    public $attn = '';

    public $payment_term = 'TT Before Delivery';

    public $customer_po = '';

    public $quotation_date;

    public ?int $quotationId = null;

    public $conversion_rate = 1;

    public $margin = 0;

    public $tax = 0;

    public $vat = 0;

    public $discount_percentage = 0;

    // Default configuration for new tables
    public $config = [
        'export_freight_rate' => 0,
        'export_clearance_rate' => 0,
        'origin_thc_rate' => 0,
        'origin_thc_qty' => 0,
        'int_freight_cbm' => 0,
        'int_freight_kg' => 0,
        'insurance_rate' => 0,
        'import_duties_fixed' => 0,
        'import_duties_multiplier' => 0,
        'handling_charges_global' => 0,
        'inland_transport_global' => 0,
    ];

    public $tables = [];

    public function mount(?int $record = null): void
    {
        if ($record) {
            $this->quotationId = $record;
            $this->loadQuotation($record);
        } else {
            $this->quotation_date = now()->format('Y-m-d');
            // $this->addTable();
        }
    }

    public function loadQuotation(int $id): void
    {
        $quotation = \App\Models\Quotation::with('items')->findOrFail($id);

        $this->customer_name = $quotation->customer_name;
        $this->customer_email = $quotation->customer_email;
        $this->customer_address = $quotation->customer_address;
        $this->customer_phone = $quotation->customer_phone;
        $this->customer_fax = $quotation->customer_fax;
        $this->attn = $quotation->attn;
        $this->payment_term = $quotation->payment_term ?? 'TT Before Delivery';
        $this->customer_po = $quotation->customer_po;
        $this->quotation_date = $quotation->quotation_date?->format('Y-m-d') ?? now()->format('Y-m-d');
        $this->vat = (float) $quotation->vat_percentage;
        $this->discount_percentage = (float) $quotation->discount_percentage;

        // Add a title property or handle it in the view
        $this->dispatch('update-title', title: 'Edit Quotation: ' . $quotation->reference_number);

        $this->tables = [];
        foreach ($quotation->items as $item) {
            $this->tables[] = [
                'id' => \Illuminate\Support\Str::uuid()->toString(),
                'product_id' => $item->product_id,
                'selected_incoterm' => $item->incoterm ?? 'DDP',
                'name' => $item->product_name,
                'quantity' => $item->quantity ?? 1,
                'uom' => $item->uom ?? 'UNIT',
                'unit_product_price' => (float) $item->unit_price,
                'currency' => $item->currency,
                'margin' => (float) $item->margin_percentage,
                'tax' => (float) ($item->tax_percent * 100),
                'vat' => (float) ($item->vat_percent * 100),
                'discount' => (float) $item->discount_percentage,
                'config' => [
                    'export_freight_rate' => (float) $item->export_freight_rate,
                    'export_clearance_rate' => (float) $item->export_clearance_rate,
                    'origin_thc_rate' => (float) $item->origin_thc_rate,
                    'origin_thc_qty' => (float) $item->origin_thc_qty,
                    'int_freight_cbm' => (float) $item->int_freight_rate_1,
                    'int_freight_kg' => (float) $item->int_freight_rate_2,
                    'insurance_rate' => (float) $item->insurance_rate,
                    'import_duties_fixed' => (float) $item->import_duties_fixed,
                    'import_duties_multiplier' => (float) $item->import_duties_multiplier,
                    'handling_charges_global' => (float) $item->handling_charges_global,
                    'inland_transport_global' => (float) $item->inland_transport_global,
                ],
                'conversion_rate' => (float) ($item->conversion_rate ?? $this->conversion_rate),
            ];
        }
    }

    public function addTable(): void
    {
        $this->tables[] = [
            'id' => Str::uuid()->toString(),
            'product_id' => '',
            'selected_incoterm' => 'DDP',
            'name' => '',
            'quantity' => 0,
            'uom' => 'UNIT',
            'unit_product_price' => 0,
            'currency' => \App\Models\Currency::where('is_base', true)->first()?->code ?? 'USD',
            'margin' => $this->margin,
            'tax' => $this->tax,
            'vat' => $this->vat,
            'discount' => 0,
            'config' => $this->config,
            'conversion_rate' => $this->conversion_rate,
        ];
    }

    public function removeTable($id): void
    {
        $this->tables = collect($this->tables)->filter(fn($t) => $t['id'] !== $id)->toArray();
        $this->tables = array_values($this->tables);
    }

    public function duplicateTable($id): void
    {
        $table = collect($this->tables)->first(fn($t) => $t['id'] === $id);
        if ($table) {
            $newTable = $table;
            $newTable['id'] = Str::uuid()->toString();
            $this->tables[] = $newTable;
        }
    }

    public function updatedTables($value, $key): void
    {
        if (Str::endsWith($key, '.product_id')) {
            $index = explode('.', $key)[0];
            $product = \App\Models\Product::with('currency')->find($value);
            if ($product) {
                $this->tables[$index]['name'] = $product->name;
                $this->tables[$index]['unit_product_price'] = $product->price ?? 0;
                
                if ($product->currency) {
                    $this->tables[$index]['currency'] = $product->currency->code;
                    $this->tables[$index]['conversion_rate'] = (float) $product->currency->exchange_rate;
                }
            }
        }

        if (Str::endsWith($key, '.currency')) {
            $index = explode('.', $key)[0];
            $currency = \App\Models\Currency::where('code', $value)->first();
            if ($currency) {
                $this->tables[$index]['conversion_rate'] = (float) $currency->exchange_rate;
            }
        }
    }

    public function getCurrencySymbol(?string $code = null): string
    {
        $code = $code ?? 'USD';
        $currency = \App\Models\Currency::where('code', $code)->first();
        
        return $currency?->symbol ?? '$';
    }

    public function getCalculations(int $index): array
    {
        $table = $this->tables[$index];
        $service = app(QuotationCalculationService::class);

        return $service->calculateMatrix(
            (float) (is_numeric($table['unit_product_price'] ?? null) ? $table['unit_product_price'] : 0),
            $table['config'],
            (float) (is_numeric($table['conversion_rate'] ?? null) ? $table['conversion_rate'] : (is_numeric($this->conversion_rate) ? $this->conversion_rate : 1)),
            (float) (is_numeric($table['margin'] ?? null) ? $table['margin'] : 0),
            (float) (is_numeric($table['tax'] ?? null) ? $table['tax'] : 0),
            (float) (is_numeric($table['vat'] ?? null) ? $table['vat'] : 0),
            (float) (is_numeric($table['discount'] ?? null) ? $table['discount'] : 0)
        );
    }

    public function save(): void
    {
        $this->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'tables' => 'required|array|min:1',
            'tables.*.currency' => 'required|string',
            'tables.*.quantity' => 'required|numeric|min:0',
            'tables.*.unit_product_price' => 'required|numeric|min:0',
            'tables.*.conversion_rate' => 'required|numeric|gt:0',
        ], [
            'tables.*.quantity.min' => 'Quantity must be at least 0.',
            'tables.*.conversion_rate.gt' => 'Conversion rate must be greater than 0.',
        ]);

        if ($this->quotationId) {
            $quotation = \App\Models\Quotation::findOrFail($this->quotationId);
            $quotation->update([
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_address' => $this->customer_address,
                'customer_phone' => $this->customer_phone,
                'customer_fax' => $this->customer_fax,
                'attn' => $this->attn,
                'payment_term' => $this->payment_term,
                'customer_po' => $this->customer_po,
                'quotation_date' => $this->quotation_date,
                'margin_percentage' => $this->margin,
                'tax_percentage' => $this->tax,
                'vat_percentage' => $this->vat,
                'discount_percentage' => $this->discount_percentage,
            ]);

            // Delete old items to recreate them
            $quotation->items()->delete();
        } else {
            $quotation = \App\Models\Quotation::create([
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_address' => $this->customer_address,
                'customer_phone' => $this->customer_phone,
                'customer_fax' => $this->customer_fax,
                'attn' => $this->attn,
                'payment_term' => $this->payment_term,
                'customer_po' => $this->customer_po,
                'quotation_date' => $this->quotation_date,
                'margin_percentage' => $this->margin,
                'tax_percentage' => $this->tax,
                'vat_percentage' => $this->vat,
                'discount_percentage' => $this->discount_percentage,
                'status' => 'draft',
            ]);
        }

        foreach ($this->tables as $index => $tableData) {
            $calcs = $this->getCalculations($index);
            $selectedIncoterm = $tableData['selected_incoterm'] ?? 'DDP';
            $breakdown = $calcs[$selectedIncoterm] ?? $calcs['DDP'];
            $costs = $breakdown['costs'];

            $quotation->items()->create([
                'product_id' => $tableData['product_id'] ?: null,
                'quantity' => $tableData['quantity'] ?? 1,
                'uom' => $tableData['uom'] ?? 'UNIT',
                'shipment_mode' => 'Sea', // Defaulting to Sea as it matches the previous logic's context
                'product_name' => $tableData['name'] ?: 'Custom Item',
                'incoterm' => $selectedIncoterm,
                'currency' => $tableData['currency'] ?? 'USD',
                'unit_price' => $tableData['unit_product_price'],
                'export_freight_local' => $costs['ef'] ?? 0,
                'export_clearance' => $costs['ec'] ?? 0,
                'origin_thc' => $costs['oh'] ?? 0,
                'international_freight' => $costs['inf'] ?? 0,
                'insurance' => $costs['ins'] ?? 0,
                'import_duties_taxes' => $costs['id'] ?? 0,
                'handling_charges_import' => $costs['hc'] ?? 0,
                'inland_transport' => $costs['it'] ?? 0,
                'export_freight_rate' => $tableData['config']['export_freight_rate'] ?? 0,
                'export_clearance_rate' => $tableData['config']['export_clearance_rate'] ?? 0,
                'origin_thc_rate' => $tableData['config']['origin_thc_rate'] ?? 0,
                'origin_thc_qty' => $tableData['config']['origin_thc_qty'] ?? 1,
                'int_freight_rate_1' => $tableData['config']['int_freight_cbm'] ?? 0,
                'int_freight_rate_2' => $tableData['config']['int_freight_kg'] ?? 1,
                'insurance_rate' => $tableData['config']['insurance_rate'] ?? 0,
                'import_duties_fixed' => $tableData['config']['import_duties_fixed'] ?? 0,
                'import_duties_multiplier' => $tableData['config']['import_duties_multiplier'] ?? 1,
                'handling_charges_global' => $tableData['config']['handling_charges_global'] ?? 0,
                'inland_transport_global' => $tableData['config']['inland_transport_global'] ?? 0,
                'conversion_rate' => $tableData['conversion_rate'] ?? $this->conversion_rate,
                'cost_factor' => $breakdown['cf'],
                'mg_amount' => (float) $breakdown['up_mg'] - (float) $breakdown['up'], // Corrected: price_with_mg - cost_factor_total_price
                'tax_percent' => ($tableData['tax'] ?? 0) / 100,
                'vat_percent' => ($tableData['vat'] ?? 0) / 100,
                'margin_percentage' => $tableData['margin'] ?? 0,
                'discount_percentage' => $tableData['discount'] ?? 0,
                'unit_price_exwork' => $breakdown['up'],
                'unit_price_with_mg' => (float) $breakdown['up_mg'],
                'final_unit_price' => (float) $breakdown['final'],
                'row_total' => (float) $breakdown['final'] * ($tableData['quantity'] ?? 1),
            ]);
        }

        $quotation->calculateTotals();

        \Filament\Notifications\Notification::make()
            ->success()
            ->title($this->quotationId ? 'Quotation Updated' : 'Quotation Created')
            ->body('The quotation has been saved successfully.')
            ->send();

        $this->redirect(\App\Filament\DarkAdmin\Resources\Quotations\QuotationResource::getUrl('index'));
    }
}
