<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'news_id',
        'image_path',
        'caption',
        'order',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news_images';

    /**
     * Get the news that owns the image.
     */
    public function news()
    {
        return $this->belongsTo(News::class);
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return null;
    }
}
