<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reseller extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country_id',
        'contact_person',
        'contact_email',
        'contact_phone',
        'status',
        'notes',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
