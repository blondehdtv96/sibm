<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class StaffProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug', 'name', 'gelar_depan', 'gelar_belakang', 'nip', 'nuptk', 'gender', 'religion',
        'birth_place', 'birth_date', 'position', 'category', 'jurusan', 'subjects',
        'employment_status', 'bio', 'email', 'phone', 'address', 'education',
        'education_history', 'certifications', 'competencies', 'experience', 'achievements',
        'motto', 'facebook', 'instagram', 'linkedin', 'youtube', 'website', 'photo',
        'sort_order', 'status', 'is_featured',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'sort_order' => 'integer',
        'is_featured' => 'boolean',
    ];

    protected $appends = ['display_name', 'photo_url'];

    public function images()
    {
        return $this->hasMany(StaffProfileImage::class)->orderBy('sort_order');
    }

    public function activeImages()
    {
        return $this->hasMany(StaffProfileImage::class)->active();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('name');
    }

    public function scopeSearch($query, ?string $term)
    {
        return $query->when($term, function ($query) use ($term) {
            $term = '%' . $term . '%';
            $query->where(function ($query) use ($term) {
                $query->where('name', 'like', $term)
                    ->orWhere('nip', 'like', $term)
                    ->orWhere('nuptk', 'like', $term)
                    ->orWhere('position', 'like', $term)
                    ->orWhere('subjects', 'like', $term)
                    ->orWhere('jurusan', 'like', $term)
                    ->orWhere('email', 'like', $term);
            });
        });
    }

    public function getDisplayNameAttribute(): string
    {
        $prefix = trim((string) $this->gelar_depan);
        $suffix = trim((string) $this->gelar_belakang);
        return trim(($prefix ? $prefix . ' ' : '') . $this->name . ($suffix ? ', ' . $suffix : ''));
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getRouteKey(): mixed
    {
        // Legacy records may not have a slug yet. Use the primary key temporarily
        // so URL generation does not fail before the backfill migration is run.
        return $this->getAttribute($this->getRouteKeyName()) ?: $this->getKey();
    }

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        $field ??= $this->getRouteKeyName();

        if ($field === 'slug' && is_scalar($value) && ctype_digit((string) $value)) {
            return $query->where(function ($query) use ($value) {
                $query->where('slug', (string) $value)->orWhere($this->getKeyName(), $value);
            });
        }

        return $query->where($field, $value);
    }

    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'profil-staf';
        $slug = $base;
        $counter = 2;

        while (static::withTrashed()->where('slug', $slug)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
