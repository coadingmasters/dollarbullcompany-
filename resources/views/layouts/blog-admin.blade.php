<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Blog Admin') — Dollar Bull University</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1e1e2e;
            --sidebar-border: rgba(255,255,255,.06);
            --sidebar-hover: rgba(255,255,255,.05);
            --accent: #7C3AED;
            --accent-light: #8B5CF6;
            --accent-dim: rgba(124,58,237,.14);
            --bg: #f4f6fb;
            --white: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --sidebar-w: 256px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w); background: var(--sidebar-bg);
            height: 100vh; position: fixed; top: 0; left: 0; z-index: 100;
            display: flex; flex-direction: column; transition: transform .3s ease;
            overflow-y: auto; overflow-x: hidden;
        }
        .sb-logo {
            padding: 22px 20px; border-bottom: 1px solid var(--sidebar-border);
            display: flex; align-items: center; gap: 11px; flex-shrink: 0;
        }
        .sb-logo-icon {
            width: 36px; height: 36px; background: var(--accent); border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .88rem; flex-shrink: 0;
        }
        .sb-logo-name { color: #fff; font-weight: 700; font-size: .92rem; letter-spacing: -.01em; }
        .sb-logo-sub  { color: rgba(255,255,255,.35); font-size: .64rem; display: block; margin-top: 1px; }

        .sb-nav { padding: 16px 10px; flex: 1; }
        .sb-section {
            font-size: .58rem; font-weight: 600; letter-spacing: .13em; text-transform: uppercase;
            color: rgba(255,255,255,.28); padding: 0 10px; margin: 20px 0 6px;
        }
        .sb-section:first-child { margin-top: 0; }
        .sb-link {
            display: flex; align-items: center; gap: 9px; padding: 9px 10px;
            border-radius: 7px; color: rgba(255,255,255,.55); text-decoration: none;
            font-size: .83rem; font-weight: 500; transition: all .18s;
            margin-bottom: 2px; border-left: 2px solid transparent;
        }
        .sb-link svg { width: 16px; height: 16px; flex-shrink: 0; }
        .sb-link:hover { background: var(--sidebar-hover); color: rgba(255,255,255,.85); }
        .sb-link.active {
            background: var(--accent-dim); color: #c4b5fd;
            border-left-color: var(--accent);
        }

        .sb-footer {
            padding: 14px 20px; border-top: 1px solid var(--sidebar-border); flex-shrink: 0;
            display: flex; align-items: center; gap: 10px;
        }
        .sb-avatar {
            width: 32px; height: 32px; background: var(--accent); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: .7rem; font-weight: 700; flex-shrink: 0;
        }
        .sb-uname { color: rgba(255,255,255,.75); font-size: .8rem; font-weight: 500; }
        .sb-urole { color: rgba(255,255,255,.3); font-size: .65rem; }

        /* ── Main wrap ── */
        .main-wrap { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        /* ── Top bar ── */
        .topbar {
            background: var(--white); border-bottom: 1px solid var(--border);
            height: 60px; padding: 0 24px; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 50;
        }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .hamburger {
            display: none; background: none; border: 1px solid var(--border);
            border-radius: 7px; padding: 6px; cursor: pointer; color: var(--muted);
        }
        .hamburger svg { width: 18px; height: 18px; display: block; }
        .topbar-title { font-size: .97rem; font-weight: 600; color: var(--text); }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .topbar-user { font-size: .82rem; color: var(--muted); }
        .topbar-avatar {
            width: 34px; height: 34px; background: var(--accent); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: .7rem; font-weight: 700;
        }

        /* ── Content ── */
        .content { padding: 28px 24px; flex: 1; }

        /* ── Overlay ── */
        .sb-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.45); z-index: 99;
        }
        .sb-overlay.show { display: block; }

        /* ── Flash messages ── */
        .flash-zone {
            position: fixed; top: 68px; right: 18px; z-index: 999;
            display: flex; flex-direction: column; gap: 8px; width: 320px;
        }
        .flash {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 13px 14px; border-radius: 10px; font-size: .83rem;
            font-weight: 500; box-shadow: 0 4px 24px rgba(0,0,0,.1);
            border-left: 4px solid; animation: fIn .3s ease;
        }
        @keyframes fIn  { from { opacity:0; transform: translateX(16px); } to { opacity:1; transform: translateX(0); } }
        @keyframes fOut { from { opacity:1; transform: translateX(0); }    to { opacity:0; transform: translateX(16px); } }
        .flash.success { background: #f0fdf4; border-color: #22c55e; color: #15803d; }
        .flash.error   { background: #fef2f2; border-color: #ef4444; color: #b91c1c; }
        .flash svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }
        .flash-x { margin-left: auto; background: none; border: none; cursor: pointer; opacity: .5; font-size: 1rem; line-height: 1; padding: 0 2px; }
        .flash-x:hover { opacity: .85; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { margin-left: 0; }
            .hamburger { display: flex; }
            .content { padding: 20px 16px; }
            .topbar { padding: 0 16px; }
            .topbar-user { display: none; }
            .flash-zone { width: calc(100vw - 32px); right: 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="sb-logo">
        <div class="sb-logo-icon">B</div>
        <div>
            <div class="sb-logo-name">Blog Studio</div>
            <span class="sb-logo-sub">Dollar Bull University</span>
        </div>
    </div>

    <nav class="sb-nav">
        <div class="sb-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>

        <div class="sb-section">Blog</div>
        <a href="{{ route('admin.blogs.index') }}" class="sb-link {{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            All Posts
        </a>
        <a href="{{ route('admin.blogs.create') }}" class="sb-link {{ request()->routeIs('admin.blogs.create') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Post
        </a>
        <a href="{{ route('blog.index') }}" target="_blank" class="sb-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            View Blog
        </a>
    </nav>

    <div class="sb-footer">
        <div class="sb-avatar">{{ strtoupper(substr(auth('admin')->user()?->name ?? 'A', 0, 1)) }}</div>
        <div>
            <div class="sb-uname">{{ auth('admin')->user()?->name ?? 'Admin' }}</div>
            <div class="sb-urole">Super Admin</div>
        </div>
    </div>
</aside>

<div class="sb-overlay" id="sbOverlay" onclick="sbClose()"></div>

<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-left">
            <button class="hamburger" onclick="sbToggle()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <span class="topbar-title">@yield('page-title', 'Blog Admin')</span>
        </div>
        <div class="topbar-right">
            <span class="topbar-user">{{ auth('admin')->user()?->name ?? 'Admin' }}</span>
            <div class="topbar-avatar">{{ strtoupper(substr(auth('admin')->user()?->name ?? 'A', 0, 1)) }}</div>
        </div>
    </header>

    <main class="content">
        @yield('content')
    </main>
</div>

{{-- Flash messages --}}
<div class="flash-zone" id="flashZone">
    @if(session('success'))
    <div class="flash success" id="fs">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
        <button class="flash-x" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif
    @if(session('error'))
    <div class="flash error" id="fe">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ session('error') }}</span>
        <button class="flash-x" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif
</div>

<script>
function sbToggle() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sbOverlay').classList.toggle('show');
}
function sbClose() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sbOverlay').classList.remove('show');
}
document.addEventListener('DOMContentLoaded', function () {
    ['fs','fe'].forEach(function(id) {
        var el = document.getElementById(id);
        if (!el) return;
        setTimeout(function() {
            el.style.animation = 'fOut .3s ease forwards';
            setTimeout(function() { el && el.remove(); }, 320);
        }, 3500);
    });
});
</script>
@stack('scripts')
</body>
</html>
