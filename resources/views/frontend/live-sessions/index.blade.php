@extends('layouts.frontend')

@section('title', 'Live Sessions — ' . config('app.name', 'Dollar Bull University'))

@push('styles')
<style>
    :root { --gold:#C9A84C; --gold-light:#E8C97A; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
    .ls-page { padding: 20px 20px 56px; max-width: 1200px; margin: 0 auto; }
    .ls-hd { text-align: center; margin-bottom: 28px; }
    .ls-tag { display: inline-block; font-family: Cinzel, serif; font-size: 9px; letter-spacing: .22em; color: var(--gold); border: 1px solid var(--border); padding: 4px 14px; margin-bottom: 10px; }
    .ls-hd h1 { font-family: Cinzel, serif; font-size: clamp(1.4rem, 4vw, 2.2rem); color: #fff; }
    .ls-hd h1 em { color: var(--gold); font-style: normal; }
    .flash { padding: 12px 16px; margin-bottom: 20px; border: 1px solid var(--border); background: rgba(201,168,76,.08); color: var(--gold-light); }
    .flash.err { border-color: rgba(192,57,43,.4); color: #e07b73; background: rgba(192,57,43,.1); }
    .student-bar { display: flex; justify-content: flex-end; align-items: center; gap: 12px; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid var(--border); }
    .student-bar a, .student-bar button { color: var(--gold-light); font-size: .85rem; text-decoration: none; background: none; border: none; cursor: pointer; font-family: inherit; }
    .student-bar span { color: var(--muted); font-size: .85rem; }
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
    .ls-btn-live { background: rgba(39,174,96,.12); border-color: rgba(39,174,96,.5); color: #7dcea0; display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
    .ls-btn-live:hover { background: rgba(39,174,94,.25); color: #fff; }
    .ls-pill { display: block; text-align: center; padding: 10px; font-family: Cinzel, serif; font-size: .65rem; letter-spacing: .12em; text-transform: uppercase; border: 1px solid var(--border); color: var(--muted); }
    .ls-pill-pending { color: #ffd54f; border-color: rgba(255,193,7,.35); background: rgba(255,193,7,.08); }
    .ls-pill-approved { color: #7dcea0; border-color: rgba(39,174,96,.35); background: rgba(39,174,96,.08); }
    .ls-pill-rejected { color: #e07b73; border-color: rgba(192,57,43,.35); background: rgba(192,57,43,.08); }
    .ls-pill-muted { opacity: .85; }
    .ls-empty { text-align: center; padding: 48px; color: var(--muted); grid-column: 1 / -1; }
    .ls-view-link { font-size: .75rem; color: var(--gold-light); text-decoration: none; margin-top: 8px; display: inline-block; }
    .ls-view-link:hover { text-decoration: underline; }
    @keyframes fadeIn { from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)} }
    .ls-action-animated { animation: fadeIn .35s ease forwards; }

    /* ── Quick enroll modal ── */
    .qe-overlay { display:none;position:fixed;inset:0;background:rgba(0,0,0,.82);z-index:9999;align-items:center;justify-content:center; }
    .qe-overlay.show { display:flex; }
    .qe-box { background:#111;border:1px solid rgba(201,168,76,.35);padding:32px 28px;width:100%;max-width:380px;animation:fadeIn .25s ease; }
    .qe-title { font-family:Cinzel,serif;font-size:1rem;color:#fff;margin-bottom:6px;letter-spacing:.04em; }
    .qe-sub { font-size:.82rem;color:var(--muted);margin-bottom:22px;line-height:1.55; }
    .qe-label { display:block;font-size:.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:.1em;margin-bottom:5px; }
    .qe-input { width:100%;padding:10px 12px;margin-bottom:14px;background:rgba(255,255,255,.04);border:1px solid var(--border);color:var(--text);font-family:inherit;font-size:.88rem;outline:none;transition:border-color .2s; }
    .qe-input:focus { border-color:var(--gold); }
    .qe-submit { width:100%;padding:12px;background:transparent;border:1px solid var(--gold);color:var(--gold-light);font-family:Cinzel,serif;font-size:.72rem;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;transition:background .25s,color .25s;margin-bottom:10px; }
    .qe-submit:hover { background:var(--gold);color:#0d0d0d; }
    .qe-submit:disabled { opacity:.5;cursor:default; }
    .qe-cancel { display:block;text-align:center;font-size:.78rem;color:var(--muted);cursor:pointer;background:none;border:none;font-family:inherit;width:100%;padding:4px; }
    .qe-cancel:hover { color:var(--text); }
    .qe-error { font-size:.8rem;color:#e07b73;margin-bottom:10px;display:none; }
    .qe-success { font-size:.82rem;color:#7dcea0;text-align:center;padding:14px 0;display:none; }
</style>
@endpush

@section('content')
<div class="ls-page">

    @auth('student')
    <div class="student-bar">
        <span>Welcome, {{ auth('student')->user()->name }}</span>
        <form method="POST" action="{{ route('student.logout') }}">@csrf<button type="submit">Logout</button></form>
    </div>
    @endauth

    <header class="ls-hd">
        <div class="ls-tag">Live</div>
        <h1>Live <em>Sessions</em></h1>
    </header>

    @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="flash err">{{ session('error') }}</div>@endif

    <div class="ls-grid">
        @forelse($sessions as $session)
            @php $enrollment = $enrollments[$session->id] ?? null; @endphp
            <article class="ls-card" data-session-id="{{ $session->id }}">
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

                    <div class="ls-card-actions" data-actions="{{ $session->id }}">
                        @if($session->isEnded())
                            <span class="ls-pill ls-pill-muted">Session Ended</span>
                        @elseif($enrollment && $enrollment->isApproved() && $session->isLive())
                            <a href="{{ route('live-sessions.join', $session->id) }}" class="btn ls-btn-live" data-join-btn="{{ $session->id }}">
                                <span class="ls-live-dot"></span> Join Now
                            </a>
                        @elseif($enrollment && $enrollment->isApproved() && $session->isScheduled())
                            <span class="ls-pill ls-pill-approved">✓ Approved — Waiting for session to start</span>
                        @elseif($enrollment && $enrollment->isPending())
                            <span class="ls-pill ls-pill-pending" data-pending="{{ $session->id }}">⏳ Pending Approval</span>
                        @elseif($enrollment && $enrollment->isRejected())
                            <span class="ls-pill ls-pill-rejected">Enrollment Rejected</span>
                        @else
                            <button class="btn {{ $session->isLive() ? 'ls-btn-live' : '' }}"
                                    onclick="openEnroll({{ $session->id }}, '{{ e($session->title) }}', {{ $session->isLive() ? 'true' : 'false' }})">
                                @if($session->isLive())<span class="ls-live-dot"></span>@endif
                                {{ $session->isLive() ? 'Join Now' : 'Enroll Now' }}
                            </button>
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

</div>

{{-- Quick Enroll Modal --}}
<div class="qe-overlay" id="qeOverlay" onclick="if(event.target===this)closeEnroll()">
    <div class="qe-box">
        <h3 class="qe-title" id="qeTitle">Request to Join</h3>
        <p class="qe-sub">Enter your name and email. The host will approve your request instantly.</p>
        <div class="qe-error" id="qeError"></div>
        <div class="qe-success" id="qeSuccess">✓ Request sent! Waiting for host approval...</div>
        <div id="qeFormWrap">
            <label class="qe-label">Your Name</label>
            <input type="text" id="qeName" class="qe-input" placeholder="Full name" autocomplete="name">
            <label class="qe-label">Email Address</label>
            <input type="email" id="qeEmail" class="qe-input" placeholder="your@email.com" autocomplete="email">
            <button class="qe-submit" id="qeSubmit" onclick="submitEnroll()">Send Join Request</button>
            <button class="qe-cancel" onclick="closeEnroll()">Cancel</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
// ── Quick Enroll Modal ────────────────────────────────────
let qeSessionId   = null;
let qeSessionLive = false;
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

window.openEnroll = function(sessionId, title, isLive) {
    qeSessionId   = sessionId;
    qeSessionLive = isLive;
    document.getElementById('qeTitle').textContent = 'Request to Join — ' + title;
    document.getElementById('qeError').style.display   = 'none';
    document.getElementById('qeSuccess').style.display = 'none';
    document.getElementById('qeFormWrap').style.display = 'block';
    document.getElementById('qeName').value  = '';
    document.getElementById('qeEmail').value = '';
    document.getElementById('qeSubmit').disabled = false;
    document.getElementById('qeSubmit').textContent = 'Send Join Request';
    document.getElementById('qeOverlay').classList.add('show');
    setTimeout(function(){ document.getElementById('qeName').focus(); }, 100);
};

window.closeEnroll = function() {
    document.getElementById('qeOverlay').classList.remove('show');
};

window.submitEnroll = async function() {
    const name  = document.getElementById('qeName').value.trim();
    const email = document.getElementById('qeEmail').value.trim();
    const errEl = document.getElementById('qeError');
    errEl.style.display = 'none';

    if (!name)  { errEl.textContent = 'Please enter your name.';  errEl.style.display='block'; return; }
    if (!email) { errEl.textContent = 'Please enter your email.'; errEl.style.display='block'; return; }

    const btn = document.getElementById('qeSubmit');
    btn.disabled = true;
    btn.textContent = 'Sending...';

    try {
        const res  = await fetch('/live-sessions/' + qeSessionId + '/guest-enroll', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ name, email }),
        });
        const data = await res.json();

        if (!res.ok || !data.ok) {
            errEl.textContent = data.message || 'Something went wrong. Try again.';
            errEl.style.display = 'block';
            btn.disabled = false;
            btn.textContent = 'Send Join Request';
            return;
        }

        // Success — show confirmation in modal then close
        document.getElementById('qeFormWrap').style.display = 'none';
        document.getElementById('qeSuccess').style.display = 'block';

        // Update the card action to "Pending Approval"
        const actionsEl = document.querySelector('[data-actions="' + qeSessionId + '"]');
        if (actionsEl) {
            actionsEl.innerHTML =
                '<span class="ls-pill ls-pill-pending ls-action-animated" data-pending="' + qeSessionId + '">⏳ Pending Approval</span>';
        }

        setTimeout(closeEnroll, 2200);

    } catch (err) {
        errEl.textContent = 'Network error. Please try again.';
        errEl.style.display = 'block';
        btn.disabled = false;
        btn.textContent = 'Send Join Request';
    }
};

// Allow Enter key in modal inputs
document.getElementById('qeName').addEventListener('keydown',  function(e){ if(e.key==='Enter') document.getElementById('qeEmail').focus(); });
document.getElementById('qeEmail').addEventListener('keydown', function(e){ if(e.key==='Enter') submitEnroll(); });
</script>
<script>
(function () {
    const PUSHER_KEY   = @json(config('broadcasting.connections.pusher.key'));
    const PUSHER_CLUST = @json(config('broadcasting.connections.pusher.options.cluster'));
    if (!PUSHER_KEY) return;

    // Map enrollment_id → session_id for enrolled sessions (guests get empty map)
    const enrollmentMap = @json(
        $enrollments->isNotEmpty()
            ? collect($enrollments)->mapWithKeys(fn($e, $sid) => [$e->id => $sid])->toArray()
            : []
    );

    if (Object.keys(enrollmentMap).length === 0) return;

    const pusher = new Pusher(PUSHER_KEY, { cluster: PUSHER_CLUST, forceTLS: true });

    // Listen on each session the student is enrolled in
    Object.entries(enrollmentMap).forEach(function ([enrollmentId, sessionId]) {
        const ch = pusher.subscribe('live-session.' + sessionId);

        ch.bind('EnrollmentApproved', function (data) {
            if (parseInt(data.enrollment_id) !== parseInt(enrollmentId)) return;
            const actionsEl = document.querySelector('[data-actions="' + sessionId + '"]');
            if (!actionsEl) return;

            const isLive = document.querySelector('[data-session-id="' + sessionId + '"] .ls-badge-live') !== null;
            const joinUrl = '/live-sessions/' + sessionId + '/join';

            if (isLive) {
                actionsEl.innerHTML =
                    '<a href="' + joinUrl + '" class="btn ls-btn-live ls-action-animated" data-join-btn="' + sessionId + '">' +
                    '<span class="ls-live-dot"></span> Join Now</a>';
            } else {
                actionsEl.innerHTML =
                    '<span class="ls-pill ls-pill-approved ls-action-animated">✓ Approved — Waiting for session to start</span>';
            }

            // Toast notification
            showToast('✓ You have been approved for "' + (document.querySelector('[data-session-id="' + sessionId + '"] .ls-card-title')?.textContent || 'the session') + '"!');
        });

        ch.bind('SessionWentLive', function () {
            // If student is approved, show Join Now when session goes live
            const joinBtn = document.querySelector('[data-join-btn="' + sessionId + '"]');
            if (joinBtn) return; // already showing
            const actionsEl = document.querySelector('[data-actions="' + sessionId + '"]');
            if (!actionsEl) return;
            const badge = document.querySelector('[data-session-id="' + sessionId + '"] .ls-badge');
            if (badge) { badge.className = 'ls-badge ls-badge-live'; badge.innerHTML = '<span class="ls-live-dot"></span> Live'; }

            // Check if they have approval pill
            const approvedPill = actionsEl.querySelector('.ls-pill-approved');
            if (approvedPill) {
                const joinUrl = '/live-sessions/' + sessionId + '/join';
                actionsEl.innerHTML =
                    '<a href="' + joinUrl + '" class="btn ls-btn-live ls-action-animated">' +
                    '<span class="ls-live-dot"></span> Join Now</a>';
            }
        });
    });

    // Toast helper
    let toastEl = null;
    function showToast(msg) {
        if (!toastEl) {
            toastEl = document.createElement('div');
            toastEl.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;padding:14px 20px;background:#161616;border:1px solid rgba(201,168,76,.6);color:#E8C97A;font-family:Cinzel,serif;font-size:.78rem;letter-spacing:.06em;box-shadow:0 8px 32px rgba(0,0,0,.6);transition:opacity .3s;pointer-events:none';
            document.body.appendChild(toastEl);
        }
        toastEl.textContent = msg;
        toastEl.style.opacity = '1';
        clearTimeout(toastEl._t);
        toastEl._t = setTimeout(function () { toastEl.style.opacity = '0'; }, 6000);
    }
})();
</script>
@endpush
