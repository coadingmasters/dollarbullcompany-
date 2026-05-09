{{-- ============================================================
     CryptoOnly — Professional Animated Footer
     Save at: resources/views/layouts/partials/footer.blade.php
     Include with: @include('layouts.partials.footer')
     ============================================================ --}}

<style>
/* ══════════════════════════════════════════════════════════
   FOOTER — BASE
══════════════════════════════════════════════════════════ */
.site-footer {
    position: relative;
    background: #070707;
    border-top: 1px solid #1a1a1a;
    overflow: hidden;
    font-family: 'Crimson Pro', Georgia, serif;
}

/* Ambient gold glow — top centre */
.site-footer::before {
    content: '';
    position: absolute;
    top: -160px; left: 50%;
    transform: translateX(-50%);
    width: 700px; height: 320px;
    background: radial-gradient(ellipse, rgba(212,160,23,0.07) 0%, transparent 70%);
    pointer-events: none;
}

/* Animated gold shimmer top border */
.footer-topbar {
    height: 2px;
    background: linear-gradient(90deg,
        transparent 0%,
        var(--gold-dark) 20%,
        var(--gold-light) 50%,
        var(--gold-dark) 80%,
        transparent 100%
    );
    background-size: 200% 100%;
    animation: ftop-shimmer 4s linear infinite;
}
@keyframes ftop-shimmer {
    0%   { background-position: -200% 0; }
    100% { background-position:  200% 0; }
}

/* ══════════════════════════════════════════════════════════
   NEWSLETTER BAND
══════════════════════════════════════════════════════════ */
.footer-newsletter {
    background: linear-gradient(135deg, #0d0d0d 0%, #111008 100%);
    border-bottom: 1px solid #1a1a1a;
    padding: 52px 40px;
}
.fn-inner {
    max-width: 1180px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    flex-wrap: wrap;
}
.fn-text {}
.fn-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    font-family: 'Cinzel', serif;
    font-size: 0.6rem;
    letter-spacing: 0.26em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 10px;
}
.fn-eyebrow-dot {
    width: 5px; height: 5px;
    border-radius: 50%;
    background: var(--gold);
    animation: blink 1.6s ease-in-out infinite;
}
.fn-title {
    font-family: 'Cinzel', serif;
    font-size: clamp(1.3rem, 2.5vw, 1.85rem);
    font-weight: 700;
    color: #fff;
    letter-spacing: 0.02em;
    line-height: 1.2;
}
.fn-title span {
    background: linear-gradient(135deg, var(--gold-light), var(--gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.fn-form {
    display: flex;
    gap: 0;
    flex-shrink: 0;
    min-width: 340px;
    max-width: 460px;
    width: 100%;
}
.fn-input {
    flex: 1;
    padding: 13px 18px;
    background: rgba(255,255,255,0.04);
    border: 1px solid #2a2a2a;
    border-right: none;
    border-radius: 2px 0 0 2px;
    color: rgba(255,255,255,0.8);
    font-family: 'Crimson Pro', serif;
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.3s, background 0.3s;
}
.fn-input::placeholder { color: rgba(255,255,255,0.28); }
.fn-input:focus {
    border-color: rgba(212,160,23,0.5);
    background: rgba(212,160,23,0.04);
}
.fn-submit {
    padding: 13px 22px;
    background: linear-gradient(135deg, var(--gold-dark), var(--gold));
    color: #060606;
    font-family: 'Cinzel', serif;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: none;
    border-radius: 0 2px 2px 0;
    cursor: pointer;
    transition: box-shadow 0.3s, transform 0.2s;
    white-space: nowrap;
}
.fn-submit:hover {
    box-shadow: 0 4px 20px rgba(212,160,23,0.45);
    transform: translateY(-1px);
}

/* ══════════════════════════════════════════════════════════
   MAIN FOOTER GRID
══════════════════════════════════════════════════════════ */
.footer-main {
    padding: 72px 40px 52px;
    max-width: 1180px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1.8fr 1fr 1fr 1fr;
    gap: 48px;
}

/* ── Column 1: Brand ── */
.footer-brand {}
.fb-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    margin-bottom: 22px;
}
.fb-logo-icon {
    display: flex;
    align-items: center;
    filter: drop-shadow(0 0 6px rgba(212,160,23,0.4));
    animation: pulse-icon 3s ease-in-out infinite;
}
@keyframes pulse-icon {
    0%,100% { filter: drop-shadow(0 0 5px rgba(212,160,23,0.35)); }
    50%      { filter: drop-shadow(0 0 14px rgba(245,200,66,0.6)); }
}
.fb-logo-text {
    font-family: 'Cinzel', serif;
    font-size: 1.25rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    line-height: 1;
}
.fb-logo-crypto { color: #fff; }
.fb-logo-only {
    background: linear-gradient(135deg, var(--gold-light), var(--gold), var(--gold-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.fb-desc {
    font-size: 0.95rem;
    font-weight: 300;
    font-style: italic;
    color: rgba(255,255,255,0.42);
    line-height: 1.8;
    margin-bottom: 28px;
    max-width: 290px;
}

/* Social icons */
.fb-socials {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.fb-social {
    width: 38px; height: 38px;
    border: 1px solid #222;
    border-radius: 2px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.42);
    text-decoration: none;
    font-size: 0.85rem;
    transition: border-color 0.3s, color 0.3s, background 0.3s, transform 0.25s;
    position: relative;
    overflow: hidden;
}
.fb-social::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--gold-dark), var(--gold));
    transform: scaleY(0);
    transform-origin: bottom;
    transition: transform 0.35s cubic-bezier(0.16,1,0.3,1);
}
.fb-social:hover { border-color: var(--gold); color: #060606; transform: translateY(-3px); }
.fb-social:hover::before { transform: scaleY(1); }
.fb-social span { position: relative; z-index: 1; }

/* Trust badges */
.fb-trust {
    display: flex;
    gap: 10px;
    margin-top: 24px;
    flex-wrap: wrap;
}
.fb-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border: 1px solid #1e1e1e;
    border-radius: 2px;
    background: rgba(255,255,255,0.02);
    font-family: 'Cinzel', serif;
    font-size: 0.55rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.32);
}
.fb-badge-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--gold); opacity: 0.7; flex-shrink: 0; }

/* ── Columns 2-4: Nav ── */
.footer-col-title {
    font-family: 'Cinzel', serif;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.footer-col-title::after {
    content: '';
    display: block;
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, rgba(212,160,23,0.4), transparent);
}

.footer-links {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.footer-links li a {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 7px 0;
    font-family: 'Crimson Pro', serif;
    font-size: 0.95rem;
    font-weight: 300;
    color: rgba(255,255,255,0.42);
    text-decoration: none;
    border-bottom: 1px solid transparent;
    position: relative;
    transition: color 0.25s, padding-left 0.3s cubic-bezier(0.16,1,0.3,1);
}
.footer-links li a::before {
    content: '';
    display: block;
    width: 0;
    height: 1px;
    background: var(--gold);
    flex-shrink: 0;
    transition: width 0.3s cubic-bezier(0.16,1,0.3,1);
}
.footer-links li a:hover {
    color: var(--gold-light);
    padding-left: 4px;
}
.footer-links li a:hover::before { width: 12px; }

/* Contact info items */
.footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 8px 0;
    border-bottom: 1px solid #131313;
    color: rgba(255,255,255,0.42);
    font-family: 'Crimson Pro', serif;
    font-size: 0.92rem;
    font-weight: 300;
    line-height: 1.6;
}
.footer-contact-item:last-child { border-bottom: none; }
.fci-icon {
    width: 28px; height: 28px;
    flex-shrink: 0;
    border-radius: 2px;
    background: rgba(212,160,23,0.08);
    border: 1px solid rgba(212,160,23,0.2);
    display: flex; align-items: center; justify-content: center;
    margin-top: 2px;
    transition: background 0.3s;
}
.footer-contact-item:hover .fci-icon { background: rgba(212,160,23,0.18); }
.fci-icon svg {
    width: 13px; height: 13px;
    stroke: var(--gold); fill: none; stroke-width: 1.8;
}
.fci-text a {
    color: rgba(255,255,255,0.42);
    text-decoration: none;
    transition: color 0.25s;
}
.fci-text a:hover { color: var(--gold-light); }

/* ══════════════════════════════════════════════════════════
   FOOTER BOTTOM BAR
══════════════════════════════════════════════════════════ */
.footer-bottom {
    border-top: 1px solid #141414;
    padding: 22px 40px;
}
.fb-bottom-inner {
    max-width: 1180px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}
.fb-copy {
    font-family: 'Crimson Pro', serif;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.25);
}
.fb-copy span { color: var(--gold); opacity: 0.7; }
.fb-bottom-links {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
}
.fb-bottom-links a {
    font-family: 'Cinzel', serif;
    font-size: 0.58rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.25);
    text-decoration: none;
    transition: color 0.25s;
}
.fb-bottom-links a:hover { color: var(--gold); }
.fb-live {
    display: flex;
    align-items: center;
    gap: 7px;
    font-family: 'Cinzel', serif;
    font-size: 0.58rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.25);
}
.fb-live-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #22c55e;
    box-shadow: 0 0 0 0 rgba(34,197,94,0.5);
    animation: live-pulse 2s ease-in-out infinite;
}
@keyframes live-pulse {
    0%   { box-shadow: 0 0 0 0   rgba(34,197,94,0.5); }
    70%  { box-shadow: 0 0 0 7px rgba(34,197,94,0);   }
    100% { box-shadow: 0 0 0 0   rgba(34,197,94,0);   }
}

/* ══════════════════════════════════════════════════════════
   ENTRANCE ANIMATIONS
══════════════════════════════════════════════════════════ */
.f-animate {
    opacity: 0;
    transform: translateY(28px);
    transition:
        opacity   0.7s ease            calc(var(--fi, 0) * 0.1s),
        transform 0.7s cubic-bezier(0.16,1,0.3,1) calc(var(--fi, 0) * 0.1s);
}
.f-animate.in-view {
    opacity: 1;
    transform: translateY(0);
}

/* ══════════════════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════════════════ */
@media (max-width: 1050px) {
    .footer-main { grid-template-columns: 1fr 1fr; gap: 36px; }
    .footer-brand { grid-column: 1 / -1; }
    .fb-desc { max-width: 100%; }
}
@media (max-width: 680px) {
    .footer-main { grid-template-columns: 1fr 1fr; gap: 28px; padding: 48px 20px 36px; }
    .footer-brand { grid-column: 1 / -1; }
    .footer-newsletter { padding: 36px 20px; }
    .fn-inner { flex-direction: column; align-items: flex-start; }
    .fn-form { min-width: 0; }
    .footer-bottom { padding: 20px; }
    .fb-bottom-inner { flex-direction: column; align-items: flex-start; gap: 14px; }
}
@media (max-width: 420px) {
    .footer-main { grid-template-columns: 1fr; }
    .fn-form { flex-direction: column; }
    .fn-input { border-right: 1px solid #2a2a2a; border-radius: 2px; }
    .fn-submit { border-radius: 2px; }
}
</style>


{{-- ══════════════════════════════════════════════════════════
     FOOTER HTML
══════════════════════════════════════════════════════════ --}}
<footer class="site-footer" id="siteFooter" aria-label="Site Footer">

    {{-- ── Animated gold shimmer top line ── --}}
    <div class="footer-topbar" aria-hidden="true"></div>

    {{-- ══════════════════════════════════════════════════
         NEWSLETTER BAND
    ══════════════════════════════════════════════════ --}}
    <div class="footer-newsletter">
        <div class="fn-inner">
            <div class="fn-text f-animate" style="--fi:0">
                <div class="fn-eyebrow">
                    <span class="fn-eyebrow-dot"></span>
                    Stay Ahead of the Market
                </div>
                <h3 class="fn-title">
                    Get Free <span>Crypto Signals</span><br>
                    Delivered to Your Inbox
                </h3>
            </div>
            <form class="fn-form f-animate" style="--fi:1" onsubmit="return false;" aria-label="Newsletter signup">
                <input
                    class="fn-input"
                    type="email"
                    placeholder="Enter your email address..."
                    aria-label="Email address"
                    autocomplete="email"
                >
                <button class="fn-submit" type="submit">Subscribe</button>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         MAIN FOOTER GRID
    ══════════════════════════════════════════════════ --}}
    <div class="footer-main">

        {{-- ── Column 1: Brand ── --}}
        <div class="footer-brand f-animate" style="--fi:0">
            <a href="{{ url('/') }}" class="fb-logo" aria-label="CryptoOnly Home">
                <span class="fb-logo-icon">
                    <svg width="26" height="26" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="14,2 26,8 26,20 14,26 2,20 2,8" stroke="#D4A017" stroke-width="1.5" fill="none"/>
                        <polygon points="14,6 22,10 22,18 14,22 6,18 6,10" fill="#D4A017" opacity="0.15"/>
                        <text x="14" y="18" text-anchor="middle" font-family="serif" font-size="11" fill="#D4A017" font-weight="bold">$</text>
                    </svg>
                </span>
                <span class="fb-logo-text">
                    <span class="fb-logo-crypto">Dollar</span><span class="fb-logo-only">bull university</span>
                </span>
            </a>

            <p class="fb-desc">
                Your all-in-one platform for crypto intelligence, education, and peer-to-peer trading. Trusted by 320,000+ traders worldwide since 2019.
            </p>

            {{-- Social links --}}
            <div class="fb-socials" role="list" aria-label="Social media links">
                <a href="#" class="fb-social" aria-label="Twitter / X" role="listitem">
                    <span>𝕏</span>
                </a>
                <a href="#" class="fb-social" aria-label="Telegram" role="listitem">
                    <span style="font-size:1rem;">✈</span>
                </a>
                <a href="#" class="fb-social" aria-label="Instagram" role="listitem">
                    <span style="font-size:1rem;">◎</span>
                </a>
                <a href="#" class="fb-social" aria-label="YouTube" role="listitem">
                    <span style="font-size:0.9rem;">▶</span>
                </a>
                <a href="#" class="fb-social" aria-label="Discord" role="listitem">
                    <span style="font-size:0.85rem;">⬡</span>
                </a>
                <a href="#" class="fb-social" aria-label="LinkedIn" role="listitem">
                    <span style="font-size:0.8rem;">in</span>
                </a>
            </div>

            {{-- Trust badges --}}
            <div class="fb-trust" aria-label="Trust indicators">
                <span class="fb-badge"><span class="fb-badge-dot"></span> SSL Secured</span>
                <span class="fb-badge"><span class="fb-badge-dot"></span> Regulated</span>
                <span class="fb-badge"><span class="fb-badge-dot"></span> ISO Certified</span>
            </div>
        </div>

        {{-- ── Column 2: Services ── --}}
        <div class="footer-col f-animate" style="--fi:1">
            <h4 class="footer-col-title">Services</h4>
            <ul class="footer-links" role="list">
                <li><a href="{{ url('/premium-group') }}">Premium Group</a></li>
                <li><a href="{{ url('/courses') }}">Paid Courses</a></li>
                <li><a href="{{ url('/live-sessions') }}">Live Sessions</a></li>
                <li><a href="{{ url('/p2p') }}">P2P Trading</a></li>
                <li><a href="{{ url('/signals') }}">Crypto Signals</a></li>
                <li><a href="{{ url('/portfolio') }}">Portfolio Tracker</a></li>
                <li><a href="{{ url('/markets') }}">Live Markets</a></li>
            </ul>
        </div>

        {{-- ── Column 3: Company ── --}}
        <div class="footer-col f-animate" style="--fi:2">
            <h4 class="footer-col-title">Company</h4>
            <ul class="footer-links" role="list">
                <li><a href="{{ url('/about') }}">About Us</a></li>
                <li><a href="{{ url('/team') }}">Our Team</a></li>
                <li><a href="{{ url('/careers') }}">Careers</a></li>
                <li><a href="{{ url('/blog') }}">Blog & News</a></li>
                <li><a href="{{ url('/press') }}">Press Kit</a></li>
                <li><a href="{{ url('/partners') }}">Partners</a></li>
                <li><a href="{{ url('/contact') }}">Contact Us</a></li>
            </ul>
        </div>

        {{-- ── Column 4: Contact ── --}}
        <div class="footer-col f-animate" style="--fi:3">
            <h4 class="footer-col-title">Get In Touch</h4>

            <div class="footer-contact-item">
                <div class="fci-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke-linecap="round"/><path d="M22 6l-10 7L2 6" stroke-linecap="round"/></svg>
                </div>
                <div class="fci-text">
                    <a href="mailto:support@cryptoonly.com">support@cryptoonly.com</a>
                </div>
            </div>

            <div class="footer-contact-item">
                <div class="fci-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.08 2.18 2 2 0 012.06 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" stroke-linecap="round"/></svg>
                </div>
                <div class="fci-text">
                    <a href="tel:+441234567890">+44 1234 567 890</a>
                </div>
            </div>

            <div class="footer-contact-item">
                <div class="fci-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" stroke-linecap="round"/><circle cx="12" cy="10" r="3" stroke-linecap="round"/></svg>
                </div>
                <div class="fci-text">
                    Level 12, The Shard<br>
                    London SE1 9RY, UK
                </div>
            </div>

            <div class="footer-contact-item">
                <div class="fci-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-linecap="round"/><path d="M12 6v6l4 2" stroke-linecap="round"/></svg>
                </div>
                <div class="fci-text">
                    Mon – Fri: 9am – 6pm GMT<br>
                    Support: 24 / 7
                </div>
            </div>
        </div>

    </div>{{-- /.footer-main --}}

    {{-- ══════════════════════════════════════════════════
         BOTTOM BAR
    ══════════════════════════════════════════════════ --}}
    <div class="footer-bottom">
        <div class="fb-bottom-inner">

            <p class="fb-copy">
                &copy; {{ date('Y') }} <span>CryptoOnly</span>. All rights reserved. Built with ♦ for traders worldwide.
            </p>

            <nav class="fb-bottom-links" aria-label="Legal links">
                <a href="{{ url('/privacy') }}">Privacy Policy</a>
                <a href="{{ url('/terms') }}">Terms of Use</a>
                <a href="{{ url('/cookies') }}">Cookie Policy</a>
                <a href="{{ url('/disclaimer') }}">Risk Disclaimer</a>
            </nav>

            <div class="fb-live" aria-label="System status: online">
                <span class="fb-live-dot" aria-hidden="true"></span>
                All Systems Online
            </div>

        </div>
    </div>

</footer>


{{-- ══════════════════════════════════════════════════════════
     FOOTER JS — IntersectionObserver entrance animation
══════════════════════════════════════════════════════════ --}}
<script>
(function () {
    var els = document.querySelectorAll('.f-animate');
    if (!els.length) return;
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.classList.add('in-view');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.1 });
        els.forEach(function (el) { io.observe(el); });
    } else {
        els.forEach(function (el) { el.classList.add('in-view'); });
    }
})();
</script>