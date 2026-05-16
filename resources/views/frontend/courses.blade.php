@extends('layouts.frontend')

@section('title', 'Courses — ' . config('app.name', 'CryptoOnly'))

@push('styles')
<style>
    :root { --gold:#C9A84C; --gold-light:#E8C97A; --gold-dim:#7a6230; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
    .courses-page { padding: 20px 20px 56px; max-width: 1200px; margin: 0 auto; }
    .student-bar {
        display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap;
        gap: 12px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--border);
    }
    .student-bar a, .student-bar button {
        color: var(--gold-light); font-size: .85rem; text-decoration: none;
        background: none; border: none; cursor: pointer; font-family: inherit;
    }
    .student-bar span { color: var(--muted); font-size: .85rem; }
    .hd { text-align: center; margin-bottom: 28px; }
    .tag {
        display: inline-block; font-family: Cinzel, serif; font-size: 9px; letter-spacing: .22em;
        color: var(--gold); border: 1px solid var(--border); padding: 4px 14px; margin-bottom: 10px;
    }
    .hd h1 { font-family: Cinzel, serif; font-size: clamp(1.4rem, 4vw, 2.2rem); color: #fff; }
    .hd h1 em { color: var(--gold); font-style: normal; }
    .subtitle { color: var(--muted); font-size: .9rem; margin-top: 10px; font-style: italic; max-width: 640px; margin-left: auto; margin-right: auto; }
    .toolbar { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin-bottom: 28px; align-items: center; }
    .search-box { flex: 1; min-width: 200px; max-width: 360px; }
    .search-box input {
        width: 100%; background: rgba(255,255,255,.03); border: 1px solid var(--border);
        color: var(--text); padding: 10px 14px; outline: none; font-family: inherit;
    }
    .filter-btn {
        padding: 8px 16px; border: 1px solid var(--border); background: rgba(201,168,76,.05);
        color: var(--text); font-family: Cinzel, serif; font-size: .7rem; letter-spacing: .12em;
        text-transform: uppercase; cursor: pointer; transition: all .25s;
    }
    .filter-btn.active, .filter-btn:hover { border-color: var(--gold); color: var(--gold-light); background: rgba(201,168,76,.12); }
    .flash { padding: 12px 16px; margin-bottom: 20px; border: 1px solid var(--border); background: rgba(201,168,76,.08); color: var(--gold-light); border-radius: 2px; }
    .flash.err { border-color: rgba(192,57,43,.4); color: #e07b73; background: rgba(192,57,43,.1); }
    .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
    .course-card { background: var(--card); border: 1px solid var(--border); overflow: hidden; transition: border-color .3s, transform .3s; }
    .course-card:hover { border-color: rgba(201,168,76,.45); transform: translateY(-3px); }
    .course-img { height: 160px; background: linear-gradient(135deg, var(--gold-dim), #0d0d0d); display: flex; align-items: center; justify-content: center; overflow: hidden; font-size: 3rem; }
    .course-img img { width: 100%; height: 100%; object-fit: cover; }
    .course-body { padding: 20px; }
    .level { font-family: Cinzel, serif; font-size: 7px; letter-spacing: .15em; color: var(--gold); text-transform: uppercase; }
    .title { font-family: Cinzel, serif; font-size: 1rem; color: #fff; margin: 8px 0; line-height: 1.3; }
    .desc { font-size: .8rem; color: var(--muted); margin-bottom: 12px; min-height: 38px; line-height: 1.45; }
    .meta { display: flex; justify-content: space-between; font-size: .75rem; color: var(--muted); padding: 10px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); margin-bottom: 12px; }
    .price { font-size: 1.3rem; color: var(--gold-light); font-weight: 700; margin-bottom: 14px; }
    .btns { display: flex; flex-direction: column; gap: 8px; }
    .btn {
        display: block; text-align: center; padding: 10px; border: 1px solid var(--gold);
        color: var(--gold-light); font-family: Cinzel, serif; font-size: .68rem; letter-spacing: .14em;
        text-transform: uppercase; text-decoration: none; transition: background .25s, color .25s;
    }
    .btn:hover { background: var(--gold); color: #0d0d0d; }
    .btn.secondary { border-color: var(--border); color: var(--text); }
    .btn.secondary:hover { border-color: var(--gold-dim); background: rgba(201,168,76,.08); color: var(--gold-light); }
    .btn.locked { opacity: .6; cursor: not-allowed; pointer-events: none; }
    .empty, .loading { text-align: center; padding: 48px; color: var(--muted); grid-column: 1 / -1; }
</style>
@endpush

@section('content')
<div class="courses-page">
    <div class="student-bar">
        @auth('student')
            <span>Welcome, {{ auth('student')->user()->name }}</span>
            <form method="POST" action="{{ route('student.logout') }}">@csrf<button type="submit">Logout</button></form>
        @else
            <a href="{{ route('student.login') }}">Student login</a>
            <span style="color:var(--border)">|</span>
            <span style="color:var(--muted)">Approved students only</span>
        @endauth
    </div>

    <header class="hd">
        <div class="tag">📚 Paid Courses</div>
        <h1>Master <em>Crypto</em> Trading</h1>
        <p class="subtitle">
            Browse all courses from our academy. Use <strong>Enroll now</strong> to register (same process as Premium Group).
            After admin approval, use <strong>Student login</strong> then <strong>View course</strong> to watch all lesson videos.
        </p>
    </header>

    @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="flash err">{{ session('error') }}</div>@endif

    <div class="toolbar">
        <div class="search-box">
            <input type="search" id="searchInput" placeholder="Search courses..." autocomplete="off">
        </div>
        <button type="button" class="filter-btn active" data-level="">All</button>
        <button type="button" class="filter-btn" data-level="beginner">Beginner</button>
        <button type="button" class="filter-btn" data-level="intermediate">Intermediate</button>
        <button type="button" class="filter-btn" data-level="advanced">Advanced</button>
    </div>

    <div class="grid" id="coursesGrid">
        <div class="loading">Loading courses...</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const grid = document.getElementById('coursesGrid');
    const searchInput = document.getElementById('searchInput');
    const loginUrl = @json(route('student.login'));
    let level = '';
    let debounce;

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            level = btn.dataset.level || '';
            loadCourses();
        });
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(debounce);
        debounce = setTimeout(loadCourses, 300);
    });

    function loadCourses() {
        const params = new URLSearchParams();
        const q = searchInput.value.trim();
        if (q) params.set('q', q);
        if (level) params.set('level', level);

        grid.innerHTML = '<div class="loading">Loading courses...</div>';

        fetch(@json(route('courses.search')) + '?' + params.toString(), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => renderCourses(data.courses || []))
        .catch(() => { grid.innerHTML = '<div class="empty">Could not load courses.</div>'; });
    }

    function renderCourses(courses) {
        if (!courses.length) {
            grid.innerHTML = '<div class="empty"><div style="font-size:2.5rem;margin-bottom:12px">📖</div><h2>No courses found</h2><p>Try another search or filter.</p></div>';
            return;
        }

        grid.innerHTML = courses.map(c => {
            let viewBtn;
            if (c.has_access) {
                viewBtn = `<a href="${c.learn_url}" class="btn">View course →</a>`;
            } else if (c.is_logged_in) {
                viewBtn = `<span class="btn secondary locked">View course (pending approval)</span>`;
            } else {
                viewBtn = `<a href="${loginUrl}?redirect=${encodeURIComponent(c.learn_url)}" class="btn secondary">View course (login)</a>`;
            }

            return `
            <article class="course-card">
                <div class="course-img">${c.thumbnail ? `<img src="${c.thumbnail}" alt="">` : '📚'}</div>
                <div class="course-body">
                    <span class="level">${c.level}</span>
                    <h3 class="title">${escapeHtml(c.title)}</h3>
                    <p class="desc">${escapeHtml(c.description)}</p>
                    <div class="meta"><span>${c.duration}</span><span>${c.videos_count} lessons</span></div>
                    <div class="price">$${c.price}</div>
                    <div class="btns">
                        <a href="${c.enroll_url}" class="btn">Enroll now →</a>
                        ${viewBtn}
                    </div>
                </div>
            </article>`;
        }).join('');
    }

    function escapeHtml(s) {
        const d = document.createElement('div');
        d.textContent = s || '';
        return d.innerHTML;
    }

    loadCourses();
</script>
@endpush
