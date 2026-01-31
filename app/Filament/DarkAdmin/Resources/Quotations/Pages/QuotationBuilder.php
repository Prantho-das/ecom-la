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

    public $currency = 'USD';

    public $conversion_rate = 125;

    public $margin = 30;

    public $tax = 5;

    public $vat = 10;

    // Default configuration for new tables
    public $config = [
        'export_freight_rate' => 3,
        'export_clearance_rate' => 2,
        'origin_thc_rate' => 15,
        'origin_thc_qty' => 10,
        'int_freight_cbm' => 20,
        'int_freight_kg' => 50,
        'insurance_rate' => 2,
        'import_duties_fixed' => 2500,
        'import_duties_multiplier' => 1.1,
    ];

    public $tables = [];

    public function mount(?int $record = null): void
    {
        if ($record) {
            $this->quotationId = $record;
            $this->loadQuotation($record);
        } else {
            $this->quotation_date = now()->format('Y-m-d');
            $this->addTable();
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
        $this->currency = $quotation->currency;
        $this->conversion_rate = (float) $quotation->conversion_rate;
        $this->margin = (float) $quotation->margin_percentage;
        $this->tax = (float) $quotation->tax_percentage;
        $this->vat = (float) $quotation->vat_percentage;

        // Add a title property or handle it in the view
        $this->dispatch('update-title', title: 'Edit Quotation: '.$quotation->reference_number);

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
                'config' => [
                    'export_freight_rate' => $item->unit_price > 0 ? $item->export_freight_local / $item->unit_price : 0,
                    'export_clearance_rate' => $item->unit_price > 0 ? $item->export_clearance / $item->unit_price : 0,
                    'origin_thc_rate' => $item->origin_thc,
                    'origin_thc_qty' => 1,
                    'int_freight_cbm' => $item->international_freight,
                    'int_freight_kg' => 1,
                    'insurance_rate' => $item->unit_price > 0 ? ($item->insurance / $item->unit_price) * 100 : 0,
                    'import_duties_fixed' => $item->import_duties_taxes,
                    'import_duties_multiplier' => 1.0,
                ],
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
            'quantity' => 1,
            'uom' => 'UNIT',
            'unit_product_price' => 10000,
            'config' => $this->config,
        ];
    }

    public function removeTable($id): void
    {
        $this->tables = collect($this->tables)->filter(fn ($t) => $t['id'] !== $id)->toArray();
        $this->tables = array_values($this->tables);
    }

    public function duplicateTable($id): void
    {
        $table = collect($this->tables)->first(fn ($t) => $t['id'] === $id);
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
            $product = \App\Models\Product::find($value);
            if ($product) {
                $this->tables[$index]['name'] = $product->name;
                $this->tables[$index]['unit_product_price'] = $product->price ?? 10000;
            }
        }
    }

    public function getCurrencySymbol(): string
{
    if ($this->currency === 'USD') return '$';
    if ($this->currency === 'EUR') return '€';
    if ($this->currency === 'GBP') return '£';
    if ($this->currency === 'BDT') return '৳';
    if ($this->currency === 'AED') return 'د.إ';
    
    return '$';
}

    public function getCalculations(int $index): array
    {
        $table = $this->tables[$index];
        $service = app(QuotationCalculationService::class);

        return $service->calculateMatrix(
            (float) $table['unit_product_price'],
            $table['config'],
            (float) $this->conversion_rate,
            (float) $this->margin,
            (float) $this->tax,
            (float) $this->vat
        );
    }

    public function save(): void
    {
        $this->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'quotation_date' => 'required|date',
            'currency' => 'required|string|in:USD,EUR,GBP,BDT,AED',
            'tables' => 'required|array|min:1',
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
                'currency' => $this->currency,
                'conversion_rate' => $this->conversion_rate,
                'margin_percentage' => $this->margin,
                'tax_percentage' => $this->tax,
                'vat_percentage' => $this->vat,
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
                'currency' => $this->currency,
                'conversion_rate' => $this->conversion_rate,
                'margin_percentage' => $this->margin,
                'tax_percentage' => $this->tax,
                'vat_percentage' => $this->vat,
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
                'currency' => $this->currency,
                'unit_price' => $tableData['unit_product_price'],
                'export_freight_local' => $costs['ef'] ?? 0,
                'export_clearance' => $costs['ec'] ?? 0,
                'origin_thc' => $costs['oh'] ?? 0,
                'international_freight' => $costs['inf'] ?? 0,
                'insurance' => $costs['ins'] ?? 0,
                'import_duties_taxes' => $costs['id'] ?? 0,
                'handling_charges_import' => $costs['hc'] ?? 0,
                'inland_transport' => $costs['it'] ?? 0,
                'conversion_rate' => $this->conversion_rate,
                'cost_factor' => $breakdown['cf'],
                'mg_amount' => (float) $breakdown['final'] - (float) $breakdown['up'], // Estimation of margin amount
                'tax_percent' => $this->tax / 100,
                'vat_percent' => $this->vat / 100,
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
