<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public function getSettings(string $group)
    {
        return Cache::remember("settings.{$group}", 60, function () use ($group) {
            return Setting::where('group', $group)->pluck('value', 'key');
        });
    }
}
