<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    protected $fillable = [
        'image',
        'mobile_image',
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

    public function getImageUrlAttribute(): string
    {
        return $this->resolveImageUrl($this->image);
    }

    public function getMobileImageUrlAttribute(): ?string
    {
        if (!$this->mobile_image) return null;
        return $this->resolveImageUrl($this->mobile_image);
    }

    private function resolveImageUrl(string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return url('storage/' . $path);
    }

    /** Only active slides, sorted by sort_order */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
