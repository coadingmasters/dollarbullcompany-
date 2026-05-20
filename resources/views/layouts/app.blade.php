<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog') — CryptoOnly</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: #7C3AED;
            --accent-light: #8B5CF6;
            --accent-bg: #f5f3ff;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --bg: #fafafa;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; color: var(--text); background: var(--bg); }

        /* ── Header ── */
        .site-header {
            background: #fff; border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 100;
        }
        .header-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 24px;
            height: 64px; display: flex; align-items: center; justify-content: space-between;
        }
        .site-logo {
            display: flex; align-items: center; gap: 9px; text-decoration: none;
        }
        .logo-dot {
            width: 32px; height: 32px; background: var(--accent); border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .8rem;
        }
        .logo-name { font-weight: 700; font-size: 1rem; color: var(--text); }
        .logo-name span { color: var(--accent); }

        .desktop-nav { display: flex; align-items: center; gap: 4px; }
        .nav-a {
            padding: 6px 13px; border-radius: 7px; text-decoration: none;
            font-size: .87rem; font-weight: 500; color: var(--muted); transition: all .18s;
        }
        .nav-a:hover { color: var(--accent); background: var(--accent-bg); }
        .nav-a.active { color: var(--accent); background: var(--accent-bg); font-weight: 600; }

        .hamburger-btn {
            display: none; background: none; border: 1px solid var(--border);
            border-radius: 7px; padding: 7px; cursor: pointer; color: var(--muted);
        }
        .hamburger-btn svg { width: 18px; height: 18px; display: block; }

        /* Mobile nav */
        .mobile-nav {
            max-height: 0; overflow: hidden;
            transition: max-height .35s cubic-bezier(.4,0,.2,1);
            background: #fff; border-top: 1px solid var(--border);
        }
        .mobile-nav.open { max-height: 280px; }
        .mobile-nav-inner { padding: 10px 16px 16px; display: flex; flex-direction: column; gap: 4px; }
        .mobile-nav .nav-a { display: block; padding: 10px 14px; }

        /* ── Main content ── */
        .site-main { min-height: calc(100vh - 64px - 80px); }

        /* ── Footer ── */
        .site-footer {
            background: #fff; border-top: 1px solid var(--border);
            padding: 28px 24px;
        }
        .footer-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
        }
        .footer-copy { font-size: .82rem; color: var(--muted); }
        .footer-links { display: flex; gap: 20px; }
        .footer-links a { font-size: .82rem; color: var(--muted); text-decoration: none; transition: color .18s; }
        .footer-links a:hover { color: var(--accent); }

        @media (max-width: 680px) {
            .desktop-nav { display: none; }
            .hamburger-btn { display: flex; }
            .footer-inner { flex-direction: column; align-items: flex-start; }
        }
    </style>
    @stack('styles')
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <a href="{{ url('/') }}" class="site-logo">
            <div class="logo-dot">C</div>
            <span class="logo-name">Crypto<span>Only</span></span>
        </a>

        <nav class="desktop-nav">
            <a href="{{ url('/') }}"        class="nav-a {{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ route('blog.index') }}" class="nav-a {{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
            <a href="{{ route('about') }}"  class="nav-a {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('contact') }}" class="nav-a {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
        </nav>

        <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleMobileNav()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </div>

    <div class="mobile-nav" id="mobileNav">
        <div class="mobile-nav-inner">
            <a href="{{ url('/') }}"           class="nav-a {{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ route('blog.index') }}" class="nav-a {{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
            <a href="{{ route('about') }}"      class="nav-a {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('contact') }}"    class="nav-a {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
        </div>
    </div>
</header>

<main class="site-main">
    @yield('content')
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <span class="footer-copy">© {{ date('Y') }} CryptoOnly. All rights reserved.</span>
        <div class="footer-links">
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a href="{{ route('blog.index') }}">Blog</a>
        </div>
    </div>
</footer>

<script>
function toggleMobileNav() {
    document.getElementById('mobileNav').classList.toggle('open');
}
</script>
@stack('scripts')
</body>
</html>
