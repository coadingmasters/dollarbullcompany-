<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CourseEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $courseId = $this->route('course')?->id ?? $this->input('course_id');

        return [
            'course_id' => 'required|exists:courses,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('course_enrollments', 'email')->where('course_id', $courseId),
            ],
            'whatsapp_number' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'cicni' => 'required|string|max:50',
            'password' => ['required', 'confirmed', Password::min(8)],
            'face_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }
}
