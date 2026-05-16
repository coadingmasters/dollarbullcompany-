<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        $intended = session('url.intended');

        if ($intended && ! str_contains($intended, '/admin')) {
            session()->forget('url.intended');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
  
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate();

        $intended = session()->pull('url.intended');

        if ($intended && str_contains($intended, '/admin')) {
            return redirect()->to($intended);
        }

        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}
    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }
}
