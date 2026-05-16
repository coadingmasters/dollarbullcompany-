<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function hasVerifiedAccessTo(Course $course): bool
    {
        return CourseEnrollment::query()
            ->where('course_id', $course->id)
            ->where('email', $this->email)
            ->where('status', 'verified')
            ->exists();
    }

    public function verifiedEnrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class, 'email', 'email')
            ->where('status', 'verified');
    }
}
