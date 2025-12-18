<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'route_name',
        'parent_id',
        'order',
        'icon',
        'target',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getFullUrlAttribute()
    {
        if ($this->route_name) {
            try {
                // Check if route exists before generating URL
                if (\Route::has($this->route_name)) {
                    return route($this->route_name);
                }
                
                // Try common route name variations
                $alternativeRoutes = [
                    'competencies.index' => 'public.competencies.index',
                    'competency.index' => 'public.competencies.index',
                    'news.index' => 'public.news.index',
                    'gallery.index' => 'public.gallery.index',
                    'pages.show' => 'public.pages.show',
                ];
                
                if (isset($alternativeRoutes[$this->route_name]) && \Route::has($alternativeRoutes[$this->route_name])) {
                    return route($alternativeRoutes[$this->route_name]);
                }
                
                // Route doesn't exist, fallback to URL
                if ($this->url && $this->url !== '#') {
                    return url($this->url);
                }
                
                return '#';
            } catch (\Exception $e) {
                // If any error occurs, fallback to URL
                if ($this->url && $this->url !== '#') {
                    return url($this->url);
                }
                return '#';
            }
        }
        
        // No route_name, use URL directly
        if ($this->url && $this->url !== '#') {
            // If URL starts with http, use as-is, otherwise prepend base URL
            if (str_starts_with($this->url, 'http')) {
                return $this->url;
            }
            return url($this->url);
        }
        
        return '#';
    }
}
