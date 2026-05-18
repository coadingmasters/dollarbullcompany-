@extends('layouts.frontend')

@section('title', 'Live Sessions — ' . config('app.name', 'CryptoOnly'))

@push('styles')
<style>
    :root { --gold:#C9A84C; --gold-light:#E8C97A; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
    .ls-page { padding: 20px 20px 56px; max-width: 1200px; margin: 0 auto; }

    /* ── Auth gate ── */
    .auth-gate { display: flex; justify-content: center; align-items: flex-start; padding: 40px 0 80px; }
    .auth-box { background: var(--card); border: 1px solid var(--border); padding: 44px 40px; width: 100%; max-width: 440px; }
    .auth-box-tag { font-family: Cinzel, serif; font-size: 9px; letter-spacing: .22em; color: var(--gold); border: 1px solid var(--border); padding: 4px 14px; display: inline-block; margin-bottom: 18px; }
    .auth-box h2 { font-family: Cinzel, serif; color: var(--gold-light); margin-bottom: 8px; font-size: 1.4rem; }
    .auth-box p { color: var(--muted); font-size: .85rem; margin-bottom: 24px; line-height: 1.55; }
    .auth-box label { display: block; font-size: .75rem; color: var(--muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .1em; }
    .auth-box input[type=email],
    .auth-box input[type=password] { width: 100%; padding: 10px 12px; margin-bottom: 16px; background: rgba(255,255,255,.03); border: 1px solid var(--border); color: var(--text); font-family: inherit; outline: none; transition: border-color .2s; }
    .auth-box input:focus { border-color: var(--gold); }
    .auth-box .remember { display: flex; align-items: center; gap: 8px; text-transform: none; letter-spacing: 0; font-size: .85rem; color: var(--muted); margin-bottom: 18px; }
    .auth-box .remember input { width: auto; margin: 0; }
    .auth-submit { width: 100%; padding: 12px; background: transparent; border: 1px solid var(--gold); color: var(--gold-light); font-family: Cinzel, serif; font-size: .78rem; letter-spacing: .12em; text-transform: uppercase; cursor: pointer; transition: background .25s, color .25s; }
    .auth-submit:hover { background: var(--gold); color: #0d0d0d; }
    .auth-err { color: #e07b73; font-size: .85rem; margin-bottom: 12px; }
    .auth-links { margin-top: 20px; display: flex; flex-direction: column; gap: 8px; }
    .auth-link { color: var(--muted); font-size: .85rem; }
    .auth-link a { color: var(--gold); text-decoration: none; }
    .auth-link a:hover { text-decoration: underline; }

    /* ── Student bar ── */
    .student-bar { display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--border); }
    .student-bar a, .student-bar button { color: var(--gold-light); font-size: .85rem; text-decoration: none; background: none; border: none; cursor: pointer; font-family: inherit; }
    .student-bar span { color: var(--muted); font-size: .85rem; }

    /* ── Browse notice ── */
    .browse-notice { background: rgba(201,168,76,.07); border: 1px solid var(--border); padding: 12px 18px; margin-bottom: 22px; font-size: .84rem; color: var(--muted); text-align: center; }
    .browse-notice a { color: var(--gold); text-decoration: none; }
    .browse-notice a:hover { text-decoration: underline; }

    /* ── Page header ── */
    .ls-hd { text-align: center; margin-bottom: 28px; }
    .ls-tag { display: inline-block; font-family: Cinzel, serif; font-size: 9px; letter-spacing: .22em; color: var(--gold); border: 1px solid var(--border); padding: 4px 14px; margin-bottom: 10px; }
    .ls-hd h1 { font-family: Cinzel, serif; font-size: clamp(1.4rem, 4vw, 2.2rem); color: #fff; }
    .ls-hd h1 em { color: var(--gold); font-style: normal; }

    /* ── Flash ── */
    .flash { padding: 12px 16px; margin-bottom: 20px; border: 1px solid var(--border); background: rgba(201,168,76,.08); color: var(--gold-light); }
    .flash.err { border-color: rgba(192,57,43,.4); color: #e07b73; background: rgba(192,57,43,.1); }

    /* ── Grid & cards ── */
    .ls-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; }
    .ls-card { background: var(--card); border: 1px solid var(--border); display: flex; flex-direction: column; transition: border-color .3s, transform .3s; }
    .ls-card:hover { border-color: rgba(201,168,76,.45); transform: translateY(-3px); }
    .ls-card-body { padding: 22px; flex: 1; display: flex; flex-direction: column; }
    .ls-card-title { font-family: Cinzel, serif; font-size: 1.05rem; color: #fff; margin-bottom: 10px; }
    .ls-card-desc { font-size: .85rem; color: var(--muted); line-height: 1.5; margin-bottom: 12px; flex: 1; }
    .ls-card-meta { font-size: .78rem; color: var(--muted); margin-bottom: 14px; }
    .ls-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; font-family: Cinzel, serif; font-size: 7px; letter-spacing: .14em; text-transform: uppercase; border: 1px solid transparent; margin-bottom: 12px; }
    .ls-badge-scheduled { background: rgba(255,193,7,.12); color: #ffd54f; border-color: rgba(255,193,7,.35); }
    .ls-badge-live { background: rgba(39,174,96,.15); color: #7dcea0; border-color: rgba(39,174,96,.4); }
    .ls-badge-ended { background: rgba(192,57,43,.15); color: #e07b73; border-color: rgba(192,57,43,.4); }
    .ls-live-dot { width: 6px; height: 6px; border-radius: 50%; background: #27ae60; animation: lsPulse 1.2s ease-in-out infinite; }
    @keyframes lsPulse { 0%, 100% { opacity: 1; } 50% { opacity: .35; } }
    .ls-card-actions { margin-top: auto; padding-top: 14px; border-top: 1px solid var(--border); }
    .ls-card-actions form { margin: 0; }
    .btn { display: block; width: 100%; text-align: center; padding: 10px; border: 1px solid var(--gold); color: var(--gold-light); font-family: Cinzel, serif; font-size: .68rem; letter-spacing: .14em; text-transform: uppercase; text-decoration: none; background: transparent; cursor: pointer; transition: background .25s, color .25s; }
    .btn:hover { background: var(--gold); color: #0d0d0d; }
    .ls-btn-primary { border-color: var(--gold); }
    .ls-btn-live { background: rgba(39,174,96,.12); border-color: rgba(39,174,96,.5); color: #7dcea0; display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
    .ls-btn-live:hover { background: rgba(39,174,96,.25); color: #fff; }
    .ls-pill { display: block; text-align: center; padding: 10px; font-family: Cinzel, serif; font-size: .65rem; letter-spacing: .12em; text-transform: uppercase; border: 1px solid var(--border); color: var(--muted); }
    .ls-pill-pending { color: #ffd54f; border-color: rgba(255,193,7,.35); background: rgba(255,193,7,.08); }
    .ls-pill-approved { color: #7dcea0; border-color: rgba(39,174,96,.35); background: rgba(39,174,96,.08); }
    .ls-pill-rejected { color: #e07b73; border-color: rgba(192,57,43,.35); background: rgba(192,57,43,.08); }
    .ls-pill-muted { opacity: .85; }
    .ls-empty { text-align: center; padding: 48px; color: var(--muted); grid-column: 1 / -1; }
    .ls-view-link { font-size: .75rem; color: var(--gold-light); text-decoration: none; margin-top: 8px; display: inline-block; }
    .ls-view-link:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
@php $isBrowse = request()->boolean('browse'); @endphp
<div class="ls-page">

@auth('student')
    {{-- ── Logged-in: full sessions view with Join Now ── --}}
    <div class="student-bar">
        <span>Welcome, {{ auth('student')->user()->name }}</span>
        <form method="POST" action="{{ route('student.logout') }}">@csrf<button type="submit">Logout</button></form>
    </div>

    <header class="ls-hd">
        <div class="ls-tag">Live</div>
        <h1>Live <em>Sessions</em></h1>
    </header>

    @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="flash err">{{ session('error') }}</div>@endif

    <div class="ls-grid">
        @forelse($sessions as $session)
            @php $enrollment = $enrollments[$session->id] ?? null; @endphp
            <article class="ls-card">
                <div class="ls-card-body">
                    @if($session->status === 'scheduled')
                        <span class="ls-badge ls-badge-scheduled">Scheduled</span>
                    @elseif($session->status === 'live')
                        <span class="ls-badge ls-badge-live"><span class="ls-live-dot"></span> Live</span>
                    @else
                        <span class="ls-badge ls-badge-ended">Ended</span>
                    @endif
                    <h2 class="ls-card-title">{{ $session->title }}</h2>
                    <p class="ls-card-desc">{{ Str::limit($session->description ?? 'No description.', 120) }}</p>
                    <p class="ls-card-meta">
                        @if($session->scheduled_at)
                            {{ $session->scheduled_at->format('M j, Y · g:i A') }}
                        @else
                            Schedule TBA
                        @endif
                    </p>

                    <div class="ls-card-actions">
                        @if($session->isEnded())
                            <span class="ls-pill ls-pill-muted">Session Ended</span>
                        @elseif($session->isLive() && $enrollment && $enrollment->isApproved())
                            <a href="{{ route('live-sessions.join', $session->id) }}" class="btn ls-btn-live" data-ls-join-btn>
                                <span class="ls-live-dot"></span> Join Now
                            </a>
                        @elseif($enrollment && $enrollment->isPending())
                            <span class="ls-pill ls-pill-pending">Pending Approval</span>
                        @elseif($enrollment && $enrollment->isRejected())
                            <span class="ls-pill ls-pill-rejected">Enrollment Rejected</span>
                        @elseif($enrollment && $enrollment->isApproved() && $session->isScheduled())
                            <span class="ls-pill ls-pill-approved">Approved — Waiting for session to start</span>
                        @elseif($enrollment && $enrollment->isApproved())
                            <span class="ls-pill ls-pill-approved">Approved</span>
                        @endif
                    </div>

                    <a href="{{ route('live-sessions.show', $session->id) }}" class="ls-view-link">View details →</a>
                </div>
            </article>
        @empty
            <div class="ls-empty">
                <p style="font-size:2rem;margin-bottom:12px">📡</p>
                <p>No live sessions available right now.</p>
            </div>
        @endforelse
    </div>

@elseif($isBrowse)
    {{-- ── Public browse mode: see sessions & register, no join ── --}}
    <div class="browse-notice">
        Already registered? <a href="{{ url('/live-sessions') }}">Log in to join sessions →</a>
    </div>

    <header class="ls-hd">
        <div class="ls-tag">Live</div>
        <h1>Live <em>Sessions</em></h1>
    </header>

    @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif

    <div class="ls-grid">
        @forelse($sessions as $session)
            <article class="ls-card">
                <div class="ls-card-body">
                    @if($session->status === 'scheduled')
                        <span class="ls-badge ls-badge-scheduled">Scheduled</span>
                    @elseif($session->status === 'live')
                        <span class="ls-badge ls-badge-live"><span class="ls-live-dot"></span> Live</span>
                    @else
                        <span class="ls-badge ls-badge-ended">Ended</span>
                    @endif
                    <h2 class="ls-card-title">{{ $session->title }}</h2>
                    <p class="ls-card-desc">{{ Str::limit($session->description ?? 'No description.', 120) }}</p>
                    <p class="ls-card-meta">
                        @if($session->scheduled_at)
                            {{ $session->scheduled_at->format('M j, Y · g:i A') }}
                        @else
                            Schedule TBA
                        @endif
                    </p>
                    <div class="ls-card-actions">
                        @if($session->isEnded())
                            <span class="ls-pill ls-pill-muted">Session Ended</span>
                        @elseif($session->isLive())
                            <a href="{{ route('live-sessions.register', $session->id) }}" class="btn ls-btn-live">
                                <span class="ls-live-dot"></span> Register &amp; Join Now
                            </a>
                        @else
                            <a href="{{ route('live-sessions.register', $session->id) }}" class="btn ls-btn-primary">Register Now</a>
                        @endif
                    </div>
                    <a href="{{ route('live-sessions.show', $session->id) }}" class="ls-view-link">View details →</a>
                </div>
            </article>
        @empty
            <div class="ls-empty">
                <p style="font-size:2rem;margin-bottom:12px">📡</p>
                <p>No live sessions available right now.</p>
            </div>
        @endforelse
    </div>

@else
    {{-- ── Guest: show login form ── --}}
    <div class="auth-gate">
        <div class="auth-box">
            <div class="auth-box-tag">📡 Live Sessions</div>
            <h2>Student Login</h2>
            <p>Log in to view and join all live sessions. Use the email and password you registered with.</p>

            @if($errors->any())
                <div class="auth-err">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('student.login.submit') }}">
                @csrf
                <input type="hidden" name="redirect" value="{{ url('/live-sessions') }}">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                <label>Password</label>
                <input type="password" name="password" required autocomplete="current-password">
                <label class="remember">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <button type="submit" class="auth-submit">Log In</button>
            </form>

            <div class="auth-links">
                @if(isset($firstActiveSession))
                    <p class="auth-link">Not registered yet? <a href="{{ route('live-sessions.register', $firstActiveSession->id) }}">Register now →</a></p>
                @else
                    <p class="auth-link">No upcoming sessions. Check back soon.</p>
                @endif
            </div>
        </div>
    </div>
@endauth

</div>
@endsection
