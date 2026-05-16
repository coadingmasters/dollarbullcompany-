<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(CourseRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('course_thumbnails', 'public');
        } else {
            unset($data['thumbnail']);
        }

        $data['slug'] = Str::slug($data['slug']);

        $data['is_featured'] = $request->has('is_featured');

        Course::create($data);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course created successfully!');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $course->load('videos');

        return view('courses.edit', compact('course'));
    }

    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('course_thumbnails', 'public');
        } else {
            unset($data['thumbnail']);
        }

        $data['is_featured'] = $request->has('is_featured');

        $course->update($data);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}