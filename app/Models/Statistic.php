<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $table = 'statistics';

    protected $fillable = [
        'label',
        'value',
        'suffix',
        'order',
        'status',
    ];

    public $timestamps = true;

    /**
     * Scope to get active statistics
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('order');
    }
}
