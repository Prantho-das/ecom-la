<?php

namespace App\Filament\DarkAdmin\Resources\Quotations\Pages;

use App\Filament\DarkAdmin\Resources\Quotations\QuotationResource;
use App\Models\ProductVariant;
use App\Models\Quotation;
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

    public function mount(): void
    {
        $this->addTable();
    }

    public function addTable(): void
    {
        $this->tables[] = [
            'id' => Str::uuid()->toString(),
            'variant_id' => '',
            'name' => '',
            'sku' => '',
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
        if (Str::endsWith($key, '.variant_id')) {
            $index = explode('.', $key)[0];
            $variant = ProductVariant::find($value);
            if ($variant) {
                $this->tables[$index]['name'] = $variant->title;
                $this->tables[$index]['sku'] = $variant->sku;
                $this->tables[$index]['unit_product_price'] = $variant->price ?? 10000;
            }
        }
    }

    public function save(): void
    {
        $this->validate([
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'tables' => 'required|array|min:1',
        ]);

        // For now, saving as a draft quotation with items based on DDP row logic
        $quotation = Quotation::create([
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'currency' => $this->currency,
            'conversion_rate' => $this->conversion_rate,
            'margin_percentage' => $this->margin,
            'tax_percentage' => $this->tax,
            'vat_percentage' => $this->vat,
            'status' => 'draft',
        ]);

        foreach ($this->tables as $tableData) {
            // Logic to persist the chosen model and its calculated DDP price
            // (Assuming user wants to save the DDP version or we save the whole matrix configuration)
            $quotation->items()->create([
                'variant_id' => $tableData['variant_id'] ?: null,
                'name' => $tableData['name'] ?: 'Custom Item',
                'sku' => $tableData['sku'] ?: 'NA',
                'unit_product_price' => $tableData['unit_product_price'],
                'quantity' => 1,
                // Additional cost fields map to the model attributes...
            ]);
        }

        $this->redirect(QuotationResource::getUrl('index'));
    }
}
