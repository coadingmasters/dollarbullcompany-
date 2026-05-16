<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseLearnController extends Controller
{
    public function show(Course $course)
    {
        abort_unless($course->status === 'published', 404);

        $course->load('videos');

        return view('frontend.course-learn', compact('course'));
    }
}
