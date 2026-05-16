<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseEnrollmentRequest;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Student;
use Illuminate\Http\Request;

class CourseEnrollmentController extends Controller
{
    public function showEnroll(Course $course)
    {
        abort_unless($course->status === 'published', 404);

        return view('frontend.course-enroll', compact('course'));
    }

    public function store(CourseEnrollmentRequest $request, Course $course)
    {
        abort_unless($course->status === 'published', 404);

        $this->persistEnrollment($request, $course);

        return redirect()
            ->route('courses.enroll.success', $course)
            ->with('success', 'Enrollment submitted! We will contact you within 48 hours.');
    }

    public function successPage(Course $course)
    {
        abort_unless($course->status === 'published', 404);

        return view('enrollments.course-success', compact('course'));
    }

    public function adminIndex(Request $request)
    {
        $query = CourseEnrollment::with('course')->latest();

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $enrollments = $query->get();
        $courses = Course::orderBy('title')->get();

        return view('admin.course-enrollments', compact('enrollments', 'courses'));
    }

    public function verify(CourseEnrollment $courseEnrollment)
    {
        $courseEnrollment->update(['status' => 'verified']);

        return back()->with('success', 'Student enrollment approved! They can log in and view course videos.');
    }

    public function reject(CourseEnrollment $courseEnrollment)
    {
        $courseEnrollment->update(['status' => 'rejected']);

        return back()->with('success', 'Student enrollment rejected!');
    }

    protected function persistEnrollment(CourseEnrollmentRequest $request, Course $course): void
    {
        $data = $request->validated();
        abort_if((int) $data['course_id'] !== $course->id, 422);
        $data['course_id'] = $course->id;

        if ($request->hasFile('payment_screenshot')) {
            $data['payment_screenshot'] = $request->file('payment_screenshot')
                ->store('course_payment_screenshots', 'public');
        }

        if ($request->hasFile('face_photo')) {
            $data['face_photo'] = $request->file('face_photo')
                ->store('course_face_photos', 'public');
        }

        $name = trim($data['first_name'] . ' ' . ($data['last_name'] ?? ''));

        Student::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $name,
                'password' => $data['password'],
            ]
        );

        unset($data['password'], $data['password_confirmation']);

        CourseEnrollment::create($data);
    }
}
