<?php

namespace App\Support;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;

class LiveSessionIdentity
{
    /**
     * Live session enrollments use user_id — map the logged-in student to a users row.
     */
    public static function userIdForStudent(Student $student): int
    {
        $user = User::query()->where('email', $student->email)->first();

        if ($user) {
            if ($user->name !== $student->name) {
                $user->update(['name' => $student->name]);
            }

            return $user->id;
        }

        return User::query()->create([
            'name' => $student->name,
            'email' => $student->email,
            'password' => Str::password(32),
        ])->id;
    }

    public static function currentUserId(): int
    {
        $student = auth('student')->user();

        if (! $student instanceof Student) {
            abort(403, 'Student login required.');
        }

        return self::userIdForStudent($student);
    }
}
