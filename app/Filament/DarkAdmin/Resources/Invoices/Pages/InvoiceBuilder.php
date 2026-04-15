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
        $this->incoterm = $invoice->incoterm;
        $this->currency = $invoice->currency;

        $this->tables = [];
        foreach ($invoice->items as $item) {
            $ports = QuotationItem::where('product_id', $item->product_id)
                ->whereNotNull('incoterm')
                ->select('incoterm', 'final_unit_price')
                ->distinct()
                ->get()
                ->toArray();

            $this->tables[] = [
                'id' => Str::uuid()->toString(),
                'product_id' => $item->product_id,
                'name' => $item->product_name,
                'port' => $item->port,
                'quantity' => $item->quantity,
                'uom' => $item->uom,
                'unit_price' => $item->unit_price,
                'available_ports' => $ports,
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
            'quantity' => 1,
            'uom' => 'UNIT',
            'unit_price' => 0,
            'available_ports' => [],
        ];
    }

    public function removeTable($id): void
    {
        $this->tables = collect($this->tables)->filter(fn ($t) => $t['id'] !== $id)->toArray();
        $this->tables = array_values($this->tables);
    }

    public function updated($property, $value): void
    {
        if (Str::startsWith($property, 'tables.') && Str::endsWith($property, '.product_id')) {
            $index = explode('.', $property)[1];
            $product = Product::find($value);

            if ($product) {
                $this->tables[$index]['name'] = $product->name;

                // Fetch all unique ports (incoterms) and their prices for this product
                $ports = QuotationItem::where('product_id', $value)
                    ->whereNotNull('incoterm')
                    ->select('incoterm', 'final_unit_price')
                    ->distinct()
                    ->get()
                    ->toArray();

                $this->tables[$index]['available_ports'] = $ports;

                if (! empty($ports)) {
                    // Set default to the latest one if available
                    $latest = collect($ports)->last();
                    $this->tables[$index]['port'] = $latest['incoterm'];
                    $this->tables[$index]['unit_price'] = $latest['final_unit_price'];
                } else {
                    $this->tables[$index]['port'] = '';
                    $this->tables[$index]['unit_price'] = $product->price ?? 0;
                }
            }
        }

        if (Str::startsWith($property, 'tables.') && Str::endsWith($property, '.port')) {
            $index = explode('.', $property)[1];
            $selectedPort = collect($this->tables[$index]['available_ports'])->firstWhere('incoterm', $value);

            if ($selectedPort) {
                $this->tables[$index]['unit_price'] = $selectedPort['final_unit_price'];
            }
        }
    }

    public function save(): void
    {
        $this->validate([
            'customer_name' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'tables' => 'required|array|min:1',
            'tables.*.product_id' => 'required',
            'tables.*.quantity' => 'required|numeric|min:0.0001',
        ]);

        $subtotal = collect($this->tables)->sum(fn ($t) => $t['quantity'] * $t['unit_price']);
        $grandTotal = $subtotal; // For now, grand total is subtotal

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
            'incoterm' => $this->incoterm,
            'currency' => $this->currency,
            'subtotal' => $subtotal,
            'grand_total' => $grandTotal,
            'status' => 'draft',
        ];

        $invoice = Invoice::create($invoiceData);

        foreach ($this->tables as $table) {
            $invoice->items()->create([
                'product_id' => $table['product_id'],
                'port' => $table['port'] ?? null,
                'product_name' => $table['name'],
                'quantity' => $table['quantity'],
                'uom' => $table['uom'],
                'unit_price' => $table['unit_price'],
                'row_total' => $table['quantity'] * $table['unit_price'],
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
