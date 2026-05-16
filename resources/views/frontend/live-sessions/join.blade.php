@extends('layouts.frontend')

@section('title', $session->title . ' — Live')

@push('styles')
<style>
    :root { --gold:#C9A84C; --gold-light:#E8C97A; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
    .ls-join-page { padding: 20px 20px 56px; max-width: 1100px; margin: 0 auto; }
    .ls-join-title { font-family: Cinzel, serif; font-size: clamp(1.2rem, 3vw, 1.8rem); color: #fff; margin-bottom: 20px; }
    .ls-join-title em { color: var(--gold); font-style: normal; }
    #video-container {
        width: 100%; min-height: 500px; background: #0a0a0a; border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;
    }
    #video-container .ls-loading, #video-container .ls-msg {
        color: var(--muted); font-family: Cinzel, serif; font-size: .85rem; letter-spacing: .1em; text-transform: uppercase;
    }
    #video-container video { width: 100%; height: 100%; min-height: 500px; object-fit: contain; background: #000; }
    .ls-join-meta { margin-top: 24px; padding: 20px; background: var(--card); border: 1px solid var(--border); }
    .ls-join-meta h2 { font-family: Cinzel, serif; font-size: 1rem; color: #fff; margin-bottom: 8px; }
    .ls-join-meta p { color: var(--muted); line-height: 1.55; margin-bottom: 6px; font-size: .9rem; }
    .ls-join-meta .host { color: var(--gold-light); }
    .ls-leave { display: inline-block; margin-top: 20px; padding: 10px 24px; border: 1px solid rgba(192,57,43,.5); color: #e07b73; font-family: Cinzel, serif; font-size: .68rem; letter-spacing: .14em; text-transform: uppercase; text-decoration: none; }
    .ls-leave:hover { background: rgba(192,57,43,.15); }
</style>
@endpush

@section('content')
<div class="ls-join-page">
    <h1 class="ls-join-title">{{ $session->title }} <em>— Live</em></h1>

    <div id="video-container">
        <p class="ls-loading" id="videoLoading">Connecting to live session...</p>
    </div>

    <div class="ls-join-meta">
        <p class="host">Host: {{ $session->admin?->name ?? 'Instructor' }}</p>
        <h2>{{ $session->title }}</h2>
        <p>{{ $session->description ?: 'Live session in progress.' }}</p>
    </div>

    <a href="{{ route('live-sessions.index') }}" class="ls-leave">Leave Session</a>
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

    function showStatus(text) {
        if (loadingEl) loadingEl.textContent = text;
    }

    function showMessage(text) {
        container.innerHTML = '<p class="ls-msg">' + text + '</p>';
    }

    if (!appId || !token || !channelName) {
        showMessage('Unable to connect to live session');
        return;
    }

    const client = AgoraRTC.createClient({ mode: 'live', codec: 'vp8' });

    // Register ALL event listeners BEFORE joining so no events are missed
    client.on('user-published', async function (user, mediaType) {
        try {
            await client.subscribe(user, mediaType);

            if (mediaType === 'video') {
                container.innerHTML = '';
                const player = document.createElement('div');
                player.id = 'remote-player';
                player.style.cssText = 'width:100%;height:100%;min-height:500px';
                container.appendChild(player);
                user.videoTrack.play('remote-player');
            }
            if (mediaType === 'audio') {
                user.audioTrack.play();
            }
        } catch (e) {
            console.error('Subscribe error:', e);
        }
    });

    client.on('user-unpublished', function (user, mediaType) {
        if (mediaType === 'video') {
            container.innerHTML = '<p class="ls-msg">Host paused the video</p>';
        }
    });

    client.on('user-left', function () {
        showMessage('Host has left the session');
    });

    client.on('connection-state-change', function (curState) {
        if (curState === 'CONNECTED') showStatus('Waiting for host stream...');
        else if (curState === 'DISCONNECTED') showMessage('Disconnected from session');
    });

    async function joinSession() {
        try {
            await client.setClientRole('audience');
            await client.join(appId, channelName, token, uid);
            showStatus('Connected — waiting for host to stream...');
        } catch (err) {
            console.error('Join error:', err);
            showMessage('Unable to connect: ' + (err.message || err.code || 'Unknown error'));
        }
    }

    joinSession();
})();
</script>
@endpush
