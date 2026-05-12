<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $courseId = $this->route('course')?->id;
        
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses,slug' . ($courseId ? ",$courseId" : ''),

            'description' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',

            'level' => 'required|in:beginner,intermediate,advanced',

            'status' => 'required|in:draft,published,archived',

            'duration_in_weeks' => 'nullable|integer|min:1',

            'is_featured' => 'nullable|boolean',
        ];
    }
}