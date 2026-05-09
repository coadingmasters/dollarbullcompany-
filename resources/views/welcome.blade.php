<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CryptoOnly') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    
</head>
<body>
@include('layouts.partials.header')
<section class="hero-slider" id="heroSlider" aria-label="Hero Slider">
    <div class="slide-counter" aria-hidden="true">
        <span class="counter-current" id="counterCurrent">01</span>
        <span class="counter-sep"></span>
        <span class="counter-total">0{{ count($slides) }}</span>
    </div>
    <div class="slides-track" id="slidesTrack">
        @foreach($slides as $index => $slide)
        <div class="slide {{ $index === 0 ? 'active' : '' }}"
             aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">

            <img
                class="slide-bg"
                src="{{ $slide['image'] }}"
                alt="{{ $slide['badge'] }}"
                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
            >

            <div class="slide-overlay"></div>

            <div class="slide-content">
                <div class="slide-badge">
                    <span class="badge-dot"></span>
                    {{ $slide['badge'] }}
                </div>

                <h1 class="slide-headline">
                    {{ $slide['headline'] }}
                    <span class="hl">{{ $slide['highlight'] }}</span>
                </h1>

                <p class="slide-sub">{{ $slide['sub'] }}</p>

                <div class="slide-ctas">
                    <a href="{{ $slide['btn1_url'] }}" class="btn-primary">
                        {{ $slide['btn1_label'] }}
                        <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ $slide['btn2_url'] }}" class="btn-outline">
                        {{ $slide['btn2_label'] }}
                    </a>
                </div>
            </div>

            {{-- Decorative large number --}}
            <div class="slide-num">0{{ $index + 1 }}</div>

        </div>
        @endforeach
    </div>

    {{-- Arrows --}}
    <button class="slider-arrow arrow-prev" id="arrowPrev" aria-label="Previous slide">
        <svg viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    </button>
    <button class="slider-arrow arrow-next" id="arrowNext" aria-label="Next slide">
        <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </button>

    {{-- Dots --}}
    <div class="slider-dots" role="tablist" aria-label="Slide navigation">
        @foreach($slides as $index => $slide)
        <button
            class="dot {{ $index === 0 ? 'active' : '' }}"
            role="tab"
            aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
            aria-label="Slide {{ $index + 1 }}"
            data-index="{{ $index }}">
        </button>
        @endforeach
    </div>

    {{-- Progress bar --}}
    <div class="slide-progress" id="slideProgress"></div>

</section>


{{-- ══════════════════════════════════════════════════════
     STATS BAR
══════════════════════════════════════════════════════ --}}
<section class="stats-bar" aria-label="Platform Statistics">
    <div class="stats-inner">
        <div class="stat-item">
            <div class="stat-value">$4.2B+</div>
            <div class="stat-label">Trading Volume</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-value">320K+</div>
            <div class="stat-label">Active Traders</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-value">180+</div>
            <div class="stat-label">Crypto Assets</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div class="stat-value">99.98%</div>
            <div class="stat-label">Uptime SLA</div>
        </div>
    </div>
</section>

{{-- ============================================================
     Services Section — 4 Animated Cards
     Black & Gold | Paste after stats-bar in welcome.blade.php
     OR save as: resources/views/layouts/partials/services.blade.php
     and include with: @include('layouts.partials.services')
     ============================================================ --}}




{{-- ══════════════════════════════════════════════════════════
     HTML
══════════════════════════════════════════════════════════ --}}
<section class="services-section" id="servicesSection" aria-label="Our Services">
    <div class="services-container">

        {{-- ── Section Header ── --}}
        <div class="section-header">
            <div class="section-eyebrow">
                <span class="eyebrow-line"></span>
                What We Offer
                <span class="eyebrow-line right"></span>
            </div>
            <h2 class="section-title">
                Everything You Need to<br>
                <span>Master Crypto</span>
            </h2>
            <p class="section-desc">
                From exclusive insider groups to live expert sessions — we provide every tool you need to thrive in the digital asset space.
            </p>
        </div>

        {{-- ── Cards Grid ── --}}
        <div class="services-grid" id="servicesGrid">

            {{-- ── 1. Premium Group ── --}}
            <div class="service-card" style="--ci:0" data-card>
                <div class="card-shimmer"></div>
                <div class="card-img-wrap">
                    <img
                        class="card-img"
                        src="https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=800&q=80"
                        alt="Premium Group"
                        loading="lazy"
                    >
                    <div class="card-img-overlay"></div>
                    <div class="card-number">01</div>
                    <div class="card-icon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M3 18h18M5 18l-1-9 5 4 3-7 3 7 5-4-1 9H5z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="card-body">
                    <span class="card-tag">Exclusive Access</span>
                    <h3 class="card-title">Premium Group</h3>
                    <p class="card-desc">
                        Join our elite private community of serious crypto investors. Get insider signals, whale alerts, and curated alpha before the market moves.
                    </p>
                    <a href="{{ url('/premium-group') }}" class="card-btn">
                        <span class="btn-fill"></span>
                        <span>Join Now</span>
                        <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <div class="card-stats">
                        <div class="card-stat">
                            <span class="cs-val">12K+</span>
                            <span class="cs-lbl">Members</span>
                        </div>
                        <div class="card-stat">
                            <span class="cs-val">Daily</span>
                            <span class="cs-lbl">Signals</span>
                        </div>
                        <div class="card-stat">
                            <span class="cs-val">VIP</span>
                            <span class="cs-lbl">Support</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── 2. Paid Courses ── --}}
            <div class="service-card" style="--ci:1" data-card>
                <div class="card-shimmer"></div>
                <div class="card-img-wrap">
                    <img
                        class="card-img"
                        src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&q=80"
                        alt="Paid Courses"
                        loading="lazy"
                    >
                    <div class="card-img-overlay"></div>
                    <div class="card-number">02</div>
                    <div class="card-icon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 10L12 5 2 10l10 5 10-5z" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 12v5c3.33 1.67 8.67 1.67 12 0v-5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="card-body">
                    <span class="card-tag">Learn & Earn</span>
                    <h3 class="card-title">Paid Courses</h3>
                    <p class="card-desc">
                        Structured crypto courses from beginner to advanced. Master technical analysis, DeFi strategies, and portfolio management with certified instructors.
                    </p>
                    <a href="{{ url('/courses') }}" class="card-btn">
                        <span class="btn-fill"></span>
                        <span>Enrol Today</span>
                        <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <div class="card-stats">
                        <div class="card-stat">
                            <span class="cs-val">40+</span>
                            <span class="cs-lbl">Courses</span>
                        </div>
                        <div class="card-stat">
                            <span class="cs-val">Expert</span>
                            <span class="cs-lbl">Tutors</span>
                        </div>
                        <div class="card-stat">
                            <span class="cs-val">Cert.</span>
                            <span class="cs-lbl">Awarded</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── 3. Live Sessions ── --}}
            <div class="service-card" style="--ci:2" data-card>
                <div class="card-shimmer"></div>
                <div class="card-img-wrap">
                    <img
                        class="card-img"
                        src="https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=800&q=80"
                        alt="Live Sessions"
                        loading="lazy"
                    >
                    <div class="card-img-overlay"></div>
                    <div class="card-number">03</div>
                    <div class="card-icon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="7" width="15" height="10" rx="1" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17 9l5-2v10l-5-2V9z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="card-body">
                    <span class="card-tag">Real-Time</span>
                    <h3 class="card-title">Live Sessions</h3>
                    <p class="card-desc">
                        Interactive live trading sessions with top analysts. Watch real trades, ask live questions, and learn to read market momentum as it happens.
                    </p>
                    <a href="{{ url('/live-sessions') }}" class="card-btn">
                        <span class="btn-fill"></span>
                        <span>Watch Live</span>
                        <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <div class="card-stats">
                        <div class="card-stat">
                            <span class="cs-val">3×</span>
                            <span class="cs-lbl">Weekly</span>
                        </div>
                        <div class="card-stat">
                            <span class="cs-val">HD</span>
                            <span class="cs-lbl">Stream</span>
                        </div>
                        <div class="card-stat">
                            <span class="cs-val">Q&amp;A</span>
                            <span class="cs-lbl">Live</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── 4. P2P ── --}}
            <div class="service-card" style="--ci:3" data-card>
                <div class="card-shimmer"></div>
                <div class="card-img-wrap">
                    <img
                        class="card-img"
                        src="https://images.unsplash.com/photo-1644361566696-3d442b5b482a?w=800&q=80"
                        alt="P2P Trading"
                        loading="lazy"
                    >
                    <div class="card-img-overlay"></div>
                    <div class="card-number">04</div>
                    <div class="card-icon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M17 1l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 11V9a4 4 0 014-4h14" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7 23l-4-4 4-4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 13v2a4 4 0 01-4 4H3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="card-body">
                    <span class="card-tag">Peer-to-Peer</span>
                    <h3 class="card-title">P2P Trading</h3>
                    <p class="card-desc">
                        Trade directly with verified community members. Zero middleman fees, flexible payment methods, and escrow-secured transactions for total peace of mind.
                    </p>
                    <a href="{{ url('/p2p') }}" class="card-btn">
                        <span class="btn-fill"></span>
                        <span>Start Trading</span>
                        <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <div class="card-stats">
                        <div class="card-stat">
                            <span class="cs-val">0%</span>
                            <span class="cs-lbl">Fees</span>
                        </div>
                        <div class="card-stat">
                            <span class="cs-val">Escrow</span>
                            <span class="cs-lbl">Secured</span>
                        </div>
                        <div class="card-stat">
                            <span class="cs-val">24/7</span>
                            <span class="cs-lbl">Active</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /.services-grid --}}
    </div>{{-- /.services-container --}}
</section>

{{-- ============================================================
     About Us Section
     Paste after services section in welcome.blade.php
     OR save as: resources/views/layouts/partials/about.blade.php
     ============================================================ --}}




<section class="about-section" id="aboutSection" aria-label="About Us">
    <div class="about-inner">

        {{-- ── Image Column ── --}}
        <div class="about-img-col" data-about-col>
            <div class="about-img-frame">
                <img
                    src="https://images.unsplash.com/photo-1642790106117-e829e14a795f?w=900&q=80"
                    alt="CryptoOnly Team — Trading professionals"
                    loading="lazy"
                >
            </div>
            <div class="about-corner tl"></div>
            <div class="about-corner br"></div>
            <div class="about-badge">
                <div class="about-badge-val">2019</div>
                <div class="about-badge-lbl">Est. Founded</div>
            </div>
        </div>

        {{-- ── Text Column ── --}}
        <div class="about-text-col" data-about-col>

            <div class="about-eyebrow">
                <span class="ey-line"></span>
                About Us
            </div>

            <h2 class="about-title">
                Built by Traders,<br>
                <span>For Traders</span>
            </h2>

            <div class="about-divider"></div>

            <p class="about-desc">
                CryptoOnly was born from a simple belief — that every serious trader deserves access to the same institutional-grade intelligence, community, and tools that move markets globally.
            </p>

            <div class="about-points">
                <div class="about-point">
                    <div class="about-point-icon">✦</div>
                    <div class="about-point-body">
                        <div class="about-point-title">Our Mission</div>
                        <div class="about-point-text">To democratise crypto wealth by equipping every member with knowledge, signals, and a thriving peer community.</div>
                    </div>
                </div>
                <div class="about-point">
                    <div class="about-point-icon">◈</div>
                    <div class="about-point-body">
                        <div class="about-point-title">Our Edge</div>
                        <div class="about-point-text">A team of 20+ certified analysts, ex-institutional traders, and DeFi researchers working daily on your behalf.</div>
                    </div>
                </div>
                <div class="about-point">
                    <div class="about-point-icon">▲</div>
                    <div class="about-point-body">
                        <div class="about-point-title">Our Track Record</div>
                        <div class="about-point-text">Over $4.2B in community trading volume and 320,000+ members across 60 countries since launch.</div>
                    </div>
                </div>
            </div>

            <a href="{{ url('/about') }}" class="about-btn">
                <span class="ab-fill"></span>
                <span>Read More</span>
                <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>

        </div>
    </div>
</section>



{{-- ══════════════════════════════════════════════════════════
     JS — IntersectionObserver entrance animation
══════════════════════════════════════════════════════════ --}}


@include('layouts.partials.footer')
<script defer src="{{ asset('js/welcome.js') }}"></script>
</body>
</html>