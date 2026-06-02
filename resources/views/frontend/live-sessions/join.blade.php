@extends('layouts.frontend')

@section('title', $session->title . ' — Live')

@push('styles')
<style>
    /* Override the layout's default padding so the join page fills screen */
    main.site-main {
        padding-top: 0 !important;
        overflow: hidden !important;
        height: calc(100vh - 72px);
        display: flex;
        flex-direction: column;
    }

    :root {
        --gold:#C9A84C; --gold-light:#E8C97A;
        --card:#111; --surface:#161616;
        --border:rgba(201,168,76,.15);
        --text:#D8D0C0; --muted:#7a7060;
        --green:#22c55e;
    }

    /* ── Top bar ── */
    .ls-topbar {
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 20px; height: 46px;
        background: var(--card); border-bottom: 1px solid var(--border);
    }
    .ls-topbar-left { display: flex; align-items: center; gap: 14px; }
    .ls-live-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(39,174,96,.15); border: 1px solid rgba(39,174,96,.4);
        color: #7dcea0; font-family: Cinzel, serif; font-size: .52rem;
        letter-spacing: .14em; text-transform: uppercase; padding: 4px 10px;
    }
    .ls-live-dot { width: 6px; height: 6px; border-radius: 50%; background: #27ae60; animation: lsPulse 1.2s ease-in-out infinite; flex-shrink: 0; }
    @keyframes lsPulse { 0%,100%{opacity:1} 50%{opacity:.3} }
    .ls-session-title { font-family: Cinzel, serif; font-size: .78rem; color: var(--gold-light); letter-spacing: .04em; max-width: 380px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ls-topbar-right { display: flex; align-items: center; gap: 14px; }
    .ls-leave-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border: 1px solid rgba(192,57,43,.4);
        color: #e07b73; font-family: Cinzel, serif; font-size: .55rem;
        letter-spacing: .12em; text-transform: uppercase; text-decoration: none;
        transition: background .2s;
    }
    .ls-leave-btn:hover { background: rgba(192,57,43,.15); }

    /* ── Main 2-column grid ── */
    .ls-main {
        flex: 1; display: grid;
        grid-template-columns: 1fr 300px;
        overflow: hidden; min-height: 0;
    }

    /* ── Left: Video ── */
    .ls-video-side {
        position: relative; background: #000;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }
    #video-container { width: 100%; height: 100%; position: relative; }
    #video-container video { width: 100% !important; height: 100% !important; object-fit: cover !important; }
    .ls-loading {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; gap: 10px;
        color: var(--muted); font-family: Cinzel, serif; font-size: .78rem;
        letter-spacing: .12em; text-transform: uppercase;
        pointer-events: none;
    }
    .ls-loading svg { width: 40px; height: 40px; opacity: .25; }
    .ls-msg-overlay {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        color: var(--muted); font-family: Cinzel, serif; font-size: .82rem;
        letter-spacing: .1em; text-transform: uppercase; text-align: center; padding: 20px;
    }
    #audio-unblock {
        display: none; position: absolute; inset: 0; z-index: 20;
        background: rgba(0,0,0,.72); align-items: center; justify-content: center;
        flex-direction: column; gap: 12px; cursor: pointer;
    }
    #audio-unblock.show { display: flex; }
    #audio-unblock span { font-family: Cinzel, serif; font-size: .82rem; letter-spacing: .12em; text-transform: uppercase; color: var(--gold-light); }
    #audio-unblock svg { width: 38px; height: 38px; stroke: var(--gold); fill: none; stroke-width: 1.5; }

    /* ── Right: Info + Chat panel ── */
    .ls-right-panel {
        background: var(--surface); border-left: 1px solid var(--border);
        display: flex; flex-direction: column; overflow: hidden; height: 100%;
    }

    /* Session Info */
    .ls-info-section { flex-shrink: 0; padding: 14px 16px; border-bottom: 2px solid rgba(201,168,76,.15); }
    .ls-info-label { font-family: Cinzel, serif; font-size: .52rem; letter-spacing: .18em; text-transform: uppercase; color: var(--gold); margin-bottom: 10px; }
    .ls-info-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; font-size: .78rem; }
    .ls-info-row .lbl { color: var(--muted); }
    .ls-info-row .val { color: var(--text); font-size: .76rem; }
    .ls-info-host { font-size: .8rem; color: var(--gold-light); font-family: Cinzel, serif; margin-top: 4px; }

    /* Chat section — fills remaining height */
    .ls-chat-section { flex: 1; display: flex; flex-direction: column; overflow: hidden; min-height: 0; }
    .ls-chat-header {
        flex-shrink: 0; padding: 9px 14px 8px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 7px;
        background: var(--card);
    }
    .ls-chat-header-label { font-family: Cinzel, serif; font-size: .54rem; letter-spacing: .18em; text-transform: uppercase; color: var(--gold); }
    .ls-chat-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--green); animation: lsPulse 1.4s ease-in-out infinite; flex-shrink: 0; }
    .ls-chat-messages {
        flex: 1; overflow-y: auto; padding: 10px 14px 10px;
        display: flex; flex-direction: column; gap: 9px; min-height: 0;
        scrollbar-width: thin; scrollbar-color: rgba(201,168,76,.2) transparent;
    }
    .ls-chat-messages::-webkit-scrollbar { width: 4px; }
    .ls-chat-messages::-webkit-scrollbar-thumb { background: rgba(201,168,76,.25); border-radius: 2px; }
    .ls-chat-bubble {
        background: rgba(255,255,255,.03); border: 1px solid var(--border);
        border-left: 2px solid rgba(201,168,76,.3); padding: 8px 10px; border-radius: 2px;
    }
    .ls-chat-bubble.is-self { border-left-color: rgba(34,197,94,.5); background: rgba(34,197,94,.04); }
    .ls-chat-meta { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 3px; }
    .ls-chat-name { font-size: .68rem; color: var(--gold-light); font-weight: 600; }
    .ls-chat-name.is-self { color: #86efac; }
    .ls-chat-time { font-size: .6rem; color: var(--muted); }
    .ls-chat-text { font-size: .8rem; color: var(--text); line-height: 1.45; word-break: break-word; }
    .ls-chat-empty { font-size: .75rem; color: var(--muted); font-style: italic; text-align: center; padding: 24px 8px; }
    @keyframes chatIn { from{opacity:0;transform:translateY(5px)}to{opacity:1;transform:translateY(0)} }
    .ls-chat-new { animation: chatIn .2s ease forwards; }

    /* Chat input */
    .ls-chat-form { flex-shrink: 0; display: flex; border-top: 1px solid var(--border); }
    .ls-chat-input {
        flex: 1; background: transparent; border: none;
        padding: 11px 14px; color: var(--text); font-size: .83rem;
        font-family: inherit; outline: none;
    }
    .ls-chat-input::placeholder { color: var(--muted); }
    .ls-chat-send {
        background: rgba(201,168,76,.12); border: none; border-left: 1px solid var(--border);
        padding: 11px 18px; color: var(--gold-light);
        font-family: Cinzel, serif; font-size: .56rem; letter-spacing: .1em;
        text-transform: uppercase; cursor: pointer; transition: background .2s;
        white-space: nowrap;
    }
    .ls-chat-send:hover { background: rgba(201,168,76,.25); }
    .ls-chat-send:disabled { opacity: .4; cursor: default; }
</style>
@endpush

@section('content')

{{-- TOP BAR --}}
<div class="ls-topbar">
    <div class="ls-topbar-left">
        <span class="ls-live-badge"><span class="ls-live-dot"></span> Live</span>
        <span class="ls-session-title">{{ $session->title }}</span>
    </div>
    <div class="ls-topbar-right">
        <a href="{{ route('live-sessions.index') }}" class="ls-leave-btn">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
            Leave Session
        </a>
    </div>
</div>

{{-- MAIN 2-COL GRID --}}
<div class="ls-main">

    {{-- LEFT: VIDEO --}}
    <div class="ls-video-side">
        <div id="video-container">
            <div class="ls-loading" id="videoLoading">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M15 10l4.553-2.07A1 1 0 0121 8.845v6.31a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                <span>Connecting to live session...</span>
            </div>
            <div id="audio-unblock">
                <svg viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/></svg>
                <span>Tap to enable audio</span>
            </div>
        </div>
    </div>

    {{-- RIGHT: INFO + CHAT --}}
    <div class="ls-right-panel">

        {{-- Session Info --}}
        <div class="ls-info-section">
            <div class="ls-info-label">Session Info</div>
            <div class="ls-info-row">
                <span class="lbl">Title</span>
                <span class="val" style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $session->title }}</span>
            </div>
            <div class="ls-info-row">
                <span class="lbl">Status</span>
                <span class="val" style="color:#7dcea0">● Live</span>
            </div>
            @if($session->started_at)
            <div class="ls-info-row">
                <span class="lbl">Started</span>
                <span class="val">{{ $session->started_at->format('g:i A') }}</span>
            </div>
            @endif
            <div class="ls-info-row" style="margin-top:6px">
                <span class="lbl">Host</span>
                <span class="val" style="color:var(--gold-light)">{{ $session->admin?->name ?? 'Instructor' }}</span>
            </div>
            @if($session->description)
            <p style="font-size:.75rem;color:var(--muted);margin-top:8px;line-height:1.55">{{ Str::limit($session->description, 120) }}</p>
            @endif
        </div>

        {{-- Live Chat --}}
        <div class="ls-chat-section">
            <div class="ls-chat-header">
                <span class="ls-chat-dot"></span>
                <svg style="width:11px;height:11px;stroke:var(--gold);fill:none;stroke-width:2;flex-shrink:0" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                <span class="ls-chat-header-label">Live Chat</span>
            </div>
            <div class="ls-chat-messages" id="chatMessages">
                <p class="ls-chat-empty" id="chatEmpty">Send a message to the host...</p>
            </div>
            <form class="ls-chat-form" id="chatForm">
                <input type="text" id="chatInput" class="ls-chat-input" placeholder="Type a message..." maxlength="500" autocomplete="off">
                <button type="submit" class="ls-chat-send" id="chatSendBtn">Send</button>
            </form>
        </div>

    </div>{{-- /ls-right-panel --}}

</div>{{-- /ls-main --}}

@endsection

@push('scripts')
<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
<script>
(function () {
    const appId       = @json($appId);
    const channelName = @json($channelName);
    const token       = @json($token);
    const uid         = @json($uid);
    const container   = document.getElementById('video-container');
    const loadingEl   = document.getElementById('videoLoading');
    const audioUnblock = document.getElementById('audio-unblock');
    const audioTracks = [];

    function showStatus(text) {
        if (loadingEl) { loadingEl.style.display = 'flex'; loadingEl.querySelector('span').textContent = text; }
    }
    function hideLoading() {
        if (loadingEl) loadingEl.style.display = 'none';
    }
    function showMessage(text) {
        clearVideoElements();
        container.innerHTML = '<div class="ls-msg-overlay">' + text + '</div>';
    }
    function clearVideoElements() {
        Array.from(container.children).forEach(function (el) {
            if (el !== loadingEl && el !== audioUnblock) el.remove();
        });
    }
    function renderVideo(user) {
        clearVideoElements();
        hideLoading();
        user.videoTrack.play(container);
    }
    function playAudio(track) {
        if (audioTracks.indexOf(track) === -1) audioTracks.push(track);
        track.play().catch(function () { audioUnblock.classList.add('show'); });
    }

    audioUnblock.addEventListener('click', function () {
        audioUnblock.classList.remove('show');
        audioTracks.forEach(function (t) { try { t.play(); } catch(e){} });
    });
    AgoraRTC.onAutoplayFailed = function () { audioUnblock.classList.add('show'); };

    if (!appId || !token || !channelName) { showMessage('Unable to connect to live session'); return; }

    const client = AgoraRTC.createClient({ mode: 'live', codec: 'vp8' });

    client.on('user-published', async function (user, mediaType) {
        try {
            await client.subscribe(user, mediaType);
            if (mediaType === 'video') renderVideo(user);
            if (mediaType === 'audio') playAudio(user.audioTrack);
        } catch (e) { console.error('Subscribe error:', e); }
    });
    client.on('user-unpublished', function (user, mediaType) {
        if (mediaType === 'video') { clearVideoElements(); showStatus('Switching stream...'); }
    });
    client.on('user-left', function () { showMessage('Host has ended the session'); });
    client.on('connection-state-change', function (s) { if (s === 'DISCONNECTED') showMessage('Disconnected from session'); });

    async function subscribeToExistingUser(user) {
        try {
            if (user.hasVideo) { await client.subscribe(user, 'video'); renderVideo(user); }
            if (user.hasAudio) { await client.subscribe(user, 'audio'); playAudio(user.audioTrack); }
        } catch (e) { console.error('Subscribe error:', e); }
    }

    async function joinSession() {
        try {
            await client.setClientRole('audience', { level: 1 });
            await client.join(appId, channelName, token, uid);
            if (client.remoteUsers && client.remoteUsers.length > 0) {
                for (const user of client.remoteUsers) await subscribeToExistingUser(user);
            }
            if (!container.querySelector('video')) showStatus('Connected — waiting for host to stream...');
        } catch (err) {
            console.error('Join error:', err);
            showMessage('Unable to connect: ' + (err.message || err.code || 'Unknown error'));
        }
    }
    joinSession();
})();
</script>

<script>
(function () {
    const COMMENT_URL  = @json($commentUrl);
    const STUDENT_NAME = @json($studentName);
    const CSRF         = document.querySelector('meta[name="csrf-token"]')?.content || '';

    const form    = document.getElementById('chatForm');
    const input   = document.getElementById('chatInput');
    const sendBtn = document.getElementById('chatSendBtn');
    const msgBox  = document.getElementById('chatMessages');

    function esc(str) {
        const d = document.createElement('div');
        d.textContent = String(str || '');
        return d.innerHTML;
    }
    function nowTime() {
        const d = new Date();
        return String(d.getHours()).padStart(2,'0') + ':' + String(d.getMinutes()).padStart(2,'0');
    }

    function appendMessage(name, text, isSelf) {
        const empty = document.getElementById('chatEmpty');
        if (empty) empty.remove();
        const el = document.createElement('div');
        el.className = 'ls-chat-bubble ls-chat-new' + (isSelf ? ' is-self' : '');
        el.innerHTML =
            '<div class="ls-chat-meta">' +
                '<span class="ls-chat-name' + (isSelf ? ' is-self' : '') + '">' + esc(name) + '</span>' +
                '<span class="ls-chat-time">' + nowTime() + '</span>' +
            '</div>' +
            '<div class="ls-chat-text">' + esc(text) + '</div>';
        msgBox.appendChild(el);
        msgBox.scrollTop = msgBox.scrollHeight;
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const msg = input.value.trim();
        if (!msg) return;
        input.value = '';
        sendBtn.disabled = true;
        appendMessage(STUDENT_NAME, msg, true);
        try {
            const res = await fetch(COMMENT_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ message: msg }),
            });
            if (!res.ok) {
                const last = msgBox.lastElementChild;
                if (last) last.style.opacity = '.45';
            }
        } catch (err) { console.error('Chat error:', err); }
        finally { sendBtn.disabled = false; input.focus(); }
    });
})();
</script>
@endpush
