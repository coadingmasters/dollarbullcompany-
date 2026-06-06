@extends('layouts.frontend')
@section('title', 'Blog — ' . config('app.name'))

@push('styles')
<style>
:root {
    --gold:        #D4A017;
    --gold-light:  #F5C842;
    --gold-dark:   #A07810;
    --gold-muted:  rgba(212,160,23,.12);
    --gold-glow:   rgba(212,160,23,.45);
    --black:       #060606;
    --bc:          #0d0d0d;
    --bb:          #1a1a1a;
    --b2:          #242424;
    --white:       #fff;
    --wd:          rgba(255,255,255,.75);
    --wf:          rgba(255,255,255,.38);
    --ease:        cubic-bezier(.16,1,.3,1);
}

/* ── HERO ─────────────────────────────────────── */
.blog-hero {
    position: relative;
    height: 52vh; min-height: 380px;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; margin-top: 0;
    background: var(--black);
}
.blog-hero-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1518186285589-2f7649de83e0?w=1800&q=80') center/cover no-repeat;
    animation: bgzoom 20s ease-in-out infinite alternate;
    opacity: .18;
}
@keyframes bgzoom { 0%{transform:scale(1)} 100%{transform:scale(1.08)} }

.blog-hero-ov {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(6,6,6,.97) 0%, rgba(6,6,6,.7) 50%, rgba(6,6,6,.95) 100%);
}
.blog-hero-ov::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, transparent, var(--gold-dark) 20%, var(--gold-light) 50%, var(--gold-dark) 80%, transparent);
}

/* floating orbs */
.blog-hero-orb {
    position: absolute; border-radius: 50%; pointer-events: none;
    animation: orbFloat 8s ease-in-out infinite;
}
.blog-hero-orb:nth-child(1) { width: 320px; height: 320px; top: -80px; right: 8%; background: radial-gradient(circle, rgba(212,160,23,.07) 0%, transparent 70%); animation-delay: 0s; }
.blog-hero-orb:nth-child(2) { width: 200px; height: 200px; bottom: -40px; left: 12%; background: radial-gradient(circle, rgba(212,160,23,.05) 0%, transparent 70%); animation-delay: -3s; }
@keyframes orbFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-18px)} }

.blog-hero-content {
    position: relative; z-index: 1; text-align: center; padding: 0 24px;
    opacity: 0; transform: translateY(28px);
    animation: heroIn .85s var(--ease) .15s forwards;
}
@keyframes heroIn { to { opacity: 1; transform: translateY(0); } }

.blog-hero-eyebrow {
    display: inline-flex; align-items: center; gap: 9px;
    font-family: 'Cinzel', serif; font-size: .58rem; letter-spacing: .3em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 18px;
}
.blog-hero-eyebrow::before,
.blog-hero-eyebrow::after {
    content: ''; display: block; width: 32px; height: 1px; background: var(--gold); opacity: .5;
}

.blog-hero-title {
    font-family: 'Cinzel', serif;
    font-size: clamp(2.2rem, 5.5vw, 3.8rem);
    font-weight: 900; color: var(--white);
    letter-spacing: .04em; line-height: 1.1; margin-bottom: 16px;
}
.blog-hero-title span {
    background: linear-gradient(135deg, var(--gold-light), var(--gold), var(--gold-dark));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.blog-hero-sub {
    font-size: clamp(.95rem, 2vw, 1.1rem); font-weight: 300; font-style: italic;
    color: var(--wf); max-width: 500px; margin: 0 auto; line-height: 1.8;
}

/* ── BODY ─────────────────────────────────────── */
.blog-body {
    background: var(--black);
    padding: 60px 24px 90px;
}
.blog-container { max-width: 1220px; margin: 0 auto; }

/* Section label */
.blog-section-label {
    display: flex; align-items: center; gap: 14px; margin-bottom: 40px;
}
.bsl-line { flex: 1; height: 1px; background: var(--bb); }
.bsl-text {
    font-family: 'Cinzel', serif; font-size: .58rem; letter-spacing: .28em;
    text-transform: uppercase; color: var(--gold); white-space: nowrap;
}

/* ── CARDS GRID ───────────────────────────────── */
.cards-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
    margin-bottom: 60px;
}

/* Card animation */
@keyframes cardIn {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}

.blog-card {
    background: var(--bc);
    border: 1px solid var(--bb);
    border-radius: 14px;
    overflow: hidden;
    display: flex; flex-direction: column;
    position: relative;
    transition: transform .3s var(--ease), border-color .3s ease, box-shadow .3s ease;
    opacity: 0;
    animation: cardIn .6s var(--ease) both;
}
@for ($i = 1; $i <= 9; $i++)
.blog-card:nth-child({{ $i }}) { animation-delay: {{ ($i - 1) * 0.08 }}s; }
@endfor

.blog-card::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--gold-muted) 0%, transparent 60%);
    opacity: 0; transition: opacity .3s ease; pointer-events: none; z-index: 0;
}
.blog-card:hover { transform: translateY(-6px); border-color: rgba(212,160,23,.35); box-shadow: 0 20px 50px rgba(0,0,0,.7), 0 0 30px rgba(212,160,23,.07); }
.blog-card:hover::before { opacity: 1; }

/* Card image */
.card-img-wrap {
    position: relative; overflow: hidden; height: 210px;
    background: #0a0a0a; flex-shrink: 0;
}
.card-img-wrap img {
    width: 100%; height: 100%; object-fit: cover;
    opacity: .7;
    transition: transform .5s var(--ease), opacity .3s ease;
}
.blog-card:hover .card-img-wrap img { transform: scale(1.07); opacity: .85; }

.card-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #0d0d0d, #151515);
    color: rgba(212,160,23,.25); font-size: 2.8rem;
}

.card-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(0deg, rgba(6,6,6,.85) 0%, transparent 55%);
}

.card-cat {
    position: absolute; top: 14px; left: 14px; z-index: 2;
    font-family: 'Cinzel', serif;
    font-size: .55rem; font-weight: 600; letter-spacing: .2em; text-transform: uppercase;
    color: var(--gold); background: rgba(6,6,6,.8);
    border: 1px solid rgba(212,160,23,.3); border-radius: 4px;
    padding: 4px 10px; backdrop-filter: blur(4px);
}

/* Card body */
.card-body {
    padding: 20px 22px 22px;
    flex: 1; display: flex; flex-direction: column; gap: 10px;
    position: relative; z-index: 1;
}
.card-title {
    font-family: 'Cinzel', serif;
    font-size: .9rem; font-weight: 700; color: var(--white);
    line-height: 1.4; text-decoration: none;
    transition: color .2s ease;
}
.card-title:hover { color: var(--gold-light); }

.card-excerpt {
    font-size: .88rem; font-weight: 300; font-style: italic;
    color: var(--wf); line-height: 1.65; flex: 1;
}

/* Gold divider */
.card-divider {
    height: 1px;
    background: linear-gradient(90deg, var(--gold-dark), transparent);
    opacity: .4; margin: 2px 0;
}

.card-meta {
    display: flex; align-items: center; justify-content: space-between;
}
.meta-author { display: flex; align-items: center; gap: 8px; }
.meta-av {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg, var(--gold-dark), var(--gold));
    display: flex; align-items: center; justify-content: center;
    font-family: 'Cinzel', serif; font-size: .6rem; font-weight: 700;
    color: var(--black); flex-shrink: 0;
}
.meta-name { font-size: .76rem; font-weight: 600; color: var(--wd); font-family: 'Cinzel', serif; letter-spacing: .04em; }
.meta-date { font-size: .72rem; color: var(--wf); margin-top: 1px; }

.read-more {
    display: inline-flex; align-items: center; gap: 5px;
    font-family: 'Cinzel', serif; font-size: .6rem; font-weight: 600;
    letter-spacing: .12em; text-transform: uppercase;
    color: var(--gold); text-decoration: none;
    transition: gap .2s ease, color .2s ease;
}
.read-more:hover { gap: 9px; color: var(--gold-light); }
.read-more svg { width: 13px; height: 13px; }

/* ── EMPTY STATE ──────────────────────────────── */
.empty-state {
    text-align: center; padding: 80px 20px;
    display: flex; flex-direction: column; align-items: center; gap: 16px;
}
.empty-icon { font-size: 3rem; opacity: .2; }
.empty-title {
    font-family: 'Cinzel', serif; font-size: 1rem; font-weight: 700;
    color: var(--wd); letter-spacing: .06em;
}
.empty-sub { font-size: .88rem; color: var(--wf); font-style: italic; }

/* ── PAGINATION ───────────────────────────────── */
.pagination-wrap { display: flex; justify-content: center; }
.pagination-wrap nav { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; justify-content: center; }
.pagination-wrap .page-item a,
.pagination-wrap .page-item span {
    display: flex; align-items: center; justify-content: center;
    min-width: 38px; height: 38px; padding: 0 10px;
    border-radius: 8px; font-size: .8rem; font-weight: 500;
    font-family: 'Cinzel', serif; letter-spacing: .04em;
    text-decoration: none; border: 1px solid var(--bb);
    color: var(--wd); transition: all .2s ease;
    background: var(--bc);
}
.pagination-wrap .page-item.active span {
    background: var(--gold); color: var(--black); border-color: var(--gold);
    font-weight: 700;
}
.pagination-wrap .page-item a:hover { background: var(--gold-muted); border-color: rgba(212,160,23,.4); color: var(--gold); }
.pagination-wrap .page-item.disabled span { opacity: .3; cursor: not-allowed; }

/* ── RESPONSIVE ───────────────────────────────── */
@media (max-width: 900px) { .cards-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 560px) {
    .cards-grid { grid-template-columns: 1fr; }
    .blog-body { padding: 40px 16px 60px; }
}
</style>
@endpush

@section('content')

{{-- Hero --}}
<section class="blog-hero">
    <div class="blog-hero-bg"></div>
    <div class="blog-hero-orb"></div>
    <div class="blog-hero-orb"></div>
    <div class="blog-hero-ov"></div>
    <div class="blog-hero-content">
        <div class="blog-hero-eyebrow">Insights & Analysis</div>
        <h1 class="blog-hero-title">The <span>Knowledge</span> Vault</h1>
        <p class="blog-hero-sub">Deep dives on forex, finance and technology — written for those who think differently.</p>
    </div>
</section>

{{-- Blog Body --}}
<div class="blog-body">
    <div class="blog-container">

        @if($blogs->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📜</div>
            <div class="empty-title">No Articles Yet</div>
            <div class="empty-sub">New articles are being prepared. Check back soon.</div>
        </div>
        @else

        <div class="blog-section-label">
            <div class="bsl-line"></div>
            <div class="bsl-text">Latest Articles</div>
            <div class="bsl-line"></div>
        </div>

        <div class="cards-grid">
            @foreach($blogs as $blog)
            <article class="blog-card">
                <div class="card-img-wrap">
                    @if($blog->featured_image)
                        <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}" loading="lazy">
                    @else
                        <div class="card-img-placeholder">◈</div>
                    @endif
                    <div class="card-img-overlay"></div>
                    <span class="card-cat">{{ $blog->category ?? 'General' }}</span>
                </div>
                <div class="card-body">
                    <a href="{{ route('blog.show', $blog->slug) }}" class="card-title">{{ $blog->title }}</a>
                    @if($blog->excerpt)
                        <p class="card-excerpt">{{ Str::words($blog->excerpt, 18) }}</p>
                    @endif
                    <div class="card-divider"></div>
                    <div class="card-meta">
                        <div class="meta-author">
                            <div class="meta-av">{{ strtoupper(substr($blog->author ?? 'S', 0, 1)) }}</div>
                            <div>
                                <div class="meta-name">{{ $blog->author ?? 'Staff' }}</div>
                                <div class="meta-date">{{ $blog->published_at?->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="read-more">
                            Read
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        @if($blogs->hasPages())
        <div class="pagination-wrap">
            {{ $blogs->links() }}
        </div>
        @endif

        @endif
    </div>
</div>

@endsection
