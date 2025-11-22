<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavigationMenu extends Model
{
    protected $guarded = [];

    public function links(): HasMany
    {
        return $this->hasMany(NavigationLink::class)->orderBy('sort_order');
    }
}
