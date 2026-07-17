@extends('layouts.frontend')

@section('title', $course->title . ' — Lessons')

@push('styles')
<style>
    :root { --gold:#C9A84C; --gold-light:#E8C97A; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
    .learn-page { max-width: 1100px; margin: 0 auto; padding: 20px 20px 56px; }
    .top a { color: var(--gold-light); text-decoration: none; font-size: .85rem; }
    h1 { font-family: Cinzel, serif; color: #fff; margin: 16px 0 8px; font-size: 1.6rem; }
    .sub { color: var(--muted); margin-bottom: 24px; font-style: italic; }
    .layout { display: grid; grid-template-columns: 280px 1fr; gap: 24px; }
    @media(max-width:800px) { .layout { grid-template-columns: 1fr; } }
    .sidebar { background: var(--card); border: 1px solid var(--border); padding: 16px; }
    .lesson {
        display: block; padding: 10px 12px; border-bottom: 1px solid var(--border);
        color: var(--text); font-size: .85rem; cursor: pointer; background: none;
        border-left: none; border-right: none; border-top: none; width: 100%;
        text-align: left; font-family: inherit;
    }
    .lesson:hover, .lesson.active { background: rgba(201,168,76,.1); color: var(--gold-light); }
    .player { background: var(--card); border: 1px solid var(--border); padding: 16px; }
    .player h2 { font-family: Cinzel, serif; font-size: .9rem; color: var(--gold); margin-bottom: 12px; }
    video { width: 100%; max-height: 70vh; background: #000; border: 1px solid var(--border); display: block; }
    .empty { padding: 40px; text-align: center; color: var(--muted); }

    .video-shell { position: relative; overflow: hidden; }
    .video-shell video {
        -webkit-user-select: none; user-select: none; -webkit-touch-callout: none;
    }
    /* Traceable watermark — repositions so it cannot be cropped out of a recording */
    .wm {
        position: absolute; z-index: 5; pointer-events: none;
        font-family: Georgia, serif; font-size: .72rem; letter-spacing: .04em;
        color: rgba(255,255,255,.42); text-shadow: 0 1px 4px rgba(0,0,0,.95);
        white-space: nowrap; user-select: none;
        transition: top 1.4s ease, left 1.4s ease;
    }
    .video-shell.is-hidden video { filter: blur(30px); }
    .guard {
        position: absolute; inset: 0; z-index: 9; display: none;
        align-items: center; justify-content: center; text-align: center;
        background: rgba(0,0,0,.94); padding: 24px;
    }
    .video-shell.is-hidden .guard { display: flex; }
    .guard p { color: var(--gold-light); font-family: Cinzel, serif; font-size: .8rem; letter-spacing: .12em; line-height: 1.9; }
    .guard small { color: var(--muted); font-style: italic; letter-spacing: 0; font-family: Georgia, serif; }
    .notice-bar {
        margin-top: 12px; padding: 10px 14px; font-size: .74rem; line-height: 1.6;
        background: rgba(192,57,43,.1); border: 1px solid rgba(192,57,43,.28);
        border-left: 3px solid #C0392B; color: #e07b73;
    }
</style>
@endpush

@section('content')
<div class="learn-page">
    <div class="top"><a href="{{ route('courses.frontend') }}">← All courses</a></div>
    <h1>{{ $course->title }}</h1>
    <p class="sub">Welcome, {{ auth('student')->user()->name }}. Your enrollment is verified — enjoy your lessons.</p>

    @if($course->videos->isEmpty())
        <div class="empty">No videos uploaded for this course yet. Check back soon.</div>
    @else
        <div class="layout">
            <aside class="sidebar">
                <p style="font-family:Cinzel,serif;font-size:.65rem;letter-spacing:.15em;color:var(--gold);margin-bottom:12px;text-transform:uppercase">Lessons</p>
                @foreach($course->videos as $video)
                    <button type="button" class="lesson {{ $loop->first ? 'active' : '' }}" data-src="{{ $video->video_url }}" data-title="{{ $video->title }}">
                        {{ $loop->iteration }}. {{ $video->title }}
                    </button>
                @endforeach
            </aside>
            <main class="player">
                <h2 id="lessonTitle">{{ $course->videos->first()->title }}</h2>
                <div class="video-shell" id="videoShell">
                    <video id="lessonPlayer" controls playsinline preload="metadata"
                           controlsList="nodownload noremoteplayback noplaybackrate"
                           disablePictureInPicture disableRemotePlayback
                           oncontextmenu="return false"
                           src="{{ $course->videos->first()->video_url }}"
                           onerror="document.getElementById('videoError').style.display='block'">
                    </video>
                    <div class="wm" id="wm" aria-hidden="true"></div>
                    <div class="guard">
                        <p>
                            ⚠ Playback Paused<br>
                            <small>This lesson resumes when this window is active and focused.</small>
                        </p>
                    </div>
                </div>
                <div class="notice-bar">
                    🔒 This lesson is licensed to <strong>{{ auth('student')->user()->email }}</strong> and is watermarked.
                    Recording or sharing this content will terminate your enrollment and may lead to legal action.
                </div>
                <div id="videoError" style="display:none;margin-top:10px;padding:12px 16px;
                     background:rgba(192,57,43,.12);border:1px solid rgba(192,57,43,.35);
                     color:#e07b73;font-size:.85rem;line-height:1.5">
                    ⚠ This video could not be loaded. Please try refreshing the page.
                </div>
            </main>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const player = document.getElementById('lessonPlayer');
    const shell  = document.getElementById('videoShell');
    const wm     = document.getElementById('wm');

    const VIEWER_NAME  = @json(auth('student')->user()->name);
    const VIEWER_EMAIL = @json(auth('student')->user()->email);

    // Ensure full volume on load — browser may default to 0 on some configs
    player.volume = 1;
    player.muted  = false;

    /* ---------- Traceable watermark ---------- */

    function stampWatermark() {
        wm.textContent = VIEWER_NAME + ' · ' + VIEWER_EMAIL + ' · ' + new Date().toLocaleString();
        wm.style.top  = (6 + Math.random() * 74) + '%';
        wm.style.left = (4 + Math.random() * 50) + '%';
    }

    // Re-attach and un-hide the watermark if anyone strips it via dev tools
    function enforceWatermark() {
        if (!shell.contains(wm)) {
            shell.appendChild(wm);
            player.pause();
        }
        const s = getComputedStyle(wm);
        if (s.display === 'none' || s.visibility === 'hidden' || parseFloat(s.opacity) < 0.15) {
            wm.style.setProperty('display', 'block', 'important');
            wm.style.setProperty('visibility', 'visible', 'important');
            wm.style.setProperty('opacity', '1', 'important');
            player.pause();
        }
    }

    stampWatermark();
    setInterval(stampWatermark, 4000);
    setInterval(enforceWatermark, 1000);
    new MutationObserver(enforceWatermark).observe(shell, {
        childList: true, subtree: true, attributes: true, attributeFilter: ['style', 'class']
    });

    /* ---------- Playback guards ---------- */

    function conceal() {
        shell.classList.add('is-hidden');
        player.pause();
    }

    function reveal() {
        shell.classList.remove('is-hidden');
    }

    // Screen sharing and most capture tools need the tab active — pause when it is not
    document.addEventListener('visibilitychange', () => document.hidden ? conceal() : reveal());
    window.addEventListener('blur', conceal);
    window.addEventListener('focus', reveal);

    // Rough dev-tools probe: a docked panel shrinks the viewport away from the window
    setInterval(() => {
        const threshold = 160;
        const docked = window.outerWidth - window.innerWidth > threshold ||
                       window.outerHeight - window.innerHeight > threshold;
        if (docked) {
            conceal();
        } else if (document.hasFocus() && !document.hidden) {
            reveal();
        }
    }, 1000);

    document.addEventListener('keydown', e => {
        const k = (e.key || '').toLowerCase();
        if (k === 'f12' ||
            (e.ctrlKey && e.shiftKey && ['i', 'j', 'c'].includes(k)) ||
            (e.ctrlKey && ['u', 's'].includes(k))) {
            e.preventDefault();
            return;
        }
        if (k === 'printscreen') {
            if (navigator.clipboard) navigator.clipboard.writeText('').catch(() => {});
            conceal();
        }
    });

    shell.addEventListener('contextmenu', e => e.preventDefault());
    player.addEventListener('dragstart', e => e.preventDefault());

    /* ---------- Lesson switching ---------- */

    document.querySelectorAll('.lesson').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.lesson').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('lessonTitle').textContent = btn.dataset.title;
            document.getElementById('videoError').style.display = 'none';

            player.pause();
            player.src    = btn.dataset.src;
            player.volume = 1;     // restore volume each time
            player.muted  = false; // never muted
            player.load();
            stampWatermark();
            player.play().catch(() => {
                // Autoplay blocked — user can click the play button manually, sound will work
            });
        });
    });
</script>
@endpush
