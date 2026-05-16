<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseVideo;
use Illuminate\Http\Request;

class CourseVideoController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,webm,mov,avi,mkv|max:512000',
        ]);

        $path = $request->file('video')->store('course_videos', 'public');

        $course->videos()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'video_path' => $path,
            'sort_order' => ($course->videos()->max('sort_order') ?? 0) + 1,
        ]);

        return back()->with('success', 'Video uploaded successfully.');
    }

    public function destroy(Course $course, CourseVideo $video)
    {
        abort_unless($video->course_id === $course->id, 404);

        $video->delete();

        return back()->with('success', 'Video removed.');
    }
}
