<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value by key
     */
    public static function set($key, $value, $type = 'text')
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
            ]
        );

        // Clear cache
        Cache::forget("setting_{$key}");

        return $setting;
    }

    /**
     * Get logo URL
     */
    public static function getLogo($type = 'site_logo')
    {
        $logo = self::get($type);
        
        if ($logo && Storage::disk('public')->exists($logo)) {
            return asset('storage/' . $logo);
        }

        // Return default logo
        return asset('images/logo-default.png');
    }

    /**
     * Get favicon URL
     */
    public static function getFavicon()
    {
        $favicon = self::get('site_favicon');
        
        if ($favicon && Storage::disk('public')->exists($favicon)) {
            return asset('storage/' . $favicon);
        }

        return asset('favicon.ico');
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
    }
}
