<?php

if (!function_exists('setting')) {
    /**
     * Get setting value from database
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}

if (!function_exists('storage_url')) {
    /**
     * Get URL for storage file (works without symlink)
     *
     * @param string|null $path
     * @param string|null $default
     * @return string
     */
    function storage_url($path, $default = null)
    {
        if (empty($path)) {
            return $default ? asset($default) : '';
        }
        
        // If already a full URL, return as-is
        if (str_starts_with($path, 'http')) {
            return $path;
        }
        
        // Remove 'storage/' prefix if present
        $path = preg_replace('/^storage\//', '', $path);
        
        // Use route-based URL which works even without symlink
        return url('/storage/' . $path);
    }
}
