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
        // Use url() helper — it picks up the actual request scheme (http/https)
        // and real domain, so it works on live HTTPS sites without mixed-content errors.
        // Storage::disk('public')->url() uses APP_URL which can be wrong on live servers.
        return url('storage/' . $this->video_path);
    }
}
