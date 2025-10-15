<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbRegistration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'registration_number',
        'student_name',
        'email',
        'phone',
        'birth_date',
        'address',
        'parent_name',
        'parent_phone',
        'documents',
        'status',
        'verified_at',
        'verified_by',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'documents' => 'array',
        'verified_at' => 'datetime',
        'verified_by' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->registration_number)) {
                $registration->registration_number = static::generateRegistrationNumber();
            }
        });
    }

    /**
     * Generate unique registration number
     */
    public static function generateRegistrationNumber(): string
    {
        $year = date('Y');
        $prefix = 'PPDB' . $year;
        
        // Get the last registration number for this year
        $lastRegistration = static::where('registration_number', 'like', $prefix . '%')
                                  ->orderBy('registration_number', 'desc')
                                  ->first();
        
        if ($lastRegistration) {
            $lastNumber = (int) substr($lastRegistration->registration_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the user who verified this registration
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Alias for verifier relationship
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope to get pending registrations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get verified registrations
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope to get rejected registrations
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check if registration is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if registration is verified
     */
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    /**
     * Check if registration is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Verify the registration
     */
    public function verify(int $verifierId, string $notes = null): void
    {
        $this->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => $verifierId,
            'notes' => $notes,
        ]);
    }

    /**
     * Reject the registration
     */
    public function reject(int $verifierId, string $notes = null): void
    {
        $this->update([
            'status' => 'rejected',
            'verified_at' => now(),
            'verified_by' => $verifierId,
            'notes' => $notes,
        ]);
    }

    /**
     * Get document URL
     */
    public function getDocumentUrl(string $documentKey): ?string
    {
        if (isset($this->documents[$documentKey])) {
            return asset('storage/' . $this->documents[$documentKey]);
        }
        return null;
    }

    /**
     * Get formatted birth date
     */
    public function getFormattedBirthDateAttribute(): string
    {
        return $this->birth_date->format('d F Y');
    }

    /**
     * Get age from birth date
     */
    public function getAgeAttribute(): int
    {
        return $this->birth_date->diffInYears(now());
    }
}