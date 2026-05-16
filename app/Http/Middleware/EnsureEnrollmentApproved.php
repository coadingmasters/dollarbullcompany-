<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LiveSessionEnrollment;

class EnsureEnrollmentApproved
{
    public function handle(Request $request, Closure $next)
    {
        $sessionId = $request->route('id');

        $enrollment = LiveSessionEnrollment::where('live_session_id', $sessionId)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            return redirect()->back()->with('error', 'You do not have approved access to this session');
        }

        return $next($request);
    }
}