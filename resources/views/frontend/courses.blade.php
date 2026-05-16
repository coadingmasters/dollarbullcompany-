<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Courses</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Pro:wght@0,400&display=swap" rel="stylesheet">
    <style>
        :root { --gold:#C9A84C; --gold-light:#E8C97A; --gold-dim:#7a6230; --black:#0d0d0d; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--black); color:var(--text); font-family:Georgia,serif; font-size:14px; min-height:100vh; }
        .wrap { padding:28px 20px 48px; max-width:1200px; margin:0 auto; }
        .top-bar { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:24px; }
        .top-bar a { color:var(--gold-light); text-decoration:none; font-size:.85rem; }
        .hd { text-align:center; margin-bottom:28px; }
        .tag { display:inline-block; font-family:Cinzel,serif; font-size:9px; letter-spacing:.22em; color:var(--gold); border:1px solid var(--border); padding:4px 14px; margin-bottom:10px; }
        .hd h1 { font-family:Cinzel,serif; font-size:clamp(1.4rem,4vw,2.2rem); color:#fff; }
        .hd h1 em { color:var(--gold); font-style:normal; }
        .subtitle { color:var(--muted); font-size:.9rem; margin-top:10px; font-style:italic; }
        .toolbar { display:flex; flex-wrap:wrap; gap:12px; justify-content:center; margin-bottom:28px; align-items:center; }
        .search-box { flex:1; min-width:200px; max-width:360px; }
        .search-box input { width:100%; background:rgba(255,255,255,.03); border:1px solid var(--border); color:var(--text); padding:10px 14px; outline:none; }
        .filter-btn { padding:8px 16px; border:1px solid var(--border); background:rgba(201,168,76,.05); color:var(--text); font-family:Cinzel,serif; font-size:.7rem; letter-spacing:.12em; text-transform:uppercase; cursor:pointer; }
        .filter-btn.active, .filter-btn:hover { border-color:var(--gold); color:var(--gold-light); background:rgba(201,168,76,.12); }
        .flash { padding:12px 16px; margin-bottom:20px; border:1px solid var(--border); background:rgba(201,168,76,.08); color:var(--gold-light); }
        .flash.err { border-color:rgba(192,57,43,.4); color:#e07b73; background:rgba(192,57,43,.1); }
        .grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:24px; }
        .course-card { background:var(--card); border:1px solid var(--border); overflow:hidden; transition:border-color .3s,transform .3s; }
        .course-card:hover { border-color:rgba(201,168,76,.45); transform:translateY(-3px); }
        .course-img { height:160px; background:linear-gradient(135deg,var(--gold-dim),var(--black)); display:flex; align-items:center; justify-content:center; overflow:hidden; }
        .course-img img { width:100%; height:100%; object-fit:cover; }
        .course-body { padding:20px; }
        .level { font-family:Cinzel,serif; font-size:7px; letter-spacing:.15em; color:var(--gold); text-transform:uppercase; }
        .title { font-family:Cinzel,serif; font-size:1rem; color:#fff; margin:8px 0; line-height:1.3; }
        .desc { font-size:.8rem; color:var(--muted); margin-bottom:12px; min-height:38px; }
        .meta { display:flex; justify-content:space-between; font-size:.75rem; color:var(--muted); padding:10px 0; border-top:1px solid var(--border); border-bottom:1px solid var(--border); margin-bottom:12px; }
        .price { font-size:1.3rem; color:var(--gold-light); font-weight:700; margin-bottom:14px; }
        .btns { display:flex; flex-direction:column; gap:8px; }
        .btn { display:block; text-align:center; padding:10px; border:1px solid var(--gold); color:var(--gold-light); font-family:Cinzel,serif; font-size:.68rem; letter-spacing:.14em; text-transform:uppercase; text-decoration:none; transition:background .25s,color .25s; }
        .btn:hover { background:var(--gold); color:var(--black); }
        .btn.secondary { border-color:var(--border); color:var(--text); }
        .btn.secondary:hover { border-color:var(--gold-dim); background:rgba(201,168,76,.08); color:var(--gold-light); }
        .btn.locked { opacity:.6; cursor:not-allowed; pointer-events:none; }
        .empty { text-align:center; padding:48px; color:var(--muted); grid-column:1/-1; }
        .loading { text-align:center; padding:40px; color:var(--muted); grid-column:1/-1; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="top-bar">
            <a href="{{ url('/') }}">← Home</a>
            <div>
                @auth('student')
                    <span style="color:var(--muted);margin-right:12px">Hi, {{ auth('student')->user()->name }}</span>
                    <form method="POST" action="{{ route('student.logout') }}" style="display:inline">@csrf<button type="submit" style="background:none;border:none;color:var(--gold);cursor:pointer;font-family:inherit">Logout</button></form>
                @else
                    <a href="{{ route('student.login') }}">Student login</a>
                @endauth
            </div>
        </div>

        <header class="hd">
            <div class="tag">📚 Learning Hub</div>
            <h1>Master <em>Crypto</em> Trading</h1>
            <p class="subtitle">Structured courses from beginner to advanced. Enroll, get verified, then access all lesson videos.</p>
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
            const q = searchInput.value.trim();
            const params = new URLSearchParams();
            if (q) params.set('q', q);
            if (level) params.set('level', level);

            grid.innerHTML = '<div class="loading">Loading courses...</div>';

            fetch('{{ route('courses.search') }}?' + params.toString(), {
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
                const img = c.thumbnail
                    ? `<img src="${c.thumbnail}" alt="">`
                    : '📚';
                let viewBtn = '';
                if (c.has_access) {
                    viewBtn = `<a href="${c.learn_url}" class="btn">View course →</a>`;
                } else if (c.is_logged_in) {
                    viewBtn = `<span class="btn secondary locked">View course (await approval)</span>`;
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
</body>
</html>
