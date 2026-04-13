<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'customer_name',
        'business_name',
        'email',
        'invoice_date',
        'quotation_date',
        'contact_person',
        'payment_term',
        'customer_po_ref',
        'phone_number',
        'fax_number',
        'office_address',
        'incoterm',
        'currency',
        'subtotal',
        'tax_total',
        'grand_total',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'invoice_date' => 'date',
            'quotation_date' => 'date',
            'subtotal' => 'decimal:4',
            'tax_total' => 'decimal:4',
            'grand_total' => 'decimal:4',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($invoice) {
            if (empty($invoice->reference_number)) {
                $latest = static::latest('id')->first();
                $nextId = $latest ? $latest->id + 1 : 1;
                $invoice->reference_number = 'INV-'.date('Ymd').'-'.str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
