@extends('layouts.frontend')

@section('title', $session->title . ' — Live')

@push('styles')
<style>
    :root { --gold:#C9A84C; --gold-light:#E8C97A; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
    .ls-join-page { padding: 20px 20px 56px; max-width: 1100px; margin: 0 auto; }
    .ls-join-title { font-family: Cinzel, serif; font-size: clamp(1.2rem, 3vw, 1.8rem); color: #fff; margin-bottom: 20px; }
    .ls-join-title em { color: var(--gold); font-style: normal; }
    #video-container {
        width: 100%; height: 520px; background: #0a0a0a; border: 1px solid var(--border);
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
    }
    #video-container .ls-loading, #video-container .ls-msg {
        color: var(--muted); font-family: Cinzel, serif; font-size: .85rem; letter-spacing: .1em; text-transform: uppercase;
    }
    #video-container video { width: 100% !important; height: 100% !important; object-fit: cover !important; }
    .ls-join-meta { margin-top: 24px; padding: 20px; background: var(--card); border: 1px solid var(--border); }
    .ls-join-meta h2 { font-family: Cinzel, serif; font-size: 1rem; color: #fff; margin-bottom: 8px; }
    .ls-join-meta p { color: var(--muted); line-height: 1.55; margin-bottom: 6px; font-size: .9rem; }
    .ls-join-meta .host { color: var(--gold-light); }
    .ls-leave { display: inline-block; margin-top: 20px; padding: 10px 24px; border: 1px solid rgba(192,57,43,.5); color: #e07b73; font-family: Cinzel, serif; font-size: .68rem; letter-spacing: .14em; text-transform: uppercase; text-decoration: none; }
    .ls-leave:hover { background: rgba(192,57,43,.15); }
    #audio-unblock {
        display: none; position: absolute; inset: 0; z-index: 20;
        background: rgba(0,0,0,.7); align-items: center; justify-content: center; flex-direction: column; gap: 12px;
        cursor: pointer;
    }
    #audio-unblock.show { display: flex; }
    #audio-unblock span { font-family: Cinzel, serif; font-size: .85rem; letter-spacing: .12em; text-transform: uppercase; color: var(--gold-light); }
    #audio-unblock svg { width: 40px; height: 40px; stroke: var(--gold); fill: none; stroke-width: 1.5; }

    /* ── Live Chat ── */
    .ls-chat-wrap { margin-top: 20px; background: var(--card); border: 1px solid var(--border); }
    .ls-chat-header { padding: 10px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; }
    .ls-chat-header span { font-family: Cinzel, serif; font-size: .62rem; letter-spacing: .15em; text-transform: uppercase; color: var(--gold); }
    .ls-chat-messages { height: 220px; overflow-y: auto; padding: 12px 16px; display: flex; flex-direction: column; gap: 10px; }
    .ls-chat-empty { color: var(--muted); font-size: .8rem; font-style: italic; text-align: center; padding: 20px 0; }
    .ls-chat-meta { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px; }
    .ls-chat-name { font-size: .72rem; color: var(--gold-light); font-weight: 600; }
    .ls-chat-name.is-self { color: #86efac; }
    .ls-chat-time { font-size: .65rem; color: var(--muted); }
    .ls-chat-text { font-size: .83rem; color: var(--text); line-height: 1.45; word-break: break-word; }
    .ls-chat-form { display: flex; border-top: 1px solid var(--border); }
    .ls-chat-input { flex: 1; background: transparent; border: none; padding: 11px 14px; color: var(--text); font-size: .85rem; outline: none; font-family: inherit; }
    .ls-chat-input::placeholder { color: var(--muted); }
    .ls-chat-send { background: rgba(201,168,76,.15); border: none; border-left: 1px solid var(--border); padding: 11px 18px; color: var(--gold-light); font-family: Cinzel, serif; font-size: .58rem; letter-spacing: .1em; text-transform: uppercase; cursor: pointer; transition: background .2s; white-space: nowrap; }
    .ls-chat-send:hover { background: rgba(201,168,76,.28); }
    .ls-chat-send:disabled { opacity: .45; cursor: default; }
</style>
@endpush

@section('content')
<div class="ls-join-page">
    <h1 class="ls-join-title">{{ $session->title }} <em>— Live</em></h1>

    <div id="video-container">
        <p class="ls-loading" id="videoLoading">Connecting to live session...</p>
        <div id="audio-unblock">
            <svg viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/></svg>
            <span>Tap to enable audio</span>
        </div>
    </div>

    <div class="ls-join-meta">
        <p class="host">Host: {{ $session->admin?->name ?? 'Instructor' }}</p>
        <h2>{{ $session->title }}</h2>
        <p>{{ $session->description ?: 'Live session in progress.' }}</p>
    </div>

    <a href="{{ route('live-sessions.index') }}" class="ls-leave">Leave Session</a>

    {{-- Live Chat Panel --}}
    <div class="ls-chat-wrap">
        <div class="ls-chat-header">
            <svg style="width:13px;height:13px;stroke:var(--gold);fill:none;stroke-width:2;flex-shrink:0" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            <span>Live Chat</span>
        </div>
        <div class="ls-chat-messages" id="chatMessages">
            <p class="ls-chat-empty" id="chatEmpty">Send a message to the host...</p>
        </div>
        <form class="ls-chat-form" id="chatForm">
            <input type="text" id="chatInput" class="ls-chat-input" placeholder="Type a message..." maxlength="500" autocomplete="off">
            <button type="submit" class="ls-chat-send" id="chatSendBtn">Send</button>
        </form>
    </div>
</div>

<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
@endsection

@push('scripts')
<script>
(function () {
    const appId       = @json($appId);
    const channelName = @json($channelName);
    const token       = @json($token);
    const uid         = @json($uid);
    const container   = document.getElementById('video-container');
    const loadingEl   = document.getElementById('videoLoading');
    const audioUnblock = document.getElementById('audio-unblock');

    const audioTracks = []; // all subscribed audio tracks

    function showStatus(text) {
        if (loadingEl) { loadingEl.style.display = 'block'; loadingEl.textContent = text; }
    }

    function showMessage(text) {
        // Clear any Agora video elements then show message
        clearVideoElements();
        container.innerHTML = '<p class="ls-msg">' + text + '</p>';
    }

    // Remove all Agora-injected video/div elements from container
    // but keep the loading text and audio-unblock overlay
    function clearVideoElements() {
        Array.from(container.children).forEach(function (el) {
            if (el !== loadingEl && el !== audioUnblock) el.remove();
        });
    }

    // Always clears old video first — safe to call on every new track
    function renderVideo(user) {
        clearVideoElements();
        if (loadingEl) loadingEl.style.display = 'none';
        user.videoTrack.play(container);
    }

    function playAudio(track) {
        // Avoid duplicate subscriptions
        if (audioTracks.indexOf(track) === -1) audioTracks.push(track);
        track.play().catch(function () {
            audioUnblock.classList.add('show');
        });
    }

    audioUnblock.addEventListener('click', function () {
        audioUnblock.classList.remove('show');
        audioTracks.forEach(function (t) { try { t.play(); } catch(e){} });
    });

    AgoraRTC.onAutoplayFailed = function () {
        audioUnblock.classList.add('show');
    };

    if (!appId || !token || !channelName) {
        showMessage('Unable to connect to live session');
        return;
    }

    const client = AgoraRTC.createClient({ mode: 'live', codec: 'vp8' });

    // user-published fires for BOTH initial stream AND when host switches camera↔screen
    client.on('user-published', async function (user, mediaType) {
        try {
            await client.subscribe(user, mediaType);
            if (mediaType === 'video') renderVideo(user);
            if (mediaType === 'audio') playAudio(user.audioTrack);
        } catch (e) {
            console.error('Subscribe error:', e);
        }
    });

    client.on('user-unpublished', function (user, mediaType) {
        if (mediaType === 'video') {
            // Clear the old video — new one will arrive immediately via user-published
            clearVideoElements();
            showStatus('Switching stream...');
        }
    });

    client.on('user-left', function () {
        showMessage('Host has ended the session');
    });

    client.on('connection-state-change', function (curState) {
        if (curState === 'DISCONNECTED') showMessage('Disconnected from session');
    });

    // Subscribe to a user who was already broadcasting when we joined
    async function subscribeToExistingUser(user) {
        try {
            if (user.hasVideo) {
                await client.subscribe(user, 'video');
                renderVideo(user);
            }
            if (user.hasAudio) {
                await client.subscribe(user, 'audio');
                playAudio(user.audioTrack);
            }
        } catch (e) {
            console.error('Subscribe error:', e);
        }
    }

    async function joinSession() {
        try {
            await client.setClientRole('audience', { level: 1 });
            await client.join(appId, channelName, token, uid);

            // If host is already broadcasting (camera OR screen share), subscribe immediately
            if (client.remoteUsers && client.remoteUsers.length > 0) {
                for (const user of client.remoteUsers) {
                    await subscribeToExistingUser(user);
                }
            }

            if (!container.querySelector('video')) {
                showStatus('Connected — waiting for host to stream...');
            }
        } catch (err) {
            console.error('Join error:', err);
            showMessage('Unable to connect: ' + (err.message || err.code || 'Unknown error'));
        }
    }

    joinSession();
})();
</script>

{{-- Live Chat JS --}}
<script>
(function () {
    const COMMENT_URL   = @json($commentUrl);
    const STUDENT_NAME  = @json($studentName);
    const CSRF          = document.querySelector('meta[name="csrf-token"]')?.content || '';

    const form      = document.getElementById('chatForm');
    const input     = document.getElementById('chatInput');
    const sendBtn   = document.getElementById('chatSendBtn');
    const msgBox    = document.getElementById('chatMessages');

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
        el.className = 'ls-chat-msg';
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
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify({ message: msg }),
            });

            if (!res.ok) {
                // Show a subtle error indicator on the last message
                const last = msgBox.lastElementChild;
                if (last) last.style.opacity = '0.45';
                console.error('Chat POST failed:', res.status, await res.text());
            }
        } catch (err) {
            console.error('Chat send error:', err);
        } finally {
            sendBtn.disabled = false;
            input.focus();
        }
    });

    // Allow Enter key (already default for submit, but handle Shift+Enter to prevent send)
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            // default submit happens — nothing extra needed
        }
    });
})();
</script>
@endpush
