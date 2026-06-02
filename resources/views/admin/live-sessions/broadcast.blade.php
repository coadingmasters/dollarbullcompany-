<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .panel-section { padding: 12px 16px; border-bottom: 1px solid var(--border); flex-shrink: 0; }
        .panel-label { font-family: 'Cinzel', serif; font-size: .55rem; letter-spacing: .18em; text-transform: uppercase; color: var(--gold); margin-bottom: 10px; }
        .info-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; font-size: .8rem; }
        .info-row .label { color: var(--muted); }
        .info-row .value { color: var(--text); font-size: .78rem; }
        .channel-code { font-family: monospace; font-size: .7rem; color: var(--gold-light); word-break: break-all; }

        /* Viewer list */
        .viewer-section { max-height: 90px; overflow-y: auto; padding: 8px 16px; border-bottom: 1px solid var(--border); flex-shrink: 0; }
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

        /* Screen share button states */
        .ctrl-btn.screen-active {
            background: rgba(99,102,241,.18); border-color: rgba(99,102,241,.55); color: #a5b4fc;
        }

        /* Screen sharing overlay on the stage */
        .screen-share-overlay {
            position: absolute; inset: 0; background: rgba(6,6,6,.82);
            display: none; align-items: center; justify-content: center;
            flex-direction: column; gap: 10px; color: #a5b4fc; z-index: 5;
            pointer-events: none;
        }
        .screen-share-overlay svg { width: 40px; height: 40px; opacity: .7; }
        .screen-share-overlay span { font-family: 'Cinzel', serif; font-size: .72rem; letter-spacing: .12em; text-transform: uppercase; }
        .screen-share-overlay.show { display: flex; }

        /* ── Error banner ── */
        .error-banner { display: none; position: fixed; top: 60px; left: 50%; transform: translateX(-50%); z-index: 500; background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.4); color: #fca5a5; padding: 10px 20px; font-size: .82rem; font-family: 'Cinzel', serif; letter-spacing: .06em; white-space: nowrap; }
        .error-banner.show { display: block; }

        /* ── Enrollment notifications ── */
        .notif-stack { position: fixed; top: 60px; right: 292px; z-index: 400; display: flex; flex-direction: column; gap: 8px; max-height: calc(100vh - 160px); overflow-y: auto; overflow-x: visible; padding: 10px; width: 270px; pointer-events: none; }
        .notif-card { background: rgba(10,10,10,.97); border: 1px solid rgba(212,160,23,.4); border-left: 3px solid var(--gold); padding: 12px 13px; pointer-events: all; animation: notifIn .28s ease forwards; }
        .notif-card.out { animation: notifOut .25s ease forwards; }
        @keyframes notifIn  { from { opacity:0; transform:translateX(18px); } to { opacity:1; transform:translateX(0); } }
        @keyframes notifOut { from { opacity:1; transform:translateX(0); }    to { opacity:0; transform:translateX(18px); } }
        .notif-hd { font-family: 'Cinzel', serif; font-size: .56rem; letter-spacing: .14em; text-transform: uppercase; color: var(--gold); margin-bottom: 7px; display: flex; align-items: center; gap: 6px; }
        .notif-hd::before { content: ''; display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: var(--gold); animation: pulse 1s ease-in-out infinite; flex-shrink: 0; }
        .notif-name { font-size: .82rem; color: #fff; font-weight: 600; margin-bottom: 2px; }
        .notif-meta { font-size: .72rem; color: var(--muted); margin-bottom: 9px; line-height: 1.4; }
        .notif-actions { display: flex; gap: 7px; }
        .notif-approve { flex: 1; padding: 6px 0; background: rgba(34,197,94,.14); border: 1px solid rgba(34,197,94,.4); color: #86efac; font-family: 'Cinzel', serif; font-size: .55rem; letter-spacing: .1em; text-transform: uppercase; cursor: pointer; transition: background .2s; }
        .notif-approve:hover { background: rgba(34,197,94,.25); }
        .notif-reject  { flex: 1; padding: 6px 0; background: rgba(239,68,68,.12); border: 1px solid rgba(239,68,68,.35); color: #fca5a5; font-family: 'Cinzel', serif; font-size: .55rem; letter-spacing: .1em; text-transform: uppercase; cursor: pointer; transition: background .2s; }
        .notif-reject:hover  { background: rgba(239,68,68,.22); }

        /* ── Pending list in side panel ── */
        .pending-item { padding: 8px 0; border-bottom: 1px solid var(--border); }
        .pending-item:last-child { border-bottom: none; }
        .pending-name { font-size: .78rem; color: var(--text); margin-bottom: 2px; }
        .pending-email { font-size: .7rem; color: var(--muted); margin-bottom: 6px; }
        .pending-actions { display: flex; gap: 5px; }
        .pa-approve { flex:1; padding:4px 0; background:rgba(34,197,94,.12); border:1px solid rgba(34,197,94,.35); color:#86efac; font-family:'Cinzel',serif; font-size:.5rem; letter-spacing:.08em; text-transform:uppercase; cursor:pointer; }
        .pa-reject  { flex:1; padding:4px 0; background:rgba(239,68,68,.1);  border:1px solid rgba(239,68,68,.3);  color:#fca5a5; font-family:'Cinzel',serif; font-size:.5rem; letter-spacing:.08em; text-transform:uppercase; cursor:pointer; }

        /* ── Live Chat (admin receives) ── */
        .chat-section { flex: 1; display: flex; flex-direction: column; min-height: 220px; overflow: hidden; border-top: 1px solid var(--border); }
        .chat-section-header { padding: 10px 16px 8px; border-bottom: 1px solid var(--border); flex-shrink: 0; display: flex; align-items: center; gap: 6px; background: var(--card); }
        .chat-section-header .panel-label { margin: 0; }
        .chat-messages { flex: 1; overflow-y: auto; padding: 8px 14px 12px; display: flex; flex-direction: column; gap: 9px; min-height: 0; }
        .chat-msg-meta { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px; }
        .chat-msg-name { font-size: .68rem; color: var(--gold-light); font-weight: 600; }
        .chat-msg-time { font-size: .62rem; color: var(--muted); }
        .chat-msg-text { font-size: .78rem; color: var(--text); line-height: 1.4; word-break: break-word; }
        .chat-msg-empty { font-size: .75rem; color: var(--muted); font-style: italic; text-align: center; padding: 20px 0; }
        @keyframes chatIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
        .chat-msg-new  { animation: chatIn .22s ease forwards; }
        .chat-msg-item { }
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
            <div class="screen-share-overlay" id="screenShareOverlay">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="3" width="20" height="14" rx="2"/>
                    <path d="M8 21h8M12 17v4"/>
                    <path d="M15 8l3 3-3 3M18 11H10"/>
                </svg>
                <span>Screen Sharing Active</span>
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
                    <span class="label">Screen</span>
                    <span id="screenStatus" style="font-size:.75rem;color:var(--muted)">Off</span>
                </div>
                <div class="info-row">
                    <span class="label">Role</span>
                    <span style="font-size:.75rem;color:var(--gold-light)">Host</span>
                </div>
            </div>

            {{-- Pending Enrollments --}}
            <div class="panel-section" style="flex-shrink:0">
                <div class="panel-label" style="display:flex;align-items:center;gap:6px">
                    Pending
                    <span id="pendingBadge" style="background:rgba(239,68,68,.22);border:1px solid rgba(239,68,68,.4);color:#fca5a5;padding:1px 7px;font-size:.58rem;border-radius:2px">{{ $pendingEnrollments->count() }}</span>
                </div>
                <div id="pendingList" style="max-height:180px;overflow-y:auto">
                    @forelse($pendingEnrollments as $pe)
                        <div class="pending-item" id="pitem-{{ $pe->id }}">
                            <div class="pending-name">{{ trim(($pe->first_name ?? '') . ' ' . ($pe->last_name ?? '')) ?: 'Student' }}</div>
                            <div class="pending-email">{{ $pe->email }}</div>
                            <div class="pending-actions">
                                <button class="pa-approve" onclick="enrollAction({{ $pe->id }},'approve',this)">Approve</button>
                                <button class="pa-reject"  onclick="enrollAction({{ $pe->id }},'reject',this)">Reject</button>
                            </div>
                        </div>
                    @empty
                        <p id="pendingEmpty" style="font-size:.72rem;color:var(--muted);font-style:italic;padding:6px 0">No pending enrollments</p>
                    @endforelse
                </div>
            </div>

            <div class="viewer-section">
                <div class="panel-label">Live Viewers</div>
                <div id="viewerList">
                    <p class="viewer-empty">No viewers connected yet</p>
                </div>
            </div>

            {{-- Live Chat (real-time comments from viewers) --}}
            <div class="chat-section">
                <div class="chat-section-header">
                    <svg style="width:11px;height:11px;stroke:var(--gold);fill:none;stroke-width:2;flex-shrink:0" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    <div class="panel-label">Live Chat</div>
                </div>
                <div class="chat-messages" id="chatMessages">
                    @if($chatMessages->isEmpty())
                        <p class="chat-msg-empty" id="chatEmpty">No messages yet...</p>
                    @else
                        @foreach($chatMessages as $cm)
                            <div class="chat-msg-item">
                                <div class="chat-msg-meta">
                                    <span class="chat-msg-name">{{ e($cm->student_name) }}</span>
                                    <span class="chat-msg-time">{{ $cm->created_at->format('H:i') }}</span>
                                </div>
                                <div class="chat-msg-text">{{ e($cm->message) }}</div>
                            </div>
                        @endforeach
                    @endif
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

        <button class="ctrl-btn" id="screenBtn" onclick="toggleScreenShare()">
            <svg id="screenIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="3" width="20" height="14" rx="2"/>
                <path d="M8 21h8M12 17v4"/>
                <path d="M15 8l3 3-3 3M18 11H10"/>
            </svg>
            <span id="screenLabel">Share Screen</span>
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

{{-- Floating enrollment notifications --}}
<div class="notif-stack" id="notifStack"></div>

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

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
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
    let screenTrack   = null;
    let micEnabled    = true;
    let camEnabled    = true;
    let screenEnabled = false;
    let isConnected   = false;
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
    async function createTracks() {
        const audioConfig = { echoCancellation: true, noiseSuppression: true };
        const videoConfigs = [
            { encoderConfig: { width: 1280, height: 720,  frameRate: 30, bitrateMax: 2000 } },
            { encoderConfig: { width: 640,  height: 480,  frameRate: 24, bitrateMax: 1000 } },
            { encoderConfig: { width: 320,  height: 240,  frameRate: 15, bitrateMax: 500  } },
        ];

        for (const [i, videoCfg] of videoConfigs.entries()) {
            try {
                if (i > 0) {
                    const res = videoCfg.encoderConfig;
                    showError('Camera timeout at HD — retrying at ' + res.width + '×' + res.height + '…');
                    await new Promise(r => setTimeout(r, 600));
                }
                return await AgoraRTC.createMicrophoneAndCameraTracks(audioConfig, videoCfg);
            } catch (err) {
                const isTimeout = err.name === 'AbortError' || (err.message && err.message.toLowerCase().includes('timeout'));
                const isUnexpected = err.code === 'UNEXPECTED_ERROR' || err.name === 'UNEXPECTED_ERROR';
                if ((isTimeout || isUnexpected) && i < videoConfigs.length - 1) continue;
                // Not a timeout or exhausted retries — re-throw
                throw err;
            }
        }

        // All video attempts failed — try mic only
        showError('Camera unavailable — connecting with microphone only.');
        const audio = await AgoraRTC.createMicrophoneAudioTrack(audioConfig);
        return [audio, null];
    }

    async function startBroadcast() {
        setConn('connecting', 'Connecting');

        try {
            client = AgoraRTC.createClient({ mode: 'live', codec: 'vp8' });

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

            [localAudio, localVideo] = await createTracks();

            hideOverlay();

            if (localVideo) {
                localVideo.play('local-player');
            } else {
                // No camera — show cam-off overlay and update UI
                document.getElementById('camOffOverlay').classList.add('show');
                camEnabled = false;
                document.getElementById('camBtn').className = 'ctrl-btn cam-off-state';
                document.getElementById('camLabel').textContent = 'No Cam';
                document.getElementById('camStatus').textContent = 'Unavailable';
                document.getElementById('camStatus').style.color = '#fca5a5';
            }

            await client.join(APP_ID, CHANNEL, TOKEN, UID);

            isConnected = true; // mark connected right after join — before publish

            const tracksToPublish = [localAudio, localVideo].filter(Boolean);
            await client.publish(tracksToPublish);

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

        const btn     = document.getElementById('camBtn');
        const lbl     = document.getElementById('camLabel');
        const overlay = document.getElementById('camOffOverlay');
        const status  = document.getElementById('camStatus');

        if (screenEnabled) {
            // Screen share is active — just update the camera track state
            // (camera is not currently published, so no Agora publish/unpublish needed)
            await localVideo.setEnabled(camEnabled);
            if (camEnabled) {
                btn.className = 'ctrl-btn active';
                lbl.textContent = 'Cam On';
                status.textContent = 'On'; status.style.color = '#86efac';
            } else {
                btn.className = 'ctrl-btn cam-off-state';
                lbl.textContent = 'Cam Off';
                status.textContent = 'Off'; status.style.color = '#fca5a5';
            }
            return;
        }

        await localVideo.setEnabled(camEnabled);
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

    // ── Screen Share ─────────────────────────────────────
    window.toggleScreenShare = async function () {
        // Use Agora's actual connection state — not a manual flag that can get out of sync
        if (!client || client.connectionState !== 'CONNECTED') {
            showError('Please wait until the broadcast is live before sharing your screen.');
            return;
        }
        if (screenEnabled) {
            await stopScreenShare();
        } else {
            await startScreenShare();
        }
    };

    async function startScreenShare() {
        try {
            // Create screen track (disable screen audio to avoid echo)
            screenTrack = await AgoraRTC.createScreenVideoTrack(
                { encoderConfig: '1080p_1', optimizationMode: 'detail' },
                'disable'
            );

            // When user clicks the browser's built-in "Stop sharing" button
            screenTrack.on('track-ended', async function () {
                await stopScreenShare();
            });

            // Swap: unpublish camera, publish screen
            if (localVideo) {
                await client.unpublish(localVideo);
                localVideo.stop();
            }
            await client.publish(screenTrack);

            // Show screen track in the stage
            document.getElementById('camOffOverlay').classList.remove('show');
            screenTrack.play('local-player');

            screenEnabled = true;
            updateScreenUI(true);

        } catch (err) {
            console.error('Screen share error:', err);
            // Clean up if track was partially created
            if (screenTrack) { try { screenTrack.close(); } catch(e){} screenTrack = null; }
            if (err.name === 'NotAllowedError') {
                showError('Screen sharing permission denied or cancelled.');
            } else {
                showError('Could not start screen share: ' + (err.message || err.name));
            }
        }
    }

    async function stopScreenShare() {
        if (!screenTrack) return;

        try {
            await client.unpublish(screenTrack);
            screenTrack.stop();
            screenTrack.close();
        } catch (e) { /* ignore */ }
        screenTrack = null;
        screenEnabled = false;

        // Restore camera stream
        if (localVideo) {
            if (camEnabled) {
                try {
                    await client.publish(localVideo);
                    localVideo.play('local-player');
                    document.getElementById('camOffOverlay').classList.remove('show');
                } catch (e) { console.error('Camera restore error:', e); }
            } else {
                document.getElementById('camOffOverlay').classList.add('show');
            }
        }

        updateScreenUI(false);
    }

    function updateScreenUI(isSharing) {
        const btn    = document.getElementById('screenBtn');
        const lbl    = document.getElementById('screenLabel');
        const status = document.getElementById('screenStatus');
        const overlay = document.getElementById('screenShareOverlay');

        if (isSharing) {
            btn.className = 'ctrl-btn screen-active';
            lbl.textContent = 'Stop Sharing';
            status.textContent = 'Sharing'; status.style.color = '#a5b4fc';
            overlay.classList.add('show');
        } else {
            btn.className = 'ctrl-btn';
            lbl.textContent = 'Share Screen';
            status.textContent = 'Off'; status.style.color = 'var(--muted)';
            overlay.classList.remove('show');
        }
    }

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
            if (screenTrack) { screenTrack.stop(); screenTrack.close(); }
            if (localAudio)  { localAudio.stop();  localAudio.close(); }
            if (localVideo)  { localVideo.stop();  localVideo.close(); }
            if (client)      { await client.unpublish(); await client.leave(); }
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

<script>
(function () {
    const SESSION_ID   = @json($session->id);
    const PUSHER_KEY   = @json(config('broadcasting.connections.pusher.key'));
    const PUSHER_CLUST = @json(config('broadcasting.connections.pusher.options.cluster'));
    const CSRF         = document.querySelector('meta[name="csrf-token"]').content;
    const APPROVE_URL  = (id) => '/admin/live-session-enrollments/' + id + '/approve';
    const REJECT_URL   = (id) => '/admin/live-session-enrollments/' + id + '/reject';
    const POLL_PENDING = '/admin/live-sessions/' + SESSION_ID + '/poll-pending';
    const POLL_MSGS    = '/admin/live-sessions/' + SESSION_ID + '/poll-messages';

    let pendingCount    = parseInt(document.getElementById('pendingBadge').textContent, 10) || 0;
    let seenEnrollIds   = new Set();
    let lastMsgId       = @json($lastMessageId);
    let pusherConnected = false;

    // Seed already-shown pending items so polling doesn't duplicate them
    document.querySelectorAll('.pending-item[id^="pitem-"]').forEach(function (el) {
        seenEnrollIds.add(parseInt(el.id.replace('pitem-', ''), 10));
    });

    // ── Pusher status pill (we add it to the topbar) ──────
    const statusPill = document.createElement('span');
    statusPill.id = 'rtStatus';
    statusPill.style.cssText = 'font-family:Cinzel,serif;font-size:.52rem;letter-spacing:.12em;text-transform:uppercase;padding:3px 9px;border-radius:2px;border:1px solid;transition:all .3s';
    setPillState('connecting');
    document.querySelector('.topbar-right').prepend(statusPill);

    function setPillState(state) {
        const states = {
            connecting: ['Connecting…',  'rgba(234,179,8,.15)',  'rgba(234,179,8,.4)',  '#fde047'],
            live:       ['● Real-Time',  'rgba(34,197,94,.12)',  'rgba(34,197,94,.4)',  '#86efac'],
            poll:       ['↻ Polling',    'rgba(99,102,241,.12)', 'rgba(99,102,241,.4)', '#a5b4fc'],
            error:      ['⚠ No Signal',  'rgba(239,68,68,.12)',  'rgba(239,68,68,.4)',  '#fca5a5'],
        };
        const [text, bg, border, color] = states[state] || states.connecting;
        statusPill.textContent      = text;
        statusPill.style.background = bg;
        statusPill.style.borderColor = border;
        statusPill.style.color      = color;
    }

    // ── Pusher connection ─────────────────────────────────
    const pusher  = new Pusher(PUSHER_KEY, { cluster: PUSHER_CLUST, forceTLS: true });
    const channel = pusher.subscribe('live-session-admin.' + SESSION_ID);

    pusher.connection.bind('connected', function () {
        pusherConnected = true;
        setPillState('live');
    });
    pusher.connection.bind('disconnected', function () {
        pusherConnected = false;
        setPillState('poll');
    });
    pusher.connection.bind('failed', function () {
        pusherConnected = false;
        setPillState('error');
    });

    channel.bind('new-enrollment', function (data) {
        if (seenEnrollIds.has(data.enrollment_id)) return;
        seenEnrollIds.add(data.enrollment_id);
        addToPendingList(data);
        showNotifCard(data);
        pendingCount++;
        updateBadge();
    });

    channel.bind('new-comment', function (data) {
        const id = data.id || 0;
        if (id && id <= lastMsgId) return;
        if (id) lastMsgId = id;
        addChatMessage(data.name, data.message, data.time);
    });

    // ── AJAX Polling fallback (always runs, deduplication handles doubles) ──
    async function pollPending() {
        const maxSeen = seenEnrollIds.size > 0 ? Math.max(...seenEnrollIds) : 0;
        try {
            const res  = await fetch(POLL_PENDING + '?since=' + maxSeen, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();
            (data.enrollments || []).forEach(function (e) {
                if (seenEnrollIds.has(e.enrollment_id)) return;
                seenEnrollIds.add(e.enrollment_id);
                addToPendingList(e);
                showNotifCard(e);
                pendingCount++;
                updateBadge();
            });
        } catch (err) { /* silent */ }
    }

    async function pollMessages() {
        try {
            const res  = await fetch(POLL_MSGS + '?since=' + lastMsgId, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();
            (data.messages || []).forEach(function (m) {
                if (m.id <= lastMsgId) return;
                lastMsgId = m.id;
                addChatMessage(m.name, m.message, m.time);
            });
        } catch (err) { /* silent */ }
    }

    // Scroll chat history to bottom on load
    (function () {
        const box = document.getElementById('chatMessages');
        if (box) box.scrollTop = box.scrollHeight;
    })();

    // Poll every 4 seconds (works with or without Pusher)
    setInterval(pollPending, 4000);
    setInterval(pollMessages, 4000);

    // ── Live Chat helpers ─────────────────────────────────
    function addChatMessage(name, message, time) {
        const empty = document.getElementById('chatEmpty');
        if (empty) empty.remove();

        const box = document.getElementById('chatMessages');
        const el  = document.createElement('div');
        el.className = 'chat-msg-new';
        el.innerHTML =
            '<div class="chat-msg-meta">' +
                '<span class="chat-msg-name">' + esc(name) + '</span>' +
                '<span class="chat-msg-time">' + esc(time) + '</span>' +
            '</div>' +
            '<div class="chat-msg-text">' + esc(message) + '</div>';
        box.appendChild(el);
        box.scrollTop = box.scrollHeight;
    }

    // ── Pending list helpers ──────────────────────────────
    function addToPendingList(data) {
        const empty = document.getElementById('pendingEmpty');
        if (empty) empty.remove();

        const list = document.getElementById('pendingList');
        const div  = document.createElement('div');
        div.className = 'pending-item';
        div.id = 'pitem-' + data.enrollment_id;
        div.innerHTML =
            '<div class="pending-name">' + esc(data.name) + '</div>' +
            '<div class="pending-email">' + esc(data.email) + (data.country ? ' · ' + esc(data.country) : '') + '</div>' +
            '<div class="pending-actions">' +
              '<button class="pa-approve" onclick="enrollAction(' + data.enrollment_id + ',\'approve\',this)">Approve</button>' +
              '<button class="pa-reject"  onclick="enrollAction(' + data.enrollment_id + ',\'reject\',this)">Reject</button>' +
            '</div>';
        list.prepend(div);
    }

    // ── Floating notification card ────────────────────────
    function showNotifCard(data) {
        const stack = document.getElementById('notifStack');
        const card  = document.createElement('div');
        card.className = 'notif-card';
        card.id = 'notif-' + data.enrollment_id;
        card.innerHTML =
            '<div class="notif-hd">New Enrollment</div>' +
            '<div class="notif-name">' + esc(data.name) + '</div>' +
            '<div class="notif-meta">' +
              esc(data.email) +
              (data.country ? '<br>' + esc(data.country) : '') +
              (data.whatsapp ? ' · ' + esc(data.whatsapp) : '') +
            '</div>' +
            '<div class="notif-actions">' +
              '<button class="notif-approve" onclick="enrollAction(' + data.enrollment_id + ',\'approve\',this)">✓ Approve</button>' +
              '<button class="notif-reject"  onclick="enrollAction(' + data.enrollment_id + ',\'reject\',this)">✕ Reject</button>' +
            '</div>';
        stack.appendChild(card);
        setTimeout(() => dismissCard('notif-' + data.enrollment_id), 60000);
    }

    function dismissCard(id) {
        const card = document.getElementById(id);
        if (!card) return;
        card.classList.add('out');
        setTimeout(() => card && card.remove(), 280);
    }

    // ── Approve / Reject ──────────────────────────────────
    window.enrollAction = async function (enrollmentId, action, btn) {
        btn.disabled = true;
        btn.textContent = action === 'approve' ? 'Approving…' : 'Rejecting…';

        const url = action === 'approve' ? APPROVE_URL(enrollmentId) : REJECT_URL(enrollmentId);

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });

            if (!res.ok) throw new Error('Request failed');

            const pitem = document.getElementById('pitem-' + enrollmentId);
            if (pitem) pitem.remove();
            if (!document.querySelector('.pending-item')) {
                document.getElementById('pendingList').innerHTML =
                    '<p id="pendingEmpty" style="font-size:.72rem;color:var(--muted);font-style:italic;padding:6px 0">No pending enrollments</p>';
            }

            dismissCard('notif-' + enrollmentId);

            pendingCount = Math.max(0, pendingCount - 1);
            updateBadge();
            if (action === 'approve') {
                const approved = parseInt(document.getElementById('viewerCount').textContent, 10) || 0;
                document.getElementById('viewerCount').textContent = approved + 1;
                document.getElementById('sideViewerCount').textContent = (approved + 1) + ' approved';
            }

        } catch (e) {
            btn.disabled = false;
            btn.textContent = action === 'approve' ? 'Approve' : 'Reject';
        }
    };

    function updateBadge() {
        const badge = document.getElementById('pendingBadge');
        badge.textContent = pendingCount;
        badge.style.background  = pendingCount > 0 ? 'rgba(239,68,68,.22)' : 'rgba(255,255,255,.06)';
        badge.style.borderColor = pendingCount > 0 ? 'rgba(239,68,68,.4)'  : 'rgba(255,255,255,.12)';
        badge.style.color       = pendingCount > 0 ? '#fca5a5'             : 'var(--muted)';
    }

    function esc(str) {
        const d = document.createElement('div');
        d.textContent = String(str || '');
        return d.innerHTML;
    }
})();
</script>
</body>
</html>
