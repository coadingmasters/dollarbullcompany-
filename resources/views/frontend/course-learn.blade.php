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
    video { width: 100%; max-height: 70vh; background: #000; border: 1px solid var(--border); }
    .empty { padding: 40px; text-align: center; color: var(--muted); }
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
                <video id="lessonPlayer" controls playsinline src="{{ $course->videos->first()->video_url }}"></video>
            </main>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.lesson').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.lesson').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('lessonTitle').textContent = btn.dataset.title;
            const v = document.getElementById('lessonPlayer');
            v.src = btn.dataset.src;
            v.load();
            v.play();
        });
    });
</script>
@endpush
