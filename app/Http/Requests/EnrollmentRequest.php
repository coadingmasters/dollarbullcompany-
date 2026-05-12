<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'nullable|string|max:100',
            'email'           => 'required|email|unique:enrollments,email',
            'whatsapp_number' => 'required|string|max:20',
            'country'         => 'required|string|max:100',
            'experience'      => 'required|in:less_than_6_months,more_than_6_months',
            'enrollment_type' => 'required|in:online_lectures',
            'course'          => 'required|string',
            'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }
}