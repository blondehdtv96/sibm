<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk menyimpan balasan chatbot yang bisa dikelola admin
 */
class ChatbotResponse extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi mass assignment
     */
    protected $fillable = [
        'trigger_name',
        'title',
        'keywords',
        'response',
        'is_active',
        'priority',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * Scope untuk filter response yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk order berdasarkan prioritas
     */
    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }

    /**
     * Get keywords sebagai string (untuk form)
     */
    public function getKeywordsStringAttribute()
    {
        return is_array($this->keywords) ? implode(', ', $this->keywords) : '';
    }

    /**
     * Set keywords dari string (untuk form)
     */
    public function setKeywordsStringAttribute($value)
    {
        $this->attributes['keywords'] = json_encode(
            array_map('trim', explode(',', $value))
        );
    }
}
