@extends('layouts.frontend')
@section('title', $blog->title . ' — ' . config('app.name'))

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

/* ── HERO ───────────────────────────────────── */
.post-hero {
    position: relative; width: 100%;
    height: clamp(300px, 42vw, 520px);
    overflow: hidden; background: var(--black);
}
.post-hero-img {
    width: 100%; height: 100%; object-fit: cover;
    opacity: .35;
    animation: heroZoom 20s ease-in-out infinite alternate;
}
@keyframes heroZoom { 0%{transform:scale(1)} 100%{transform:scale(1.06)} }

.post-hero-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, #0a0a0a 0%, #141414 50%, #0a0a0a 100%);
}
.post-hero-ov {
    position: absolute; inset: 0;
    background: linear-gradient(0deg, rgba(6,6,6,.97) 0%, rgba(6,6,6,.5) 50%, rgba(6,6,6,.7) 100%);
}
.post-hero-ov::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--gold-dark) 20%, var(--gold-light) 50%, var(--gold-dark) 80%, transparent);
}

.post-hero-content {
    position: absolute; inset: 0;
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 44px 48px;
    opacity: 0; animation: heroContentIn .8s var(--ease) .1s forwards;
}
@keyframes heroContentIn { to { opacity: 1; } }

.post-cat {
    display: inline-flex; align-items: center; gap: 7px;
    font-family: 'Cinzel', serif; font-size: .55rem; letter-spacing: .22em;
    text-transform: uppercase; color: var(--gold);
    border: 1px solid rgba(212,160,23,.35); border-radius: 4px;
    padding: 5px 12px; margin-bottom: 16px; width: fit-content;
    background: rgba(6,6,6,.6); backdrop-filter: blur(4px);
}
.post-cat::before { content: '◈'; font-size: .65rem; }

.post-hero-title {
    font-family: 'Cinzel', serif;
    font-size: clamp(1.5rem, 3.5vw, 2.6rem);
    font-weight: 900; color: var(--white);
    line-height: 1.2; letter-spacing: .02em;
    max-width: 860px;
    text-shadow: 0 2px 20px rgba(0,0,0,.8);
}

/* ── POST WRAP ──────────────────────────────── */
.post-wrap {
    background: var(--black);
    padding: 0 24px 80px;
}
.post-inner {
    max-width: 800px; margin: 0 auto; padding-top: 44px;
    opacity: 0; animation: wrapIn .7s var(--ease) .3s forwards;
}
@keyframes wrapIn { to { opacity: 1; } }

/* Back link */
.back-link {
    display: inline-flex; align-items: center; gap: 8px;
    font-family: 'Cinzel', serif; font-size: .6rem; font-weight: 600;
    letter-spacing: .15em; text-transform: uppercase;
    color: var(--gold); text-decoration: none; margin-bottom: 32px;
    transition: gap .2s ease, color .2s ease;
}
.back-link:hover { gap: 12px; color: var(--gold-light); }
.back-link svg { width: 13px; height: 13px; }

/* Meta bar */
.post-meta {
    display: flex; align-items: center; flex-wrap: wrap; gap: 18px;
    padding-bottom: 28px; margin-bottom: 36px;
    border-bottom: 1px solid var(--bb);
    position: relative;
}
.post-meta::after {
    content: ''; position: absolute; bottom: -1px; left: 0; width: 60px; height: 1px;
    background: var(--gold); opacity: .6;
}
.meta-author { display: flex; align-items: center; gap: 10px; }
.meta-av {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, var(--gold-dark), var(--gold));
    display: flex; align-items: center; justify-content: center;
    font-family: 'Cinzel', serif; font-size: .75rem; font-weight: 700;
    color: var(--black); flex-shrink: 0;
}
.meta-info .author-name { font-size: .84rem; font-weight: 600; color: var(--wd); font-family: 'Cinzel', serif; letter-spacing: .04em; }
.meta-info .post-date { font-size: .76rem; color: var(--wf); margin-top: 2px; font-style: italic; }
.meta-sep { width: 1px; height: 22px; background: var(--bb); }
.meta-read {
    display: flex; align-items: center; gap: 6px;
    font-family: 'Cinzel', serif; font-size: .62rem; letter-spacing: .1em;
    text-transform: uppercase; color: var(--gold); opacity: .7;
}
.meta-read svg { width: 14px; height: 14px; }

/* ── PROSE ──────────────────────────────────── */
.post-content {
    font-size: 1.05rem; line-height: 1.85;
    color: var(--wd); font-family: 'Crimson Pro', Georgia, serif;
}
.post-content h1 { font-family:'Cinzel',serif; font-size:1.8rem; font-weight:700; color:var(--white); margin:1.5em 0 .5em; letter-spacing:.02em; }
.post-content h2 { font-family:'Cinzel',serif; font-size:1.35rem; font-weight:700; color:var(--white); margin:1.4em 0 .5em; letter-spacing:.02em; }
.post-content h3 { font-family:'Cinzel',serif; font-size:1.1rem; font-weight:600; color:var(--wd); margin:1.2em 0 .4em; }
.post-content p  { margin-bottom: 1.2em; }
.post-content ul, .post-content ol { padding-left: 1.6em; margin-bottom: 1.2em; }
.post-content li { margin-bottom: .5em; }
.post-content a  { color: var(--gold); text-decoration: underline; text-underline-offset: 3px; text-decoration-color: rgba(212,160,23,.4); transition: color .2s, text-decoration-color .2s; }
.post-content a:hover { color: var(--gold-light); text-decoration-color: var(--gold); }
.post-content strong { color: var(--white); font-weight: 600; }
.post-content em { color: rgba(255,255,255,.6); }
.post-content blockquote {
    border-left: 3px solid var(--gold);
    padding: 14px 22px; margin: 1.6em 0;
    background: var(--gold-muted); border-radius: 0 8px 8px 0;
    color: rgba(255,255,255,.6); font-style: italic;
}
.post-content pre {
    background: #0a0a0a; color: #e2e8f0;
    border: 1px solid var(--bb); border-radius: 10px;
    padding: 20px 22px; margin: 1.5em 0; overflow-x: auto; font-size: .85rem;
}
.post-content code {
    background: #111; border: 1px solid var(--bb);
    border-radius: 4px; padding: 2px 7px; font-size: .85rem; color: var(--gold-light);
}
.post-content pre code { background: none; border: none; padding: 0; color: inherit; }
.post-content hr { border: none; border-top: 1px solid var(--bb); margin: 2.2em 0; position: relative; }
.post-content hr::after { content: '◈'; position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: var(--black); padding: 0 12px; color: var(--gold); font-size: .7rem; opacity: .5; }
.post-content img { max-width: 100%; border-radius: 10px; margin: 1.2em 0; opacity: .85; }

/* ── PREV / NEXT ────────────────────────────── */
.post-nav {
    display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
    margin-top: 56px; padding-top: 36px;
    border-top: 1px solid var(--bb);
}
.post-nav-card {
    background: var(--bc); border: 1px solid var(--bb);
    border-radius: 12px; padding: 20px 22px;
    text-decoration: none; transition: all .25s var(--ease);
    display: flex; flex-direction: column; gap: 8px;
    position: relative; overflow: hidden;
}
.post-nav-card::before {
    content: ''; position: absolute; inset: 0;
    background: var(--gold-muted); opacity: 0; transition: opacity .25s;
}
.post-nav-card:hover { border-color: rgba(212,160,23,.35); transform: translateY(-2px); box-shadow: 0 12px 30px rgba(0,0,0,.5); }
.post-nav-card:hover::before { opacity: 1; }
.post-nav-card.next { text-align: right; }

.nav-dir {
    display: flex; align-items: center; gap: 6px;
    font-family: 'Cinzel', serif; font-size: .55rem;
    letter-spacing: .2em; text-transform: uppercase; color: var(--gold); opacity: .7;
    position: relative; z-index: 1;
}
.nav-dir svg { width: 11px; height: 11px; }
.post-nav-card.next .nav-dir { justify-content: flex-end; }

.nav-title {
    font-family: 'Cinzel', serif; font-size: .82rem; font-weight: 600;
    color: var(--wd); line-height: 1.4;
    position: relative; z-index: 1;
    transition: color .2s;
}
.post-nav-card:hover .nav-title { color: var(--white); }

@media (max-width: 640px) {
    .post-nav { grid-template-columns: 1fr; }
    .post-hero-content { padding: 28px 24px; }
    .post-inner { padding-top: 32px; }
}
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="post-hero">
    @if($blog->featured_image)
        <img class="post-hero-img" src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}">
    @else
        <div class="post-hero-placeholder"></div>
    @endif
    <div class="post-hero-ov"></div>
    <div class="post-hero-content">
        <span class="post-cat">{{ $blog->category ?? 'General' }}</span>
        <h1 class="post-hero-title">{{ $blog->title }}</h1>
    </div>
</div>

<div class="post-wrap">
    <div class="post-inner">

        <a href="{{ route('blog.index') }}" class="back-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Blog
        </a>

        {{-- Meta --}}
        <div class="post-meta">
            <div class="meta-author">
                <div class="meta-av">{{ strtoupper(substr($blog->author ?? 'S', 0, 1)) }}</div>
                <div class="meta-info">
                    <div class="author-name">{{ $blog->author ?? 'Staff' }}</div>
                    <div class="post-date">{{ $blog->published_at?->format('F d, Y') }}</div>
                </div>
            </div>
            <div class="meta-sep"></div>
            @php
                $wordCount = str_word_count(strip_tags($blog->body ?? ''));
                $readMins  = max(1, (int) ceil($wordCount / 200));
            @endphp
            <div class="meta-read">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $readMins }} min read
            </div>
        </div>

        {{-- Body --}}
        <div class="post-content">
            {!! $blog->body !!}
        </div>

        {{-- Prev / Next --}}
        @if($prev || $next)
        <div class="post-nav">
            @if($prev)
            <a href="{{ route('blog.show', $prev->slug) }}" class="post-nav-card">
                <span class="nav-dir">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Previous
                </span>
                <span class="nav-title">{{ Str::limit($prev->title, 60) }}</span>
            </a>
            @else
            <div></div>
            @endif

            @if($next)
            <a href="{{ route('blog.show', $next->slug) }}" class="post-nav-card next">
                <span class="nav-dir">
                    Next
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </span>
                <span class="nav-title">{{ Str::limit($next->title, 60) }}</span>
            </a>
            @endif
        </div>
        @endif

    </div>
</div>

@endsection
