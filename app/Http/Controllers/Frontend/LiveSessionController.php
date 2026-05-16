<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use App\Models\LiveSessionEnrollment;
use App\Models\Student;
use App\Services\AgoraTokenService;
use App\Support\LiveSessionIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LiveSessionController extends Controller
{
    public function showRegister($id)
    {
        $session = LiveSession::findOrFail($id);
        return view('frontend.live-sessions.register', compact('session'));
    }

    public function register(Request $request, $id)
    {
        $session = LiveSession::findOrFail($id);

        $data = $request->validate([
            'first_name'         => 'required|string|max:255',
            'last_name'          => 'nullable|string|max:255',
            'email'              => 'required|email|max:255',
            'password'           => 'required|string|min:8|confirmed',
            'whatsapp_number'    => 'required|string|max:30',
            'country'            => 'required|string|max:100',
            'cicni'              => 'required|string|max:100',
            'face_photo'         => 'required|file|image|max:5120',
            'payment_screenshot' => 'required|file|image|max:5120',
        ]);

        $alreadyEnrolled = LiveSessionEnrollment::where('live_session_id', $id)
            ->where('email', $data['email'])
            ->exists();

        if ($alreadyEnrolled) {
            return back()->withErrors(['email' => 'You have already registered for this session.'])->withInput();
        }

        if ($request->hasFile('face_photo')) {
            $data['face_photo'] = $request->file('face_photo')->store('live_session_face_photos', 'public');
        }

        if ($request->hasFile('payment_screenshot')) {
            $data['payment_screenshot'] = $request->file('payment_screenshot')->store('live_session_payment_screenshots', 'public');
        }

        $name = trim($data['first_name'] . ' ' . ($data['last_name'] ?? ''));

        $student = Student::updateOrCreate(
            ['email' => $data['email']],
            ['name' => $name, 'password' => $data['password']]
        );

        $userId = LiveSessionIdentity::userIdForStudent($student);

        unset($data['password'], $data['password_confirmation']);

        LiveSessionEnrollment::create([
            'live_session_id'    => $session->id,
            'user_id'            => $userId,
            'status'             => 'pending',
            'enrolled_at'        => now(),
            'first_name'         => $data['first_name'],
            'last_name'          => $data['last_name'] ?? null,
            'email'              => $data['email'],
            'whatsapp_number'    => $data['whatsapp_number'],
            'country'            => $data['country'],
            'cicni'              => $data['cicni'],
            'face_photo'         => $data['face_photo'],
            'payment_screenshot' => $data['payment_screenshot'],
        ]);

        return redirect()->route('live-sessions.register.success', $session->id)
            ->with('success', 'Registration submitted! Admin will review and contact you within 48 hours.');
    }

    public function registerSuccess($id)
    {
        $session = LiveSession::findOrFail($id);
        return view('frontend.live-sessions.register-success', compact('session'));
    }

    public function index()
    {
        $userId = LiveSessionIdentity::currentUserId();

        $sessions = LiveSession::with('admin')->latest()->get();

        $enrollments = LiveSessionEnrollment::where('user_id', $userId)
            ->get()
            ->keyBy('live_session_id');

        return view('frontend.live-sessions.index', compact('sessions', 'enrollments'));
    }

    public function show($id)
    {
        $userId = LiveSessionIdentity::currentUserId();

        $session = LiveSession::with('admin')->findOrFail($id);
        $enrollment = LiveSessionEnrollment::where('live_session_id', $id)
            ->where('user_id', $userId)
            ->first();

        return view('frontend.live-sessions.show', compact('session', 'enrollment'));
    }

    public function enroll($id)
    {
        $userId = LiveSessionIdentity::currentUserId();

        LiveSession::findOrFail($id);

        $alreadyEnrolled = LiveSessionEnrollment::where('live_session_id', $id)
            ->where('user_id', $userId)
            ->exists();

        if ($alreadyEnrolled) {
            return back()->with('error', 'You are already enrolled in this session');
        }

        LiveSessionEnrollment::create([
            'live_session_id' => $id,
            'user_id' => $userId,
            'status' => 'pending',
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'Enrolled successfully, please wait for admin approval');
    }

    public function join($id)
    {
        $userId = LiveSessionIdentity::currentUserId();

        $session = LiveSession::findOrFail($id);

        if (! $session->isLive()) {
            return back()->with('error', 'This session is not live yet');
        }

        $enrollment = LiveSessionEnrollment::where('live_session_id', $id)
            ->where('user_id', $userId)
            ->where('status', 'approved')
            ->first();

        if (! $enrollment) {
            return back()->with('error', 'You are not approved to join this session');
        }

        $appId = config('services.agora.app_id');
        $channelName = $session->agora_channel_name;
        $uid = $userId;
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
