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
        'cost_factor',
        'global_discount',
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
            'cost_factor' => 'decimal:4',
            'global_discount' => 'decimal:4',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($invoice) {
            if (empty($invoice->reference_number)) {
                $business = trim($invoice->business_name ?? '');
                $contact = trim($invoice->contact_person ?? '');

                $businessInitials = '';
                if (! empty($business)) {
                    $words = preg_split('/[\s\-_]+/', $business);
                    foreach ($words as $word) {
                        if (empty($word)) {
                            continue;
                        }
                        if (ctype_upper($word)) {
                            $businessInitials .= $word;
                        } else {
                            $businessInitials .= mb_strtoupper(mb_substr($word, 0, 1));
                        }
                    }
                } else {
                    $businessInitials = 'INV';
                }

                $contactInitials = '';
                if (! empty($contact)) {
                    $words = preg_split('/[\s\-_]+/', $contact);
                    foreach ($words as $word) {
                        if (empty($word)) {
                            continue;
                        }
                        if (ctype_upper($word)) {
                            $contactInitials .= $word;
                        } else {
                            $contactInitials .= mb_strtoupper(mb_substr($word, 0, 1));
                        }
                    }
                }

                $prefix = $businessInitials;
                if (! empty($contactInitials)) {
                    $prefix .= ' - '.$contactInitials;
                }

                $dateStr = $invoice->invoice_date ? \Illuminate\Support\Carbon::parse($invoice->invoice_date)->format('dmY') : date('dmY');
                $timeStr = now()->format('g:i A');

                $invoice->reference_number = "{$prefix} [{$dateStr}] - {$timeStr}";
            }
        });

        static::saving(function ($invoice) {
            $invoice->grand_total = ($invoice->subtotal ?? 0) + ($invoice->cost_factor ?? 0) - ($invoice->global_discount ?? 0);
        });

        static::updating(function ($invoice) {
            if ($invoice->isDirty(['cost_factor', 'global_discount'])) {
                $invoice->editLogs()->create([
                    'user_id' => auth()->id(),
                    'changed_from' => [
                        'cost_factor' => $invoice->getOriginal('cost_factor') ?? 0,
                        'global_discount' => $invoice->getOriginal('global_discount') ?? 0,
                    ],
                    'changed_to' => [
                        'cost_factor' => $invoice->cost_factor ?? 0,
                        'global_discount' => $invoice->global_discount ?? 0,
                    ],
                ]);
            }
        });
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function editLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(InvoiceEditLog::class);
    }
}
