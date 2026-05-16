<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseCatalogController extends Controller
{
    public function index()
    {
        return view('frontend.courses', [
            'levels' => ['beginner', 'intermediate', 'advanced'],
        ]);
    }

    public function search(Request $request)
    {
        $query = Course::query()
            ->where('status', 'published')
            ->withCount('videos');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('level') && in_array($request->level, ['beginner', 'intermediate', 'advanced'], true)) {
            $query->where('level', $request->level);
        }

        $courses = $query->latest()->get()->map(function (Course $course) {
            $student = auth('student')->user();
            $hasAccess = $student && $student->hasVerifiedAccessTo($course);

            return [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug,
                'description' => \Illuminate\Support\Str::limit($course->description ?? '', 120),
                'price' => number_format($course->price, 0),
                'level' => ucfirst($course->level),
                'level_raw' => $course->level,
                'duration' => $course->duration_in_weeks ? $course->duration_in_weeks . 'w' : 'Flex',
                'thumbnail' => $course->thumbnail_url,
                'videos_count' => $course->videos_count,
                'enroll_url' => route('courses.enroll.show', $course),
                'learn_url' => route('courses.learn', $course),
                'has_access' => $hasAccess,
                'is_logged_in' => (bool) $student,
            ];
        });

        return response()->json(['courses' => $courses]);
    }
}
