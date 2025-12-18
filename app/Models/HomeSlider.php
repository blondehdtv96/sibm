<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomeSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'order',
        'status',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return asset('images/placeholder-slider.jpg');
        }
        
        // Check if it's already a full URL
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        
        // Use Storage::url() for proper URL generation
        // This handles both local and cloud storage
        return Storage::url($this->image_path);
    }
    
    /**
     * Check if image file exists
     */
    public function imageExists(): bool
    {
        if (!$this->image_path) {
            return false;
        }
        
        return Storage::disk('public')->exists($this->image_path);
    }
}
