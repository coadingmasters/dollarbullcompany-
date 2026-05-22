<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    protected $fillable = [
        'image',
        'badge',
        'headline',
        'highlight',
        'sub',
        'btn1_label',
        'btn1_url',
        'btn2_label',
        'btn2_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Returns a browser-safe image URL whether the image is a
     * storage path ("images/sliders/xxx.jpg") or an external URL.
     */
    public function getImageUrlAttribute(): string
    {
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        return url('storage/' . $this->image);
    }

    /** Only active slides, sorted by sort_order */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
