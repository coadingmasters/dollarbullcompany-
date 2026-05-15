<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        return view('enrollments.index');
    }

    public function store(EnrollmentRequest $request)
    {
        $data = $request->validated();
        $data['course'] = 'Advanced Liquidity Bootcamp Batch 23';

        if ($request->hasFile('payment_screenshot')) {
            $data['payment_screenshot'] = $request->file('payment_screenshot')
                ->store('payment_screenshots', 'public');
        }

        if ($request->hasFile('face_photo')) {
            $data['face_photo'] = $request->file('face_photo')
                ->store('face_photos', 'public');
        }

        Enrollment::create($data);

        return redirect()->route('enrollment.success')
            ->with('success', 'Enrollment submitted! We will contact you within 48 hours.');
    }

    public function success()
    {
        return view('enrollments.success');
    }

    // Admin endpoints
    public function adminIndex()
    {
        $enrollments = Enrollment::latest()->get();
        return view('admin.enrollments', compact('enrollments'));
    }

    public function verify(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'verified']);
        return back()->with('success', 'Enrollment verified!');
    }

    public function reject(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'rejected']);
        return back()->with('success', 'Enrollment rejected!');
    }
}