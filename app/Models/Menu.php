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
            return route($this->route_name);
        }
        return $this->url ?: '#';
    }
}
