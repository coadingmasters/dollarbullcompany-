<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'thumbnail',
        'level',
        'status',
        'duration_in_weeks',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'duration_in_weeks' => 'integer',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Course $course) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $course->videos->each->delete();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function videos(): HasMany
    {
        return $this->hasMany(CourseVideo::class)->orderBy('sort_order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (! $this->thumbnail) {
            return null;
        }

        if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
            return $this->thumbnail;
        }

        return Storage::disk('public')->url($this->thumbnail);
    }
}
