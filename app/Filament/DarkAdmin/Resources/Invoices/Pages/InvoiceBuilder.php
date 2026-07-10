<?php

namespace App\Filament\DarkAdmin\Resources\Invoices\Pages;

use App\Filament\DarkAdmin\Resources\Invoices\InvoiceResource;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\QuotationItem;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Str;

class InvoiceBuilder extends Page
{
    protected static string $resource = InvoiceResource::class;

    protected string $view = 'livewire.filament.dark-admin.resources.invoices.pages.invoice-builder';

    protected static ?string $title = 'Generate Invoice';

    protected static ?string $navigationLabel = 'Generate Invoice';

    public $customer_name = '';

    public $business_name = '';

    public $email = '';

    public $invoice_date;

    public $quotation_date;

    public $contact_person = '';

    public $payment_term = '';

    public $customer_po_ref = '';

    public $phone_number = '';

    public $fax_number = '';

    public $office_address = '';

    public $incoterm = '';

    public $currency = '';

    public $cost_factor = 0;

    public $global_discount = 0;

    public $products = [];

    public $tables = []; // Using 'tables' to match QuotationBuilder structure

    public function mount(?int $record = null): void
    {
        if ($record) {
            $this->loadInvoice($record);
        } else {
            $this->invoice_date = now()->format('Y-m-d');
            $this->quotation_date = now()->format('Y-m-d');
            $this->addTable();
        }

        $this->products = Product::whereHas('quotationItems')->get();
    }

    public function loadInvoice(int $id): void
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        $this->customer_name = $invoice->customer_name;
        $this->business_name = $invoice->business_name;
        $this->email = $invoice->email;
        $this->invoice_date = $invoice->invoice_date ? \Illuminate\Support\Carbon::parse($invoice->invoice_date)->format('Y-m-d') : null;
        $this->quotation_date = $invoice->quotation_date ? \Illuminate\Support\Carbon::parse($invoice->quotation_date)->format('Y-m-d') : null;
        $this->contact_person = $invoice->contact_person;
        $this->payment_term = $invoice->payment_term;
        $this->customer_po_ref = $invoice->customer_po_ref;
        $this->phone_number = $invoice->phone_number;
        $this->fax_number = $invoice->fax_number;
        $this->office_address = $invoice->office_address;
        $this->cost_factor = $invoice->cost_factor ?? 0;
        $this->global_discount = $invoice->global_discount ?? 0;

        $this->tables = [];
        foreach ($invoice->items as $item) {
            $incoterms = QuotationItem::where('product_id', $item->product_id)
                ->whereNotNull('incoterm')
                ->select('incoterm')
                ->distinct()
                ->pluck('incoterm')
                ->toArray();

            $currencies = QuotationItem::where('product_id', $item->product_id)
                ->where('incoterm', $item->incoterm)
                ->select('currency')
                ->distinct()
                ->pluck('currency')
                ->toArray();

            $this->tables[] = [
                'id' => Str::uuid()->toString(),
                'product_id' => $item->product_id,
                'name' => $item->product_name,
                'port' => $item->port,
                'incoterm' => $item->incoterm,
                'currency' => $item->currency,
                'quantity' => $item->quantity,
                'uom' => $item->uom,
                'unit_price' => $item->unit_price,
                'available_incoterms' => $incoterms,
                'available_currencies' => $currencies,
            ];
        }
    }

    public function addTable(): void
    {
        $this->tables[] = [
            'id' => Str::uuid()->toString(),
            'product_id' => '',
            'name' => '',
            'port' => '',
            'incoterm' => '',
            'currency' => '',
            'quantity' => 1,
            'uom' => 'UNIT',
            'unit_price' => 0,
            'available_incoterms' => [],
            'available_currencies' => [],
        ];
    }

    public function removeTable($id): void
    {
        $this->tables = collect($this->tables)->filter(fn ($t) => $t['id'] !== $id)->toArray();
        $this->tables = array_values($this->tables);
        $this->cost_factor = $this->calculateCostFactor();
    }

    public function calculateCostFactor(): float
    {
        $total = 0;
        foreach ($this->tables as $table) {
            if (empty($table['product_id']) || empty($table['incoterm']) || empty($table['currency'])) {
                continue;
            }
            $latest = QuotationItem::where('product_id', $table['product_id'])
                ->where('incoterm', $table['incoterm'])
                ->where('currency', $table['currency'])
                ->latest()
                ->first();
            $itemCostFactor = $latest ? (float) $latest->cost_factor : 0;
            $total += $itemCostFactor * (float) ($table['quantity'] ?? 0);
        }

        return $total;
    }

    public function updated($property, $value): void
    {
        if (Str::startsWith($property, 'tables.') && Str::endsWith($property, '.product_id')) {
            $index = explode('.', $property)[1];
            $product = Product::find($value);

            // Reset dependent fields
            $this->tables[$index]['incoterm'] = '';
            $this->tables[$index]['currency'] = '';
            $this->tables[$index]['unit_price'] = 0;
            $this->tables[$index]['available_incoterms'] = [];
            $this->tables[$index]['available_currencies'] = [];

            if ($product) {
                $this->tables[$index]['name'] = $product->name;
                $this->tables[$index]['unit_price'] = $product->price ?? 0;

                // Fetch available incoterms for this product
                $incoterms = QuotationItem::where('product_id', $value)
                    ->whereNotNull('incoterm')
                    ->select('incoterm')
                    ->distinct()
                    ->pluck('incoterm')
                    ->toArray();

                $this->tables[$index]['available_incoterms'] = $incoterms;
            }
        }

        // When Incoterm is updated, fetch available currencies
        if (Str::startsWith($property, 'tables.') && Str::endsWith($property, '.incoterm')) {
            $index = explode('.', $property)[1];
            $productId = $this->tables[$index]['product_id'];

            // Reset dependent fields
            $this->tables[$index]['currency'] = '';
            $this->tables[$index]['available_currencies'] = [];

            if ($productId && $value) {
                $currencies = QuotationItem::where('product_id', $productId)
                    ->where('incoterm', $value)
                    ->select('currency')
                    ->distinct()
                    ->pluck('currency')
                    ->toArray();

                $this->tables[$index]['available_currencies'] = $currencies;
            }
        }

        // When Currency is updated, fetch the final unit price
        if (Str::startsWith($property, 'tables.') && Str::endsWith($property, '.currency')) {
            $index = explode('.', $property)[1];
            $productId = $this->tables[$index]['product_id'];
            $incoterm = $this->tables[$index]['incoterm'];

            if ($productId && $incoterm && $value) {
                $latest = QuotationItem::where('product_id', $productId)
                    ->where('incoterm', $incoterm)
                    ->where('currency', $value)
                    ->latest()
                    ->first();

                if ($latest) {
                    $this->tables[$index]['unit_price'] = $latest->final_unit_price;
                    $this->tables[$index]['port'] = $latest->incoterm; // Fallback or sync
                }
            }
        }

        $this->cost_factor = $this->calculateCostFactor();
    }

    public function save(): void
    {
        $this->validate([
            'customer_name' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'tables' => 'required|array|min:1',
            'tables.*.product_id' => 'required',
            'tables.*.quantity' => 'required|numeric|min:0.0001',
            'cost_factor' => 'nullable|numeric|min:0',
            'global_discount' => 'nullable|numeric|min:0',
        ]);

        $subtotal = collect($this->tables)->sum(fn ($t) => ((float) ($t['quantity'] ?? 0)) * ((float) ($t['unit_price'] ?? 0)));
        $grandTotal = $subtotal + (float) $this->cost_factor - (float) $this->global_discount;

        $invoiceData = [
            'customer_name' => $this->customer_name,
            'business_name' => $this->business_name,
            'email' => $this->email,
            'invoice_date' => $this->invoice_date,
            'quotation_date' => $this->quotation_date,
            'contact_person' => $this->contact_person,
            'payment_term' => $this->payment_term,
            'customer_po_ref' => $this->customer_po_ref,
            'phone_number' => $this->phone_number,
            'fax_number' => $this->fax_number,
            'office_address' => $this->office_address,
            'subtotal' => $subtotal,
            'cost_factor' => (float) $this->cost_factor,
            'global_discount' => (float) $this->global_discount,
            'grand_total' => $grandTotal,
            'status' => 'draft',
        ];

        $invoice = Invoice::create($invoiceData);

        foreach ($this->tables as $table) {
            $invoice->items()->create([
                'product_id' => $table['product_id'],
                'port' => $table['port'] ?? null,
                'incoterm' => $table['incoterm'] ?? null,
                'currency' => $table['currency'] ?? null,
                'product_name' => $table['name'],
                'quantity' => $table['quantity'],
                'uom' => $table['uom'],
                'unit_price' => $table['unit_price'],
                'row_total' => ((float) ($table['quantity'] ?? 0)) * ((float) ($table['unit_price'] ?? 0)),
            ]);
        }

        Notification::make()
            ->success()
            ->title('Invoice Generated')
            ->body('The invoice has been created successfully.')
            ->send();

        $this->redirect(InvoiceResource::getUrl('index'));
    }
}
