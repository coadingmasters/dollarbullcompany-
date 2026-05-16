<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Broadcast Studio — {{ $session->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Pro:wght@300;400&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4A017; --gold-light: #F5C842; --gold-glow: rgba(212,160,23,.4);
            --black: #060606; --card: #0d0d0d; --surface: #141414;
            --border: rgba(255,255,255,.08); --text: rgba(255,255,255,.85); --muted: rgba(255,255,255,.4);
            --green: #22c55e; --red: #ef4444; --red-dim: rgba(239,68,68,.15);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; background: var(--black); color: var(--text); font-family: 'Crimson Pro', Georgia, serif; overflow: hidden; }

        /* ── Layout ── */
        .studio { display: grid; grid-template-rows: 52px 1fr 80px; height: 100vh; }

        /* ── Top bar ── */
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 20px; background: var(--card); border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .live-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.4);
            color: #fca5a5; font-family: 'Cinzel', serif; font-size: .55rem;
            letter-spacing: .16em; text-transform: uppercase; padding: 4px 10px;
        }
        .live-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--red); animation: pulse 1.2s ease-in-out infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.85)} }
        .session-name { font-family: 'Cinzel', serif; font-size: .8rem; color: var(--gold-light); letter-spacing: .04em; max-width: 340px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .topbar-right { display: flex; align-items: center; gap: 14px; font-size: .8rem; color: var(--muted); }
        .viewer-count { display: flex; align-items: center; gap: 5px; }
        .viewer-count svg { width: 14px; height: 14px; }
        .timer { font-family: 'Cinzel', serif; font-size: .72rem; color: var(--muted); min-width: 50px; text-align: right; }

        /* ── Main area ── */
        .main-area { display: grid; grid-template-columns: 1fr 280px; overflow: hidden; }

        /* ── Video stage ── */
        .video-stage { position: relative; background: #000; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        #local-player { width: 100%; height: 100%; }
        #local-player video { width: 100%; height: 100%; object-fit: cover; }
        .stage-overlay {
            position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
            flex-direction: column; gap: 12px; color: var(--muted); font-family: 'Cinzel', serif;
            font-size: .75rem; letter-spacing: .12em; text-transform: uppercase;
            pointer-events: none;
        }
        .stage-overlay svg { width: 48px; height: 48px; opacity: .25; }
        .cam-off-overlay {
            position: absolute; inset: 0; background: #0a0a0a;
            display: none; align-items: center; justify-content: center;
            flex-direction: column; gap: 10px; color: var(--muted);
            font-family: 'Cinzel', serif; font-size: .72rem; letter-spacing: .1em; text-transform: uppercase;
        }
        .cam-off-overlay svg { width: 36px; height: 36px; opacity: .3; }
        .cam-off-overlay.show { display: flex; }

        /* Connection status pill */
        .conn-status {
            position: absolute; top: 14px; left: 14px; z-index: 10;
            display: flex; align-items: center; gap: 6px;
            background: rgba(0,0,0,.6); border: 1px solid var(--border); padding: 4px 10px;
            font-family: 'Cinzel', serif; font-size: .55rem; letter-spacing: .12em; text-transform: uppercase;
            color: var(--muted); transition: color .3s;
        }
        .conn-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--muted); transition: background .3s; }
        .conn-status.connected { color: #86efac; }
        .conn-status.connected .conn-dot { background: var(--green); }
        .conn-status.connecting { color: #fde047; }
        .conn-status.connecting .conn-dot { background: #eab308; animation: pulse 1s ease-in-out infinite; }
        .conn-status.error { color: #fca5a5; }
        .conn-status.error .conn-dot { background: var(--red); }

        /* ── Side panel ── */
        .side-panel { background: var(--surface); border-left: 1px solid var(--border); display: flex; flex-direction: column; overflow: hidden; }
        .panel-section { padding: 16px; border-bottom: 1px solid var(--border); }
        .panel-label { font-family: 'Cinzel', serif; font-size: .55rem; letter-spacing: .18em; text-transform: uppercase; color: var(--gold); margin-bottom: 10px; }
        .info-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; font-size: .8rem; }
        .info-row .label { color: var(--muted); }
        .info-row .value { color: var(--text); font-size: .78rem; }
        .channel-code { font-family: monospace; font-size: .7rem; color: var(--gold-light); word-break: break-all; }

        /* Viewer list */
        .viewer-section { flex: 1; overflow-y: auto; padding: 16px; }
        .viewer-item { display: flex; align-items: center; gap: 8px; padding: 6px 0; border-bottom: 1px solid var(--border); }
        .viewer-avatar { width: 28px; height: 28px; border-radius: 50%; background: rgba(212,160,23,.15); border: 1px solid rgba(212,160,23,.25); display: flex; align-items: center; justify-content: center; font-family: 'Cinzel', serif; font-size: .65rem; color: var(--gold-light); flex-shrink: 0; }
        .viewer-name { font-size: .78rem; color: var(--text); }
        .viewer-empty { font-size: .78rem; color: var(--muted); text-align: center; padding: 20px 0; font-style: italic; }

        /* ── Bottom control bar ── */
        .controls {
            background: var(--surface); border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center; gap: 16px; padding: 0 24px;
        }
        .ctrl-btn {
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            background: rgba(255,255,255,.06); border: 1px solid var(--border);
            color: var(--text); cursor: pointer; padding: 10px 20px; transition: all .2s;
            font-family: 'Cinzel', serif; font-size: .52rem; letter-spacing: .1em; text-transform: uppercase;
            min-width: 80px;
        }
        .ctrl-btn svg { width: 20px; height: 20px; }
        .ctrl-btn:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.2); }
        .ctrl-btn.active { background: rgba(212,160,23,.12); border-color: rgba(212,160,23,.4); color: var(--gold-light); }
        .ctrl-btn.muted-state { background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.35); color: #fca5a5; }
        .ctrl-btn.cam-off-state { background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.35); color: #fca5a5; }
        .ctrl-divider { width: 1px; height: 40px; background: var(--border); margin: 0 4px; }
        .end-btn {
            display: flex; align-items: center; gap: 8px;
            background: rgba(239,68,68,.12); border: 1px solid rgba(239,68,68,.4);
            color: #fca5a5; cursor: pointer; padding: 10px 28px; transition: all .2s;
            font-family: 'Cinzel', serif; font-size: .62rem; letter-spacing: .14em; text-transform: uppercase;
        }
        .end-btn:hover { background: rgba(239,68,68,.22); border-color: rgba(239,68,68,.6); }
        .end-btn svg { width: 16px; height: 16px; }

        /* ── End confirm modal ── */
        .modal-bg { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.85); z-index: 999; align-items: center; justify-content: center; }
        .modal-bg.show { display: flex; }
        .modal { background: var(--surface); border: 1px solid var(--border); padding: 32px; max-width: 380px; width: 100%; text-align: center; }
        .modal h3 { font-family: 'Cinzel', serif; color: #fff; margin-bottom: 10px; font-size: 1.1rem; }
        .modal p { color: var(--muted); font-size: .88rem; margin-bottom: 24px; line-height: 1.5; }
        .modal-actions { display: flex; gap: 10px; }
        .modal-cancel { flex: 1; padding: 11px; background: transparent; border: 1px solid var(--border); color: var(--muted); font-family: 'Cinzel', serif; font-size: .65rem; letter-spacing: .12em; text-transform: uppercase; cursor: pointer; }
        .modal-cancel:hover { border-color: rgba(255,255,255,.2); color: var(--text); }
        .modal-end { flex: 1; padding: 11px; background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.45); color: #fca5a5; font-family: 'Cinzel', serif; font-size: .65rem; letter-spacing: .12em; text-transform: uppercase; cursor: pointer; }
        .modal-end:hover { background: rgba(239,68,68,.25); }

        /* ── Error banner ── */
        .error-banner { display: none; position: fixed; top: 60px; left: 50%; transform: translateX(-50%); z-index: 500; background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.4); color: #fca5a5; padding: 10px 20px; font-size: .82rem; font-family: 'Cinzel', serif; letter-spacing: .06em; white-space: nowrap; }
        .error-banner.show { display: block; }
    </style>
</head>
<body>

<div class="studio">

    {{-- TOP BAR --}}
    <header class="topbar">
        <div class="topbar-left">
            <span class="live-badge"><span class="live-dot"></span> Live</span>
            <span class="session-name">{{ $session->title }}</span>
        </div>
        <div class="topbar-right">
            <span class="viewer-count">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                <span id="viewerCount">{{ $approvedCount }}</span> approved students
            </span>
            <span class="timer" id="timer">00:00</span>
        </div>
    </header>

    {{-- MAIN --}}
    <div class="main-area">

        {{-- VIDEO STAGE --}}
        <div class="video-stage">
            <div class="stage-overlay" id="stageOverlay">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M15 10l4.553-2.07A1 1 0 0121 8.845v6.31a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                <span>Starting camera...</span>
            </div>
            <div id="local-player"></div>
            <div class="cam-off-overlay" id="camOffOverlay">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="1" y1="1" x2="23" y2="23"/><path d="M21 21H3a2 2 0 01-2-2V8a2 2 0 012-2h3m3-3h6l2 3h1a2 2 0 012 2v9.34m-7.72-2.06A2 2 0 019 13.5V13"/></svg>
                <span>Camera Off</span>
            </div>
            <div class="conn-status connecting" id="connStatus">
                <span class="conn-dot"></span>
                <span id="connLabel">Connecting</span>
            </div>
        </div>

        {{-- SIDE PANEL --}}
        <aside class="side-panel">
            <div class="panel-section">
                <div class="panel-label">Session Info</div>
                <div class="info-row">
                    <span class="label">Title</span>
                    <span class="value">{{ Str::limit($session->title, 22) }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Started</span>
                    <span class="value">{{ $session->started_at?->format('g:i A') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Approved</span>
                    <span class="value" id="sideViewerCount">{{ $approvedCount }} students</span>
                </div>
                <div class="panel-label" style="margin-top:12px">Channel</div>
                <div class="channel-code">{{ $channelName }}</div>
            </div>

            <div class="panel-section">
                <div class="panel-label">Your Stream</div>
                <div class="info-row">
                    <span class="label">Microphone</span>
                    <span id="micStatus" style="font-size:.75rem;color:#86efac">On</span>
                </div>
                <div class="info-row">
                    <span class="label">Camera</span>
                    <span id="camStatus" style="font-size:.75rem;color:#86efac">On</span>
                </div>
                <div class="info-row">
                    <span class="label">Role</span>
                    <span style="font-size:.75rem;color:var(--gold-light)">Host</span>
                </div>
            </div>

            <div class="viewer-section">
                <div class="panel-label">Live Viewers</div>
                <div id="viewerList">
                    <p class="viewer-empty">No viewers connected yet</p>
                </div>
            </div>
        </aside>
    </div>

    {{-- CONTROL BAR --}}
    <div class="controls">
        <button class="ctrl-btn active" id="micBtn" onclick="toggleMic()">
            <svg id="micIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 1a3 3 0 00-3 3v8a3 3 0 006 0V4a3 3 0 00-3-3z"/>
                <path d="M19 10v2a7 7 0 01-14 0v-2M12 19v4M8 23h8"/>
            </svg>
            <span id="micLabel">Mic On</span>
        </button>

        <button class="ctrl-btn active" id="camBtn" onclick="toggleCamera()">
            <svg id="camIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 10l4.553-2.07A1 1 0 0121 8.845v6.31a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
            </svg>
            <span id="camLabel">Cam On</span>
        </button>

        <div class="ctrl-divider"></div>

        <button class="end-btn" onclick="confirmEnd()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10.68 13.31a16 16 0 003.41 2.6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7 2 2 0 012 2v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.42 19.42 0 013.43 9.19 19.79 19.79 0 01.36 0.54 2 2 0 012.35 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.35 7.83a16 16 0 006.33 5.48z" style="display:none"/>
                <rect x="2" y="6" width="20" height="12" rx="2"/>
                <line x1="2" y1="6" x2="22" y2="18"/>
            </svg>
            End Session
        </button>
    </div>
</div>

{{-- END CONFIRM MODAL --}}
<div class="modal-bg" id="endModal">
    <div class="modal">
        <h3>End Live Session?</h3>
        <p>This will disconnect all viewers and mark the session as ended. You cannot restart it.</p>
        <div class="modal-actions">
            <button class="modal-cancel" onclick="closeModal()">Keep Broadcasting</button>
            <button class="modal-end" id="endConfirmBtn" onclick="endSessionNow()">End Session</button>
        </div>
    </div>
</div>

{{-- ERROR BANNER --}}
<div class="error-banner" id="errorBanner"></div>

{{-- Hidden form to end session --}}
<form id="endForm" method="POST" action="{{ route('admin.live-sessions.end', $session->id) }}" style="display:none">
    @csrf
</form>

<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
<script>
(function () {
    const APP_ID      = @json($appId);
    const CHANNEL     = @json($channelName);
    const TOKEN       = @json($token);
    const UID         = @json($uid);

    let client        = null;
    let localAudio    = null;
    let localVideo    = null;
    let micEnabled    = true;
    let camEnabled    = true;
    let viewerCount   = 0;
    let timerSeconds  = 0;
    let timerInterval = null;

    // ── UI helpers ──────────────────────────────────────
    function setConn(state, label) {
        const el = document.getElementById('connStatus');
        el.className = 'conn-status ' + state;
        document.getElementById('connLabel').textContent = label;
    }

    function showError(msg) {
        const b = document.getElementById('errorBanner');
        b.textContent = msg;
        b.classList.add('show');
        setTimeout(() => b.classList.remove('show'), 5000);
    }

    function hideOverlay() {
        const o = document.getElementById('stageOverlay');
        if (o) o.style.display = 'none';
    }

    function updateViewerUI(n) {
        document.getElementById('viewerCount').textContent = n;
        document.getElementById('sideViewerCount').textContent = n + ' connected';
    }

    // ── Timer ────────────────────────────────────────────
    function startTimer() {
        timerInterval = setInterval(function () {
            timerSeconds++;
            const m = String(Math.floor(timerSeconds / 60)).padStart(2, '0');
            const s = String(timerSeconds % 60).padStart(2, '0');
            document.getElementById('timer').textContent = m + ':' + s;
        }, 1000);
    }

    // ── Agora ────────────────────────────────────────────
    async function startBroadcast() {
        setConn('connecting', 'Connecting');

        try {
            client = AgoraRTC.createClient({ mode: 'live', codec: 'vp8' });

            // Track viewer joins / leaves
            client.on('user-joined', function (user) {
                viewerCount++;
                updateViewerUI(viewerCount);
                addViewerItem(user.uid);
            });
            client.on('user-left', function (user) {
                viewerCount = Math.max(0, viewerCount - 1);
                updateViewerUI(viewerCount);
                removeViewerItem(user.uid);
            });
            client.on('connection-state-change', function (cur) {
                if (cur === 'CONNECTED') setConn('connected', 'Connected');
                else if (cur === 'DISCONNECTING' || cur === 'DISCONNECTED') setConn('error', 'Disconnected');
                else setConn('connecting', 'Reconnecting');
            });

            await client.setClientRole('host');

            // Create mic + camera tracks
            [localAudio, localVideo] = await AgoraRTC.createMicrophoneAndCameraTracks(
                { echoCancellation: true, noiseSuppression: true },
                { encoderConfig: { width: 1280, height: 720, frameRate: 30, bitrateMax: 2000 } }
            );

            // Play local preview
            hideOverlay();
            localVideo.play('local-player');

            // Join & publish
            await client.join(APP_ID, CHANNEL, TOKEN, UID);
            await client.publish([localAudio, localVideo]);

            setConn('connected', 'Live');
            startTimer();

        } catch (err) {
            console.error('Broadcast error:', err);
            setConn('error', 'Error');
            if (err.name === 'NotAllowedError' || err.code === 'PERMISSION_DENIED') {
                showError('Camera/microphone permission denied. Please allow access in your browser.');
            } else if (err.name === 'NotFoundError') {
                showError('No camera or microphone found. Please connect a device and reload.');
            } else {
                showError('Failed to start broadcast: ' + (err.message || err.name || 'Unknown error'));
            }
        }
    }

    // ── Viewer list ──────────────────────────────────────
    function addViewerItem(uid) {
        const list = document.getElementById('viewerList');
        const empty = list.querySelector('.viewer-empty');
        if (empty) empty.remove();
        const item = document.createElement('div');
        item.className = 'viewer-item';
        item.id = 'viewer-' + uid;
        item.innerHTML = '<div class="viewer-avatar">' + String(uid).charAt(0) + '</div><div class="viewer-name">Viewer #' + uid + '</div>';
        list.appendChild(item);
    }
    function removeViewerItem(uid) {
        const el = document.getElementById('viewer-' + uid);
        if (el) el.remove();
        const list = document.getElementById('viewerList');
        if (!list.querySelector('.viewer-item')) {
            list.innerHTML = '<p class="viewer-empty">No viewers connected</p>';
        }
    }

    // ── Controls ─────────────────────────────────────────
    window.toggleMic = async function () {
        if (!localAudio) return;
        micEnabled = !micEnabled;
        await localAudio.setEnabled(micEnabled);
        const btn = document.getElementById('micBtn');
        const lbl = document.getElementById('micLabel');
        const status = document.getElementById('micStatus');
        if (micEnabled) {
            btn.className = 'ctrl-btn active';
            lbl.textContent = 'Mic On';
            status.textContent = 'On'; status.style.color = '#86efac';
        } else {
            btn.className = 'ctrl-btn muted-state';
            lbl.textContent = 'Muted';
            status.textContent = 'Muted'; status.style.color = '#fca5a5';
        }
    };

    window.toggleCamera = async function () {
        if (!localVideo) return;
        camEnabled = !camEnabled;
        await localVideo.setEnabled(camEnabled);
        const btn = document.getElementById('camBtn');
        const lbl = document.getElementById('camLabel');
        const overlay = document.getElementById('camOffOverlay');
        const status = document.getElementById('camStatus');
        if (camEnabled) {
            btn.className = 'ctrl-btn active';
            lbl.textContent = 'Cam On';
            overlay.classList.remove('show');
            status.textContent = 'On'; status.style.color = '#86efac';
        } else {
            btn.className = 'ctrl-btn cam-off-state';
            lbl.textContent = 'Cam Off';
            overlay.classList.add('show');
            status.textContent = 'Off'; status.style.color = '#fca5a5';
        }
    };

    window.confirmEnd = function () {
        document.getElementById('endModal').classList.add('show');
    };
    window.closeModal = function () {
        document.getElementById('endModal').classList.remove('show');
    };
    window.endSessionNow = async function () {
        document.getElementById('endConfirmBtn').textContent = 'Ending...';
        document.getElementById('endConfirmBtn').disabled = true;

        // Cleanup Agora
        try {
            if (localAudio) { localAudio.stop(); localAudio.close(); }
            if (localVideo) { localVideo.stop(); localVideo.close(); }
            if (client) { await client.unpublish(); await client.leave(); }
        } catch (e) { /* ignore cleanup errors */ }

        clearInterval(timerInterval);
        document.getElementById('endForm').submit();
    };

    // ── Warn before leaving without ending ───────────────
    window.addEventListener('beforeunload', function (e) {
        if (client && client.connectionState === 'CONNECTED') {
            e.preventDefault();
            e.returnValue = 'You are still broadcasting. Are you sure you want to leave?';
        }
    });

    // ── Start on load ────────────────────────────────────
    startBroadcast();
})();
</script>
</body>
</html>
