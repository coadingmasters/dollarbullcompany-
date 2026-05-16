<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use App\Models\LiveSessionEnrollment;
use App\Events\SessionWentLive;
use App\Events\SessionEnded;
use App\Services\AgoraTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LiveSessionController extends Controller
{
    public function index()
    {
        $sessions = LiveSession::withCount('enrollments')
            ->latest()
            ->get();
        return view('admin.live-sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin.live-sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);

        LiveSession::create([
            'title' => $request->title,
            'description' => $request->description,
            'scheduled_at' => $request->scheduled_at,
            'admin_id' => auth('admin')->id(),
            'agora_channel_name' => Str::slug($request->title) . '-' . Str::random(6),
        ]);

        return redirect()->route('admin.live-sessions.index')
            ->with('success', 'Live session created successfully');
    }

    public function show($id)
    {
        $session = LiveSession::with('enrollments.user')->findOrFail($id);
        return view('admin.live-sessions.show', compact('session'));
    }

    public function edit($id)
    {
        $session = LiveSession::findOrFail($id);
        return view('admin.live-sessions.edit', compact('session'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);

        $session = LiveSession::findOrFail($id);
        $session->update([
            'title' => $request->title,
            'description' => $request->description,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return redirect()->route('admin.live-sessions.index')
            ->with('success', 'Live session updated successfully');
    }

    public function destroy($id)
    {
        $session = LiveSession::findOrFail($id);
        $session->delete();
        return redirect()->route('admin.live-sessions.index')
            ->with('success', 'Live session deleted successfully');
    }

    public function goLive($id)
    {
        $session = LiveSession::findOrFail($id);

        if ($session->isLive()) {
            return redirect()->route('admin.live-sessions.broadcast', $id)
                ->with('info', 'Session is already live.');
        }

        $session->update([
            'status' => 'live',
            'started_at' => now(),
        ]);

        broadcast(new SessionWentLive($session));

        return redirect()->route('admin.live-sessions.broadcast', $id)
            ->with('success', 'Session is now live — your broadcast studio is ready.');
    }

    public function broadcast($id)
    {
        $session = LiveSession::findOrFail($id);

        if (! $session->isLive()) {
            return redirect()->route('admin.live-sessions.show', $id)
                ->with('error', 'Session is not live yet. Click Go Live first.');
        }

        try {
            $appId       = config('services.agora.app_id');
            $channelName = $session->agora_channel_name;
            $uid         = (int) auth('admin')->id();
            $token       = app(AgoraTokenService::class)->generateToken(
                $channelName,
                $uid,
                AgoraTokenService::ROLE_HOST
            );
        } catch (\RuntimeException $e) {
            return redirect()->route('admin.live-sessions.show', $id)
                ->with('error', 'Agora credentials are not configured. Cannot start broadcast.');
        }

        $approvedCount = LiveSessionEnrollment::where('live_session_id', $id)
            ->where('status', 'approved')
            ->count();

        return view('admin.live-sessions.broadcast', compact(
            'session', 'appId', 'channelName', 'token', 'uid', 'approvedCount'
        ));
    }

    public function endSession($id)
    {
        $session = LiveSession::findOrFail($id);

        $session->update([
            'status' => 'ended',
            'ended_at' => now(),
        ]);

        broadcast(new SessionEnded($session));

        return back()->with('success', 'Session has ended');
    }

    public function approveEnrollment($id, $enrollmentId)
    {
        $enrollment = LiveSessionEnrollment::findOrFail($enrollmentId);
        $enrollment->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Enrollment approved successfully');
    }

    public function rejectEnrollment($id, $enrollmentId)
    {
        $enrollment = LiveSessionEnrollment::findOrFail($enrollmentId);
        $enrollment->update(['status' => 'rejected']);

        return back()->with('success', 'Enrollment rejected');
    }

    public function enrollmentsIndex()
    {
        $enrollments = LiveSessionEnrollment::with('liveSession')
            ->latest()
            ->get();

        $total   = $enrollments->count();
        $pending  = $enrollments->where('status', 'pending')->count();
        $approved = $enrollments->where('status', 'approved')->count();
        $rejected = $enrollments->where('status', 'rejected')->count();

        return view('admin.live-session-enrollments', compact('enrollments', 'total', 'pending', 'approved', 'rejected'));
    }

    public function approveEnrollmentDirect($enrollmentId)
    {
        $enrollment = LiveSessionEnrollment::findOrFail($enrollmentId);
        $enrollment->update(['status' => 'approved', 'approved_at' => now()]);

        return back()->with('success', 'Enrollment approved successfully');
    }

    public function rejectEnrollmentDirect($enrollmentId)
    {
        $enrollment = LiveSessionEnrollment::findOrFail($enrollmentId);
        $enrollment->update(['status' => 'rejected']);

        return back()->with('success', 'Enrollment rejected');
    }

}