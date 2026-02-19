<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /** @use HasFactory<\Database\Factories\CurrencyFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'symbol',
        'exchange_rate',
        'is_base',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'exchange_rate' => 'decimal:8',
            'is_base' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Currency $currency) {
            if ($currency->is_base) {
                $currency->exchange_rate = 1.0;
                
                // Ensure only one base currency exists
                static::where('id', '!=', $currency->id)
                    ->where('is_base', true)
                    ->update(['is_base' => false]);
            } elseif ($currency->getOriginal('is_base') && $currency->exists) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'is_base' => 'The base currency cannot be unset. Please set another currency as base instead.',
                ]);
            }
        });

        static::deleted(function (Currency $currency) {
            if ($currency->is_base && static::count() > 0) {
                // Set the first remaining currency as base if the base was deleted
                static::first()?->update(['is_base' => true]);
            }
        });
    }

    /**
     * Convert amount from one currency to another.
     */
    public static function convert(float $amount, Currency $from, Currency $to): float
    {
        if ($from->id === $to->id) {
            return $amount;
        }

        // Formula: (Amount / From Rate) * To Rate
        return ($amount / (float) $from->exchange_rate) * (float) $to->exchange_rate;
    }

    /**
     * Get the base currency.
     */
    public static function getBase(): ?Currency
    {
        return static::where('is_base', true)->first() ?? static::first();
    }
}
