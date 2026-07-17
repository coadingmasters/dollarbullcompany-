<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseVideo;

class CourseLearnController extends Controller
{
    public function show(Course $course)
    {
        abort_unless($course->status === 'published', 404);

        $course->load('videos');

        // Each video builds its own signed URL from the course slug — hand them the
        // course we already have so they don't each re-query for it.
        $course->videos->each->setRelation('course', $course);

        return view('frontend.course-learn', compact('course'));
    }

    /**
     * Stream a lesson. Reached only through a signed link by a student the
     * `verified.course` middleware has already approved for this course.
     */
    public function stream(Course $course, CourseVideo $video)
    {
        abort_unless($course->status === 'published', 404);
        abort_unless($video->course_id === $course->id, 404);
        abort_unless($video->fileExists(), 404);

        // BinaryFileResponse answers Range requests itself, which is what keeps
        // seeking working without handing over the whole file.
        return response()->file($video->absolutePath(), [
            'Cache-Control'           => 'private, no-store, max-age=0',
            'Content-Disposition'     => 'inline',
            'X-Content-Type-Options'  => 'nosniff',
            'X-Robots-Tag'            => 'noindex, nofollow',
        ]);
    }
}
