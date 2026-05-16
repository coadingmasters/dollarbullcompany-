<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CourseVideo extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video_path',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::deleting(function (CourseVideo $video) {
            if ($video->video_path) {
                Storage::disk('public')->delete($video->video_path);
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getVideoUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->video_path);
    }
}
