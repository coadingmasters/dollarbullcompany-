<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&display=swap" rel="stylesheet">
<style>
:root {
    --gold-light:   #F5C842;
    --gold:         #D4A017;
    --gold-dark:    #A07810;
    --gold-muted:   rgba(212, 160, 23, 0.18);
    --gold-glow:    rgba(212, 160, 23, 0.45);
    --black:        #060606;
    --black-card:   #0E0E0E;
    --black-border: #1A1A1A;
    --white-dim:    rgba(255,255,255,0.75);
    --header-h:     72px;
    --ease-out:     cubic-bezier(0.16, 1, 0.3, 1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--black); }

.crypto-header {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 9999;
    background: rgba(6, 6, 6, 0.92);
    backdrop-filter: blur(18px) saturate(160%);
    -webkit-backdrop-filter: blur(18px) saturate(160%);
    border-bottom: 1px solid var(--black-border);
    box-shadow: 0 0 40px rgba(0,0,0,0.6);
    transition: background 0.3s ease, box-shadow 0.3s ease;
}
.crypto-header.scrolled {
    background: rgba(6,6,6,0.98);
    box-shadow: 0 4px 60px rgba(0,0,0,0.85), 0 0 20px var(--gold-muted);
}
.header-topline {
    height: 2px;
    background: linear-gradient(90deg,
        transparent 0%,
        var(--gold-dark) 20%,
        var(--gold-light) 50%,
        var(--gold-dark) 80%,
        transparent 100%
    );
    background-size: 200% 100%;
    animation: shimmer 3s linear infinite;
}
@keyframes shimmer {
    0%   { background-position: -200% 0; }
    100% { background-position:  200% 0; }
}
.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}
.header-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: var(--header-h);
    gap: 16px;
    position: relative;
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    flex-shrink: 0;
}
.logo-icon {
    display: flex;
    align-items: center;
    filter: drop-shadow(0 0 8px var(--gold-glow));
    animation: pulse-icon 3s ease-in-out infinite;
    transition: transform 0.4s var(--ease-out);
}
@keyframes pulse-icon {
    0%, 100% { filter: drop-shadow(0 0 6px var(--gold-glow)); }
    50%       { filter: drop-shadow(0 0 16px var(--gold-light)); }
}
.logo:hover .logo-icon { transform: rotate(30deg) scale(1.1); }
.logo-text {
    font-family: 'Cinzel', 'Times New Roman', serif;
    font-size: 1.35rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    line-height: 1;
}
.logo-crypto { color: #ffffff; }
.logo-only {
    background: linear-gradient(135deg, var(--gold-light), var(--gold), var(--gold-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.nav-links {
    display: flex;
    align-items: center;
    gap: 8px;
    list-style: none;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}
.nav-link {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 6px 18px;
    font-family: 'Cinzel', serif;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--white-dim);
    text-decoration: none;
    transition: color 0.25s ease;
    gap: 4px;
}
.nav-link span { position: relative; z-index: 1; }
.nav-underline {
    display: block;
    height: 1px;
    width: 0%;
    background: linear-gradient(90deg, var(--gold-light), var(--gold));
    border-radius: 2px;
    transition: width 0.35s var(--ease-out);
    font-style: normal;
    box-shadow: 0 0 8px var(--gold-glow);
}
.nav-link:hover,
.nav-link.active { color: var(--gold-light); }
.nav-link:hover .nav-underline,
.nav-link.active .nav-underline { width: 100%; }
.cta-btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 26px;
    border: 1px solid var(--gold);
    border-radius: 3px;
    background: linear-gradient(135deg, rgba(212,160,23,0.12), rgba(212,160,23,0.04));
    color: var(--gold-light);
    font-family: 'Cinzel', serif;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    text-decoration: none;
    overflow: hidden;
    flex-shrink: 0;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}
.cta-glow {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--gold-light), var(--gold));
    opacity: 0;
    transition: opacity 0.35s ease;
    border-radius: inherit;
}
.cta-text {
    position: relative;
    z-index: 1;
    transition: color 0.3s ease;
}
.cta-btn::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transform: skewX(-20deg);
    transition: left 0.55s ease;
}
.cta-btn:hover::before   { left: 160%; }
.cta-btn:hover           { border-color: var(--gold-light); box-shadow: 0 0 24px var(--gold-glow); }
.cta-btn:hover .cta-glow { opacity: 1; }
.cta-btn:hover .cta-text { color: var(--black); }
.hamburger {
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 5px;
    width: 42px; height: 42px;
    background: transparent;
    border: 1px solid rgba(212,160,23,0.3);
    border-radius: 4px;
    cursor: pointer;
    padding: 8px;
    flex-shrink: 0;
    transition: border-color 0.3s ease, background 0.3s ease;
}
.hamburger:hover { border-color: var(--gold); background: var(--gold-muted); }
.bar {
    display: block;
    width: 22px; height: 1.5px;
    background: var(--gold);
    border-radius: 2px;
    transition: transform 0.35s var(--ease-out), opacity 0.3s ease;
    transform-origin: center;
}
.bar-2 { width: 16px; align-self: flex-start; }
.hamburger.open .bar-1 { transform: translateY(6.5px) rotate(45deg); }
.hamburger.open .bar-2 { opacity: 0; transform: scaleX(0); }
.hamburger.open .bar-3 { transform: translateY(-6.5px) rotate(-45deg); }
.mobile-drawer {
    position: fixed;
    top: 0; left: 0;
    width: min(320px, 85vw);
    height: 100dvh;
    background: var(--black-card);
    border-right: 1px solid var(--black-border);
    z-index: 9998;
    transform: translateX(-100%);
    transition: transform 0.42s var(--ease-out);
    display: flex;
    flex-direction: column;
    box-shadow: 4px 0 40px rgba(0,0,0,0.8);
}
.mobile-drawer::after {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 2px; height: 100%;
    background: linear-gradient(180deg, transparent, var(--gold), transparent);
    opacity: 0.5;
}
.mobile-drawer.open { transform: translateX(0); }

.drawer-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: calc(var(--header-h) + 24px) 0 32px;
}
.drawer-links {
    list-style: none;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 0 20px;
}
.drawer-item {
    transform: translateX(-40px);
    opacity: 0;
    transition:
        transform 0.4s var(--ease-out) calc(var(--i) * 0.07s),
        opacity   0.4s ease           calc(var(--i) * 0.07s);
}
.mobile-drawer.open .drawer-item {
    transform: translateX(0);
    opacity: 1;
}

.drawer-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    font-family: 'Cinzel', serif;
    font-size: 0.88rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--white-dim);
    text-decoration: none;
    border-radius: 4px;
    border: 1px solid transparent;
    transition: color 0.25s, background 0.25s, border-color 0.25s;
}
.drawer-link:hover,
.drawer-link.active {
    color: var(--gold-light);
    background: var(--gold-muted);
    border-color: rgba(212,160,23,0.2);
}
.drawer-icon {
    color: var(--gold);
    font-size: 0.65rem;
    transition: transform 0.3s ease;
}
.drawer-link:hover .drawer-icon { transform: rotate(45deg); }

.drawer-cta-btn {
    display: block;
    margin-top: 16px;
    padding: 14px 16px;
    background: linear-gradient(135deg, var(--gold-dark), var(--gold));
    color: var(--black);
    font-family: 'Cinzel', serif;
    font-size: 0.84rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    text-decoration: none;
    border-radius: 4px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(212,160,23,0.3);
    transition: box-shadow 0.3s ease, transform 0.2s ease;
}
.drawer-cta-btn:hover {
    box-shadow: 0 6px 30px rgba(212,160,23,0.55);
    transform: translateY(-1px);
}

.drawer-footer {
    padding: 20px 36px;
    border-top: 1px solid var(--black-border);
    font-family: 'Cinzel', serif;
    font-size: 1.1rem;
    font-weight: 700;
    opacity: 0.5;
}
.drawer-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.65);
    z-index: 9997;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.4s ease;
    backdrop-filter: blur(3px);
}
.drawer-overlay.open { opacity: 1; pointer-events: all; }
@media (max-width: 900px) {
    .nav-links { display: none; }
    .cta-btn   { display: none; }
    .hamburger { display: flex; }
}
@media (min-width: 901px) {
    .mobile-drawer  { display: none; }
    .drawer-overlay { display: none; }
}
body.drawer-open { overflow: hidden; }
</style>
<header class="crypto-header" id="cryptoHeader">

    <div class="header-topline"></div>

    <nav class="header-nav container">
        <a href="{{ url('/') }}" class="logo" aria-label="CryptoOnly Home">
            <span class="logo-icon">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <polygon points="14,2 26,8 26,20 14,26 2,20 2,8" stroke="#D4A017" stroke-width="1.5" fill="none"/>
                    <polygon points="14,6 22,10 22,18 14,22 6,18 6,10" fill="#D4A017" opacity="0.15"/>
                    <text x="14" y="18" text-anchor="middle" font-family="serif" font-size="11" fill="#D4A017" font-weight="bold">$</text>
                </svg>
            </span>
            <span class="logo-text">
                <span class="logo-crypto">Dollar</span><span class="logo-only">bull university</span>
            </span>
        </a>
        <ul class="nav-links" role="list">
            <li>
                <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <span>Home</span>
                    <em class="nav-underline"></em>
                </a>
            </li>
            <li>
                <a href="{{ url('/about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">
                    <span>About Us</span>
                    <em class="nav-underline"></em>
                </a>
            </li>
            <li>
                <a href="{{ url('/contact') }}" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">
                    <span>Contact Us</span>
                    <em class="nav-underline"></em>
                </a>
            </li>
        </ul>
        <a href="{{ url('/contact') }}" class="cta-btn">
            <span class="cta-text">Contact Us</span>
            <span class="cta-glow"></span>
        </a>
        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle Menu" aria-expanded="false">
            <span class="bar bar-1"></span>
            <span class="bar bar-2"></span>
            <span class="bar bar-3"></span>
        </button>

    </nav>
    <div class="mobile-drawer" id="mobileDrawer" aria-hidden="true">
        <div class="drawer-inner">
            <ul class="drawer-links" role="list">
                <li class="drawer-item" style="--i:0">
                    <a href="{{ url('/') }}" class="drawer-link {{ request()->is('/') ? 'active' : '' }}">
                        <span class="drawer-icon">◈</span> Home
                    </a>
                </li>
                <li class="drawer-item" style="--i:1">
                    <a href="{{ url('/about') }}" class="drawer-link {{ request()->is('about') ? 'active' : '' }}">
                        <span class="drawer-icon">◈</span> About Us
                    </a>
                </li>
                <li class="drawer-item" style="--i:2">
                    <a href="{{ url('/contact') }}" class="drawer-link {{ request()->is('contact') ? 'active' : '' }}">
                        <span class="drawer-icon">◈</span> Contact Us
                    </a>
                </li>
                <li class="drawer-item" style="--i:3">
                    <a href="{{ url('/contact') }}" class="drawer-cta-btn">
                        Get In Touch
                    </a>
                </li>
            </ul>
            <div class="drawer-footer">
                <span class="logo-crypto">Crypto</span><span class="logo-only">Only</span>
            </div>
        </div>
    </div>

    <div class="drawer-overlay" id="drawerOverlay"></div>

</header>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const header    = document.getElementById('cryptoHeader');
    const hamburger = document.getElementById('hamburgerBtn');
    const drawer    = document.getElementById('mobileDrawer');
    const overlay   = document.getElementById('drawerOverlay');
    window.addEventListener('scroll', function () {
        header.classList.toggle('scrolled', window.scrollY > 20);
    }, { passive: true });
    function openDrawer() {
        drawer.classList.add('open');
        overlay.classList.add('open');
        hamburger.classList.add('open');
        hamburger.setAttribute('aria-expanded', 'true');
        drawer.setAttribute('aria-hidden', 'false');
        document.body.classList.add('drawer-open');
    }
    function closeDrawer() {
        drawer.classList.remove('open');
        overlay.classList.remove('open');
        hamburger.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        drawer.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('drawer-open');
    }

    hamburger.addEventListener('click', function () {
        drawer.classList.contains('open') ? closeDrawer() : openDrawer();
    });
    overlay.addEventListener('click', closeDrawer);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeDrawer();
    });

});
</script>