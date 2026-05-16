<?php

namespace App\Http\Middleware;

use App\Models\Course;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVerifiedCourseAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $student = auth('student')->user();
        $course = $request->route('course');

        if (! $student || ! $course instanceof Course) {
            return redirect()
                ->route('student.login', ['redirect' => $request->fullUrl()])
                ->with('error', 'Please log in to access course content.');
        }

        if (! $student->hasVerifiedAccessTo($course)) {
            return redirect()
                ->route('courses.frontend')
                ->with('error', 'You need admin approval for this course before viewing lessons. Enroll and wait for verification.');
        }

        return $next($request);
    }
}
