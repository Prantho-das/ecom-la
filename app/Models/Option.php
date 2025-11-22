<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /** Option belongs to a Product */
   

    /** Option has many Option Values */
    public function optionValues()
    {
        return $this->hasMany(OptionValue::class);
    }
    public function values()
{
    return $this->hasMany(OptionValue::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}

}
