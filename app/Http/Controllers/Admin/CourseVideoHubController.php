<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;

class CourseVideoHubController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('videos')->orderBy('title')->get();

        return view('admin.course-videos.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load('videos');

        return view('admin.course-videos.show', compact('course'));
    }
}
