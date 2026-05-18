@extends('layouts.frontend')

@section('title', 'Courses — ' . config('app.name', 'CryptoOnly'))

@push('styles')
<style>
    :root { --gold:#C9A84C; --gold-light:#E8C97A; --gold-dim:#7a6230; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
    .courses-page { padding: 20px 20px 56px; max-width: 1200px; margin: 0 auto; }

    /* ── Auth gate ── */
    .auth-gate { display: flex; justify-content: center; align-items: flex-start; padding: 40px 0 80px; }
    .auth-box { background: var(--card); border: 1px solid var(--border); padding: 44px 40px; width: 100%; max-width: 440px; }
    .auth-box-tag { font-family: Cinzel, serif; font-size: 9px; letter-spacing: .22em; color: var(--gold); border: 1px solid var(--border); padding: 4px 14px; display: inline-block; margin-bottom: 18px; }
    .auth-box h2 { font-family: Cinzel, serif; color: var(--gold-light); margin-bottom: 8px; font-size: 1.4rem; }
    .auth-box p { color: var(--muted); font-size: .85rem; margin-bottom: 24px; line-height: 1.55; }
    .auth-box label { display: block; font-size: .75rem; color: var(--muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .1em; }
    .auth-box input[type=email],
    .auth-box input[type=password] { width: 100%; padding: 10px 12px; margin-bottom: 16px; background: rgba(255,255,255,.03); border: 1px solid var(--border); color: var(--text); font-family: inherit; outline: none; transition: border-color .2s; }
    .auth-box input:focus { border-color: var(--gold); }
    .auth-box .remember { display: flex; align-items: center; gap: 8px; text-transform: none; letter-spacing: 0; font-size: .85rem; color: var(--muted); margin-bottom: 18px; }
    .auth-box .remember input { width: auto; margin: 0; }
    .auth-submit { width: 100%; padding: 12px; background: transparent; border: 1px solid var(--gold); color: var(--gold-light); font-family: Cinzel, serif; font-size: .78rem; letter-spacing: .12em; text-transform: uppercase; cursor: pointer; transition: background .25s, color .25s; }
    .auth-submit:hover { background: var(--gold); color: #0d0d0d; }
    .auth-err { color: #e07b73; font-size: .85rem; margin-bottom: 12px; }
    .auth-link { margin-top: 20px; color: var(--muted); font-size: .85rem; }
    .auth-link a { color: var(--gold); text-decoration: none; }
    .auth-link a:hover { text-decoration: underline; }

    /* ── Student bar ── */
    .student-bar {
        display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap;
        gap: 12px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--border);
    }
    .student-bar a, .student-bar button {
        color: var(--gold-light); font-size: .85rem; text-decoration: none;
        background: none; border: none; cursor: pointer; font-family: inherit;
    }
    .student-bar span { color: var(--muted); font-size: .85rem; }

    /* ── Page header ── */
    .hd { text-align: center; margin-bottom: 28px; }
    .tag { display: inline-block; font-family: Cinzel, serif; font-size: 9px; letter-spacing: .22em; color: var(--gold); border: 1px solid var(--border); padding: 4px 14px; margin-bottom: 10px; }
    .hd h1 { font-family: Cinzel, serif; font-size: clamp(1.4rem, 4vw, 2.2rem); color: #fff; }
    .hd h1 em { color: var(--gold); font-style: normal; }
    .subtitle { color: var(--muted); font-size: .9rem; margin-top: 10px; font-style: italic; max-width: 640px; margin-left: auto; margin-right: auto; }

    /* ── Toolbar ── */
    .toolbar { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin-bottom: 28px; align-items: center; }
    .search-box { flex: 1; min-width: 200px; max-width: 360px; }
    .search-box input { width: 100%; background: rgba(255,255,255,.03); border: 1px solid var(--border); color: var(--text); padding: 10px 14px; outline: none; font-family: inherit; }
    .filter-btn { padding: 8px 16px; border: 1px solid var(--border); background: rgba(201,168,76,.05); color: var(--text); font-family: Cinzel, serif; font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; cursor: pointer; transition: all .25s; }
    .filter-btn.active, .filter-btn:hover { border-color: var(--gold); color: var(--gold-light); background: rgba(201,168,76,.12); }

    /* ── Flash ── */
    .flash { padding: 12px 16px; margin-bottom: 20px; border: 1px solid var(--border); background: rgba(201,168,76,.08); color: var(--gold-light); border-radius: 2px; }
    .flash.err { border-color: rgba(192,57,43,.4); color: #e07b73; background: rgba(192,57,43,.1); }

    /* ── Grid & cards ── */
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
    .btn { display: block; text-align: center; padding: 10px; border: 1px solid var(--gold); color: var(--gold-light); font-family: Cinzel, serif; font-size: .68rem; letter-spacing: .14em; text-transform: uppercase; text-decoration: none; transition: background .25s, color .25s; }
    .btn:hover { background: var(--gold); color: #0d0d0d; }
    .btn.secondary { border-color: var(--border); color: var(--text); }
    .btn.secondary:hover { border-color: var(--gold-dim); background: rgba(201,168,76,.08); color: var(--gold-light); }
    .btn.locked { opacity: .6; cursor: not-allowed; pointer-events: none; }
    .empty, .loading { text-align: center; padding: 48px; color: var(--muted); grid-column: 1 / -1; }
</style>
@endpush

@section('content')
<div class="courses-page">

@php $isBrowse = request()->boolean('browse'); @endphp

@auth('student')
    {{-- ── Logged-in: show courses without enroll button ── --}}
    <div class="student-bar">
        <span>Welcome, {{ auth('student')->user()->name }}</span>
        <form method="POST" action="{{ route('student.logout') }}">@csrf<button type="submit">Logout</button></form>
    </div>

    <header class="hd">
        <div class="tag">📚 Paid Courses</div>
        <h1>Master <em>Crypto</em> Trading</h1>
        <p class="subtitle">Browse all available courses. Click <strong>View course</strong> to watch lesson videos for courses you're approved for.</p>
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

@elseif($isBrowse)
    {{-- ── Public browse mode: see courses & enroll, no login needed ── --}}
    <div style="background:rgba(201,168,76,.07);border:1px solid var(--border);padding:12px 18px;margin-bottom:22px;font-size:.84rem;color:var(--muted);text-align:center">
        Already enrolled? <a href="{{ url('/courses') }}" style="color:var(--gold);text-decoration:none">Log in to view your courses →</a>
    </div>

    <header class="hd">
        <div class="tag">📚 Paid Courses</div>
        <h1>Master <em>Crypto</em> Trading</h1>
        <p class="subtitle">Browse all available courses and enroll in the one that's right for you.</p>
    </header>

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

@else
    {{-- ── Guest: show login form ── --}}
    <div class="auth-gate">
        <div class="auth-box">
            <div class="auth-box-tag">📚 Paid Courses</div>
            <h2>Student Login</h2>
            <p>Log in to browse and access all courses. Use the email and password you set when you enrolled.</p>

            @if($errors->any())
                <div class="auth-err">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('student.login.submit') }}">
                @csrf
                <input type="hidden" name="redirect" value="{{ url('/courses') }}">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                <label>Password</label>
                <input type="password" name="password" required autocomplete="current-password">
                <label class="remember">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <button type="submit" class="auth-submit">Log In</button>
            </form>

            <div class="auth-links" style="margin-top:20px;display:flex;flex-direction:column;gap:8px">
                @if(isset($firstCourse))
                    <p class="auth-link">Not enrolled yet? <a href="{{ route('courses.enroll.show', $firstCourse) }}">Enroll now →</a></p>
                @else
                    <p class="auth-link">No courses available yet. Check back soon.</p>
                @endif
            </div>
        </div>
    </div>
@endauth

</div>
@endsection

@if(request()->boolean('browse') && !auth('student')->check())
@push('scripts')
<script>
    const grid = document.getElementById('coursesGrid');
    const searchInput = document.getElementById('searchInput');
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

        grid.innerHTML = courses.map(c => `
            <article class="course-card">
                <div class="course-img">${c.thumbnail ? `<img src="${c.thumbnail}" alt="">` : '📚'}</div>
                <div class="course-body">
                    <span class="level">${c.level}</span>
                    <h3 class="title">${escapeHtml(c.title)}</h3>
                    <p class="desc">${escapeHtml(c.description)}</p>
                    <div class="meta"><span>${c.duration}</span><span>${c.videos_count} lessons</span></div>
                    <div class="price">$${c.price}</div>
                    <div class="btns">
                        <a href="${c.enroll_url}" class="btn">Enroll Now →</a>
                    </div>
                </div>
            </article>`
        ).join('');
    }

    function escapeHtml(s) {
        const d = document.createElement('div');
        d.textContent = s || '';
        return d.innerHTML;
    }

    loadCourses();
</script>
@endpush
@endif

@auth('student')
@push('scripts')
<script>
    const grid = document.getElementById('coursesGrid');
    const searchInput = document.getElementById('searchInput');
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
            } else {
                viewBtn = `<span class="btn secondary locked">Pending approval</span>`;
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
@endauth
