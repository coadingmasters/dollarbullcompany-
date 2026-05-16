<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseVideo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CourseVideoController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $maxKb = config('courses.video_max_kb', 204800);
        $mimes = config('courses.video_mimes', 'mp4,webm,mov,avi,mkv');

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'video' => "required|file|mimes:{$mimes}|max:{$maxKb}",
        ], [
            'video.max' => 'The video is too large. Maximum allowed size is ' . (int) ($maxKb / 1024) . ' MB.',
            'video.uploaded' => 'Upload failed. The file may exceed your server limit (check PHP upload_max_filesize and post_max_size).',
        ]);

        $file = $request->file('video');

        if (! $file || ! $file->isValid()) {
            throw ValidationException::withMessages([
                'video' => 'Upload failed before the file could be saved. Try a smaller file or restart the dev server with higher PHP limits.',
            ]);
        }

        $path = $file->store('course_videos', 'public');

        if (! $path) {
            throw ValidationException::withMessages([
                'video' => 'Could not save the video file. Check that storage/app/public is writable.',
            ]);
        }

        $course->videos()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'video_path' => $path,
            'sort_order' => ($course->videos()->max('sort_order') ?? 0) + 1,
        ]);

        if ($request->headers->get('referer') && str_contains($request->headers->get('referer'), 'course-videos')) {
            return redirect()
                ->route('admin.course-videos.show', $course)
                ->with('success', 'Video uploaded successfully.');
        }

        return back()->with('success', 'Video uploaded successfully.');
    }

    public function destroy(Course $course, CourseVideo $video)
    {
        abort_unless($video->course_id === $course->id, 404);

        $video->delete();

        return back()->with('success', 'Video removed.');
    }
}
