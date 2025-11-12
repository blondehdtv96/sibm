<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetencyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'competency_id',
        'image_path',
        'title',
        'description',
        'order',
        'status',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }

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
        return asset('storage/' . $this->image_path);
    }
}
