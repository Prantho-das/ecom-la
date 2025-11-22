<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Helper for logo URL
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset('storage/brands/' . $this->logo_path) : asset('images/placeholder-brand.png');
    }
}
