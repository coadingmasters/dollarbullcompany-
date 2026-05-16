<?php

namespace App\Http\Middleware;

use App\Models\LiveSessionEnrollment;
use App\Support\LiveSessionIdentity;
use Closure;
use Illuminate\Http\Request;

class EnsureEnrollmentApproved
{
    public function handle(Request $request, Closure $next)
    {
        $sessionId = $request->route('id');
        $userId = LiveSessionIdentity::currentUserId();

        $enrollment = LiveSessionEnrollment::where('live_session_id', $sessionId)
            ->where('user_id', $userId)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            return redirect()->back()->with('error', 'You do not have approved access to this session');
        }

        return $next($request);
    }
}
