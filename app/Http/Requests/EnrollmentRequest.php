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
            'cicni'           => 'required|string|max:50',
            'face_photo'      => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }
}