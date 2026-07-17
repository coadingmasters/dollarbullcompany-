<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CourseVideo extends Model
{
    /** Videos live outside the web root so they have no directly reachable URL. */
    public const DISK = 'local';

    /** Where videos sat before playback moved behind signed URLs. */
    public const LEGACY_DISK = 'public';

    /** Long enough to finish a lesson, short enough that a copied link dies quickly. */
    public const LINK_TTL_MINUTES = 360;

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
                Storage::disk($video->diskName())->delete($video->video_path);
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * The disk actually holding this file. Videos uploaded before the move to
     * private storage stay readable from the public disk until `videos:secure` runs.
     */
    public function diskName(): string
    {
        if ($this->video_path
            && ! Storage::disk(self::DISK)->exists($this->video_path)
            && Storage::disk(self::LEGACY_DISK)->exists($this->video_path)) {
            return self::LEGACY_DISK;
        }

        return self::DISK;
    }

    public function fileExists(): bool
    {
        return (bool) $this->video_path && Storage::disk($this->diskName())->exists($this->video_path);
    }

    public function absolutePath(): string
    {
        return Storage::disk($this->diskName())->path($this->video_path);
    }

    /**
     * A short-lived signed link instead of a permanent public file URL, so a
     * copied address stops working and never reveals where the file lives.
     *
     * Deliberately relative: this host sits behind a proxy without trusted
     * headers, so an absolute URL would sign the wrong scheme — breaking the
     * signature, or emitting an http:// link that an https page refuses to load.
     */
    public function getVideoUrlAttribute(): string
    {
        return URL::temporarySignedRoute(
            'courses.video',
            now()->addMinutes(self::LINK_TTL_MINUTES),
            [
                'course' => $this->course->slug,
                'video'  => $this->getKey(),
            ],
            absolute: false,
        );
    }
}
