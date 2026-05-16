<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} — Lessons</title>
    <style>
        :root { --gold:#C9A84C; --gold-light:#E8C97A; --black:#0d0d0d; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--black); color:var(--text); font-family:Georgia,serif; min-height:100vh; }
        .wrap { max-width:1100px; margin:0 auto; padding:24px 20px 48px; }
        .top a { color:var(--gold-light); text-decoration:none; font-size:.85rem; }
        h1 { font-family:Cinzel,serif; color:#fff; margin:16px 0 8px; font-size:1.6rem; }
        .sub { color:var(--muted); margin-bottom:24px; font-style:italic; }
        .layout { display:grid; grid-template-columns:280px 1fr; gap:24px; }
        @media(max-width:800px){ .layout { grid-template-columns:1fr; } }
        .sidebar { background:var(--card); border:1px solid var(--border); padding:16px; }
        .lesson { display:block; padding:10px 12px; border-bottom:1px solid var(--border); color:var(--text); text-decoration:none; font-size:.85rem; cursor:pointer; background:none; border-left:none; border-right:none; border-top:none; width:100%; text-align:left; font-family:inherit; }
        .lesson:hover, .lesson.active { background:rgba(201,168,76,.1); color:var(--gold-light); }
        .player { background:var(--card); border:1px solid var(--border); padding:16px; }
        .player h2 { font-family:Cinzel,serif; font-size:.9rem; color:var(--gold); margin-bottom:12px; letter-spacing:.1em; }
        video { width:100%; max-height:70vh; background:#000; border:1px solid var(--border); }
        .empty { padding:40px; text-align:center; color:var(--muted); }
    </style>
</head>
<body>
    <div class="wrap">
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
                        <button type="button" class="lesson {{ $loop->first ? 'active' : '' }}" data-src="{{ asset('storage/'.$video->video_path) }}" data-title="{{ $video->title }}">
                            {{ $loop->iteration }}. {{ $video->title }}
                        </button>
                    @endforeach
                </aside>
                <main class="player">
                    <h2 id="lessonTitle">{{ $course->videos->first()->title }}</h2>
                    <video id="lessonPlayer" controls playsinline src="{{ asset('storage/'.$course->videos->first()->video_path) }}"></video>
                </main>
            </div>
        @endif
    </div>
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
</body>
</html>
