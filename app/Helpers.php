<?php

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

if (! function_exists('getSetting')) {
    function getSetting(string $key, $group = null, $default = "")
    {
        try {
            $setting = DB::table('settings')->when($group, function ($query) use ($group) {
                $query->where('group', $group);
            })
                ->where('key', $key)
                ->first();

            return $setting->value ?? $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}
