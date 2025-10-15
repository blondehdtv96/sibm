<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'registration_start',
        'registration_end',
        'requirements',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'registration_start' => 'date',
        'registration_end' => 'date',
        'requirements' => 'array',
    ];

    /**
     * Scope to get active settings
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get inactive settings
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Get the current active PPDB setting
     */
    public static function current(): ?self
    {
        return static::active()->first();
    }

    /**
     * Check if registration is currently open
     */
    public static function isRegistrationOpen(): bool
    {
        $setting = static::current();
        
        if (!$setting) {
            return false;
        }
        
        $now = now()->toDateString();
        return $now >= $setting->registration_start->toDateString() 
               && $now <= $setting->registration_end->toDateString();
    }

    /**
     * Check if this setting is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if this setting is inactive
     */
    public function isInactive(): bool
    {
        return $this->status === 'inactive';
    }

    /**
     * Check if registration period is currently open
     */
    public function isOpen(): bool
    {
        if (!$this->isActive()) {
            return false;
        }
        
        $now = now()->toDateString();
        return $now >= $this->registration_start->toDateString() 
               && $now <= $this->registration_end->toDateString();
    }

    /**
     * Check if registration period has not started yet
     */
    public function isUpcoming(): bool
    {
        return $this->isActive() && now()->toDateString() < $this->registration_start->toDateString();
    }

    /**
     * Check if registration period has ended
     */
    public function isClosed(): bool
    {
        return $this->isActive() && now()->toDateString() > $this->registration_end->toDateString();
    }

    /**
     * Get days remaining until registration starts
     */
    public function getDaysUntilStartAttribute(): int
    {
        if ($this->isUpcoming()) {
            return now()->diffInDays($this->registration_start);
        }
        return 0;
    }

    /**
     * Get days remaining until registration ends
     */
    public function getDaysUntilEndAttribute(): int
    {
        if ($this->isOpen()) {
            return now()->diffInDays($this->registration_end);
        }
        return 0;
    }

    /**
     * Get formatted registration period
     */
    public function getFormattedPeriodAttribute(): string
    {
        return $this->registration_start->format('d F Y') . ' - ' . $this->registration_end->format('d F Y');
    }
}