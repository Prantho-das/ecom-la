<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incoterm extends Model
{
    protected $fillable = [
        'name',
        'code',
        'is_active',
        'has_export_freight',
        'has_export_clearance',
        'has_origin_thc',
        'has_int_freight',
        'has_insurance',
        'has_import_duties',
        'has_handling_charges',
        'has_inland_transport',
        'has_custom_cost_factor',
        'currency_defaults',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'has_export_freight' => 'boolean',
        'has_export_clearance' => 'boolean',
        'has_origin_thc' => 'boolean',
        'has_int_freight' => 'boolean',
        'has_insurance' => 'boolean',
        'has_import_duties' => 'boolean',
        'has_handling_charges' => 'boolean',
        'has_inland_transport' => 'boolean',
        'has_custom_cost_factor' => 'boolean',
        'currency_defaults' => 'array',
    ];
}
