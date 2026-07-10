<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceEditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'user_id',
        'changed_from',
        'changed_to',
    ];

    protected function casts(): array
    {
        return [
            'changed_from' => 'array',
            'changed_to' => 'array',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
