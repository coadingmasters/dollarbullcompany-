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




<script defer src="{{ asset('js/welcome.js') }}"></script>
</body>
</html>