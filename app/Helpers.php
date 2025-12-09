<?php

use App\Models\Setting;

if (! function_exists('getSetting')) {
    function getSetting(string $key, $group = null, $default = "")
    {
        $setting = DB::table('settings')->when($group, function ($query) use ($group) {
            $query->where('group', $group);
        })
            ->where('key', $key)
            ->first();
        return $setting->value ?? $default;
    }
}
