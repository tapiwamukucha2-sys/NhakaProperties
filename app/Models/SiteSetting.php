<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'value'])]
class SiteSetting extends Model
{
    public static function get(string $key, string $default = ''): string
    {
        return Cache::rememberForever("site_setting:{$key}", function () use ($key, $default) {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    public static function set(string $key, string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("site_setting:{$key}");
    }

    public static function defaults(): array
    {
        return [
            'category_rent_desc' => 'Rooms, cottages, flats and full houses — updated daily.',
            'category_buy_desc' => 'Freehold and cluster homes across every province.',
            'category_land_desc' => 'Residential and agricultural stands, title-verified.',
            'category_commercial_desc' => 'Shops, offices and warehouses ready to lease or buy.',
            'trust_heading' => 'Verified means someone actually checked.',
            'trust_lede' => 'Fake listings and disappearing "agents" are the biggest complaint about property hunting in Zimbabwe. Every verified badge means we\'ve confirmed the agent\'s ID and, for sale listings, the title documents.',
        ];
    }
}
