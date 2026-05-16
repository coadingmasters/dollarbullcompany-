<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use App\Models\LiveSessionEnrollment;
use App\Services\AgoraTokenService;
use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    public function index()
    {
        $sessions = LiveSession::with('admin')->latest()->get();

        $enrollments = LiveSessionEnrollment::where('user_id', auth()->id())
            ->get()
            ->keyBy('live_session_id');

        return view('frontend.live-sessions.index', compact('sessions', 'enrollments'));
    }

    public function show($id)
    {
        $session = LiveSession::with('admin')->findOrFail($id);
        $enrollment = LiveSessionEnrollment::where('live_session_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        return view('frontend.live-sessions.show', compact('session', 'enrollment'));
    }

    public function enroll($id)
    {
        $session = LiveSession::findOrFail($id);

        $alreadyEnrolled = LiveSessionEnrollment::where('live_session_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyEnrolled) {
            return back()->with('error', 'You are already enrolled in this session');
        }

        LiveSessionEnrollment::create([
            'live_session_id' => $id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'Enrolled successfully, please wait for admin approval');
    }

    public function join($id)
    {
        $session = LiveSession::findOrFail($id);

        // Check session is live
        if (!$session->isLive()) {
            return back()->with('error', 'This session is not live yet');
        }

        // Check enrollment exists and is approved
        $enrollment = LiveSessionEnrollment::where('live_session_id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'You are not approved to join this session');
        }

        $appId = config('services.agora.app_id');
        $channelName = $session->agora_channel_name;
        $uid = (int) auth()->id();
        $token = app(AgoraTokenService::class)->generateToken(
            $channelName,
            $uid,
            AgoraTokenService::ROLE_AUDIENCE
        );

        return view('frontend.live-sessions.join', compact(
            'session',
            'appId',
            'channelName',
            'token',
            'uid'
        ));
    }
}