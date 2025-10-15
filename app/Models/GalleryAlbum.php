<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryAlbum extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($album) {
            if (empty($album->slug)) {
                $album->slug = static::generateUniqueSlug($album->name);
            }
        });

        static::updating(function ($album) {
            if ($album->isDirty('name') && empty($album->slug)) {
                $album->slug = static::generateUniqueSlug($album->name);
            }
        });
    }

    /**
     * Generate a unique slug from name
     */
    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Get gallery items in this album
     */
    public function items()
    {
        return $this->hasMany(GalleryItem::class, 'album_id');
    }

    /**
     * Get ordered gallery items
     */
    public function orderedItems()
    {
        return $this->hasMany(GalleryItem::class, 'album_id')->orderBy('sort_order');
    }

    /**
     * Get image items only
     */
    public function images()
    {
        return $this->hasMany(GalleryItem::class, 'album_id')->where('type', 'image');
    }

    /**
     * Get video items only
     */
    public function videos()
    {
        return $this->hasMany(GalleryItem::class, 'album_id')->where('type', 'video');
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get the cover image URL
     */
    public function getCoverImageUrlAttribute(): ?string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        
        // If no cover image, use first item's image
        $firstItem = $this->items()->first();
        if ($firstItem) {
            return $firstItem->image_url;
        }
        
        return null;
    }

    /**
     * Get items count
     */
    public function getItemsCountAttribute(): int
    {
        return $this->items()->count();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}