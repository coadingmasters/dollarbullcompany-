<?php

namespace App\Http\Controllers;

use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthController extends Controller
{
    public function showLogin(Request $request)
    {
        return view('frontend.student.login', [
            'redirect' => $request->query('redirect'),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::guard('student')->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }

        $hasVerified = CourseEnrollment::query()
            ->where('email', $credentials['email'])
            ->where('status', 'verified')
            ->exists();

        if (! $hasVerified) {
            Auth::guard('student')->logout();

            return back()
                ->withErrors(['email' => 'Your enrollment is pending admin approval. You can log in after you are verified.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $redirect = $request->input('redirect', route('courses.frontend'));

        return redirect()->to($redirect);
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('courses.frontend');
    }
}
