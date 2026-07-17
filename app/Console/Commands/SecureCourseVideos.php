<?php

namespace App\Console\Commands;

use App\Models\CourseVideo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SecureCourseVideos extends Command
{
    protected $signature = 'videos:secure {--dry-run : List what would move without touching any file}';

    protected $description = 'Move course videos off the public disk so they are only reachable through signed playback links';

    public function handle(): int
    {
        $public = Storage::disk(CourseVideo::LEGACY_DISK);
        $secure = Storage::disk(CourseVideo::DISK);
        $dryRun = (bool) $this->option('dry-run');

        $videos = CourseVideo::whereNotNull('video_path')->get();
        $moved = $skipped = $missing = 0;

        foreach ($videos as $video) {
            $path = $video->video_path;

            if ($secure->exists($path)) {
                // Already private. Drop any public leftover still serving it.
                if ($public->exists($path)) {
                    $dryRun ? $this->line("would delete public copy: {$path}") : $public->delete($path);
                }
                $skipped++;
                continue;
            }

            if (! $public->exists($path)) {
                $this->warn("missing file for video #{$video->id}: {$path}");
                $missing++;
                continue;
            }

            if ($dryRun) {
                $this->line("would move: {$path}");
                $moved++;
                continue;
            }

            // Stream the copy so large lessons don't have to fit in memory.
            $stream = $public->readStream($path);
            $secure->writeStream($path, $stream);

            if (is_resource($stream)) {
                fclose($stream);
            }

            if (! $secure->exists($path)) {
                $this->error("copy failed, leaving public copy in place: {$path}");
                continue;
            }

            $public->delete($path);
            $moved++;
            $this->line("moved: {$path}");
        }

        $this->newLine();
        $this->info(($dryRun ? '[dry run] ' : '') . "moved: {$moved}, already private: {$skipped}, missing: {$missing}");

        return self::SUCCESS;
    }
}
