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

        if ($request->hasFile('payment_screenshot')) {
            $data['payment_screenshot'] = $request->file('payment_screenshot')
                ->store('payment_screenshots', 'public');
        }

        Enrollment::create($data);

        return redirect()->route('enrollment.success')
            ->with('success', 'Enrollment submitted! We will contact you within 48 hours.');
    }

    public function success()
    {
        return view('enrollments.success');
    }
}