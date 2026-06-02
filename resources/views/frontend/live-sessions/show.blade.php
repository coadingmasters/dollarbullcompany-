@extends('layouts.frontend')

@section('title', $session->title . ' — Live Session')

@push('styles')
<style>
    :root { --gold:#C9A84C; --gold-light:#E8C97A; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
    .ls-page { padding: 20px 20px 56px; max-width: 800px; margin: 0 auto; }
    .ls-back { color: var(--gold-light); text-decoration: none; font-size: .85rem; display: inline-block; margin-bottom: 20px; }
    .ls-back:hover { text-decoration: underline; }
    .flash { padding: 12px 16px; margin-bottom: 20px; border: 1px solid var(--border); background: rgba(201,168,76,.08); color: var(--gold-light); }
    .flash.err { border-color: rgba(192,57,43,.4); color: #e07b73; background: rgba(192,57,43,.1); }
    .ls-panel { background: var(--card); border: 1px solid var(--border); padding: 28px; }
    .ls-title { font-family: Cinzel, serif; font-size: 1.6rem; color: #fff; margin-bottom: 12px; }
    .ls-desc { color: var(--muted); line-height: 1.6; margin-bottom: 20px; }
    .ls-meta { font-size: .85rem; color: var(--muted); margin-bottom: 20px; }
    .ls-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; font-family: Cinzel, serif; font-size: 7px; letter-spacing: .14em; text-transform: uppercase; border: 1px solid transparent; margin-bottom: 16px; }
    .ls-badge-scheduled { background: rgba(255,193,7,.12); color: #ffd54f; border-color: rgba(255,193,7,.35); }
    .ls-badge-live { background: rgba(39,174,96,.15); color: #7dcea0; border-color: rgba(39,174,96,.4); }
    .ls-badge-ended { background: rgba(192,57,43,.15); color: #e07b73; border-color: rgba(192,57,43,.4); }
    .ls-live-dot { width: 6px; height: 6px; border-radius: 50%; background: #27ae60; animation: lsPulse 1.2s ease-in-out infinite; }
    @keyframes lsPulse { 0%, 100% { opacity: 1; } 50% { opacity: .35; } }
    .ls-card-actions { margin-top: 8px; }
    .ls-card-actions form { margin: 0; }
    .btn { display: block; width: 100%; max-width: 320px; text-align: center; padding: 12px; border: 1px solid var(--gold); color: var(--gold-light); font-family: Cinzel, serif; font-size: .68rem; letter-spacing: .14em; text-transform: uppercase; text-decoration: none; background: transparent; cursor: pointer; }
    .ls-btn-live { background: rgba(39,174,96,.12); border-color: rgba(39,174,96,.5); color: #7dcea0; display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
    .ls-pill { display: block; max-width: 320px; text-align: center; padding: 12px; font-family: Cinzel, serif; font-size: .65rem; letter-spacing: .12em; text-transform: uppercase; border: 1px solid var(--border); color: var(--muted); }
    .ls-pill-pending { color: #ffd54f; border-color: rgba(255,193,7,.35); background: rgba(255,193,7,.08); }
    .ls-pill-approved { color: #7dcea0; border-color: rgba(39,174,96,.35); background: rgba(39,174,96,.08); }
    .ls-pill-rejected { color: #e07b73; border-color: rgba(192,57,43,.35); background: rgba(192,57,43,.08); }
    .ls-pill-muted { opacity: .85; }
    .ls-toast { position: fixed; bottom: 24px; right: 24px; z-index: 9999; padding: 14px 20px; background: var(--card); border: 1px solid var(--gold); color: var(--gold-light); font-family: Cinzel, serif; font-size: .75rem; letter-spacing: .08em; display: none; box-shadow: 0 8px 32px rgba(0,0,0,.5); }
    .ls-toast.show { display: block; animation: fadeIn .3s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div class="ls-page">
    <a href="{{ route('live-sessions.index') }}" class="ls-back">← Back to Live Sessions</a>

    @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="flash err">{{ session('error') }}</div>@endif

    <div class="ls-panel">
        <span class="ls-badge ls-badge-{{ $session->status }}" id="lsStatusBadge" data-status="{{ $session->status }}">
            @if($session->status === 'live')<span class="ls-live-dot" id="lsStatusDot"></span>@endif
            <span id="lsStatusLabel">{{ ucfirst($session->status) }}</span>
        </span>

        <h1 class="ls-title">{{ $session->title }}</h1>
        <p class="ls-desc">{{ $session->description ?: 'No description provided.' }}</p>
        <p class="ls-meta">
            @if($session->scheduled_at)
                Scheduled: {{ $session->scheduled_at->format('l, M j, Y · g:i A') }}
            @else
                Schedule to be announced
            @endif
        </p>

        @include('frontend.live-sessions.partials.enrollment-actions', ['session' => $session, 'enrollment' => $enrollment])
    </div>
</div>

<div class="ls-toast" id="lsToast" role="status"></div>
@endsection

@push('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
(function () {
    const PUSHER_KEY   = @json(config('broadcasting.connections.pusher.key'));
    const PUSHER_CLUST = @json(config('broadcasting.connections.pusher.options.cluster'));
    const SESSION_ID   = @json($session->id);
    const JOIN_URL     = @json(route('live-sessions.join', $session->id));
    const ENROLLMENT_ID = @json($enrollment?->id);
    const IS_APPROVED  = @json($enrollment?->isApproved() ?? false);
    const IS_LIVE      = @json($session->isLive());

    if (!PUSHER_KEY) return;

    const badge      = document.getElementById('lsStatusBadge');
    const label      = document.getElementById('lsStatusLabel');
    const toast      = document.getElementById('lsToast');
    const actionsWrap = document.querySelector('[data-ls-actions]');

    function showToast(msg) {
        if (!toast) return;
        toast.textContent = msg;
        toast.classList.add('show');
        setTimeout(function () { toast.classList.remove('show'); }, 6000);
    }

    function setBadge(status) {
        if (!badge || !label) return;
        badge.className = 'ls-badge ls-badge-' + status;
        badge.dataset.status = status;
        label.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        const existingDot = badge.querySelector('.ls-live-dot');
        if (status === 'live' && !existingDot) {
            const d = document.createElement('span');
            d.className = 'ls-live-dot';
            badge.insertBefore(d, label);
        } else if (status !== 'live' && existingDot) {
            existingDot.remove();
        }
    }

    function showJoinButton() {
        if (!actionsWrap) return;
        actionsWrap.innerHTML =
            '<a href="' + JOIN_URL + '" class="btn ls-btn-live" style="animation:fadeIn .4s ease">' +
            '<span class="ls-live-dot"></span> Join Live Now</a>';
    }

    function showEndedState() {
        if (!actionsWrap) return;
        actionsWrap.innerHTML = '<span class="ls-pill ls-pill-muted">Session Ended</span>';
    }

    function showApprovedWaiting() {
        if (!actionsWrap) return;
        actionsWrap.innerHTML = '<span class="ls-pill ls-pill-approved" style="animation:fadeIn .4s ease">✓ Approved — Session is now live. Join now!</span>';
        setTimeout(showJoinButton, 1200);
    }

    const pusher  = new Pusher(PUSHER_KEY, { cluster: PUSHER_CLUST, forceTLS: true });
    const channel = pusher.subscribe('live-session.' + SESSION_ID);

    // Session went live
    channel.bind('SessionWentLive', function () {
        showToast('🔴 Session is now LIVE!');
        setBadge('live');
        if (IS_APPROVED) showJoinButton();
    });

    // Session ended
    channel.bind('SessionEnded', function () {
        showToast('Session has ended.');
        setBadge('ended');
        showEndedState();
    });

    // Admin approved THIS student's enrollment in real-time
    channel.bind('EnrollmentApproved', function (data) {
        if (!ENROLLMENT_ID || data.enrollment_id != ENROLLMENT_ID) return;
        showToast('✓ You have been approved! You can now join the session.');
        if (IS_LIVE) {
            showApprovedWaiting();
        } else {
            if (actionsWrap) {
                actionsWrap.innerHTML = '<span class="ls-pill ls-pill-approved" style="animation:fadeIn .4s ease">✓ Approved — Waiting for session to start</span>';
            }
        }
    });
})();
</script>
@endpush
