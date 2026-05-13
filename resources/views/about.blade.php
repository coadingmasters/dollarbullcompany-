<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us — {{ config('app.name', 'CryptoOnly') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300&display=swap" rel="stylesheet">
<style>
:root{
    --gold:#D4A017;--gold-light:#F5C842;--gold-dark:#A07810;
    --gold-glow:rgba(212,160,23,.45);--gold-muted:rgba(212,160,23,.12);
    --black:#060606;--bc:#0d0d0d;--bb:#1a1a1a;
    --white:#fff;--wd:rgba(255,255,255,.75);--wf:rgba(255,255,255,.38);
    --ease:cubic-bezier(.16,1,.3,1);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{background:var(--black);color:var(--wd);font-family:'Crimson Pro',Georgia,serif;overflow-x:hidden}

/* ── FADE-UP UTILITY ── */
.fu{opacity:0;transform:translateY(44px);transition:opacity .8s ease,transform .8s var(--ease)}
.fu.in{opacity:1;transform:translateY(0)}
.fu-d1{transition-delay:.1s}.fu-d2{transition-delay:.2s}.fu-d3{transition-delay:.3s}.fu-d4{transition-delay:.4s}

/* ── HERO ── */
.ab-hero{
    position:relative;height:68vh;min-height:480px;
    display:flex;align-items:center;justify-content:center;
    overflow:hidden;margin-top:72px;
}
.ab-hero-bg{
    position:absolute;inset:0;
    background:url('https://images.unsplash.com/photo-1642790106117-e829e14a795f?w=1800&q=80') center/cover no-repeat;
    animation:hbgzoom 18s ease-in-out infinite alternate;
}
@keyframes hbgzoom{0%{transform:scale(1)}100%{transform:scale(1.07)}}
.ab-hero-ov{
    position:absolute;inset:0;
    background:linear-gradient(135deg,rgba(6,6,6,.9) 0%,rgba(6,6,6,.55) 50%,rgba(6,6,6,.8) 100%);
}
.ab-hero-ov::after{
    content:'';position:absolute;bottom:0;left:0;width:100%;height:3px;
    background:linear-gradient(90deg,transparent,var(--gold-dark) 20%,var(--gold-light) 50%,var(--gold-dark) 80%,transparent);
}
.ab-hero-content{position:relative;z-index:1;text-align:center;padding:0 20px;
    opacity:0;transform:translateY(30px);animation:slideUp .9s var(--ease) .2s forwards}
@keyframes slideUp{to{opacity:1;transform:translateY(0)}}
.ab-hero-eyebrow{
    display:inline-flex;align-items:center;gap:9px;
    font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.28em;
    text-transform:uppercase;color:var(--gold);margin-bottom:20px;
}
.ab-hero-eyebrow-dot{width:5px;height:5px;border-radius:50%;background:var(--gold);animation:blink 1.6s ease-in-out infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.1}}
.ab-hero-title{
    font-family:'Cinzel',serif;font-size:clamp(2.2rem,6vw,4.5rem);
    font-weight:900;color:var(--white);letter-spacing:.03em;line-height:1.1;margin-bottom:18px;
}
.ab-hero-title span{
    background:linear-gradient(135deg,var(--gold-light),var(--gold),var(--gold-dark));
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.ab-hero-sub{
    font-size:clamp(1rem,2vw,1.2rem);font-weight:300;font-style:italic;
    color:var(--wf);max-width:560px;margin:0 auto;line-height:1.8;
}

/* ── SECTION WRAPPER ── */
.section{padding:100px 40px;position:relative;overflow:hidden}
.section.alt{background:var(--bc)}
.container{max-width:1180px;margin:0 auto;position:relative;z-index:1}

/* Section heading */
.sec-head{text-align:center;margin-bottom:70px}
.sec-eyebrow{
    display:inline-flex;align-items:center;gap:10px;
    font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.28em;
    text-transform:uppercase;color:var(--gold);margin-bottom:18px;
}
.sec-eyebrow-line{display:block;width:28px;height:1px;background:linear-gradient(90deg,transparent,var(--gold))}
.sec-eyebrow-line.r{background:linear-gradient(90deg,var(--gold),transparent)}
.sec-title{
    font-family:'Cinzel',serif;font-size:clamp(1.8rem,3.5vw,2.8rem);
    font-weight:700;color:var(--white);line-height:1.2;letter-spacing:.02em;margin-bottom:16px;
}
.sec-title span{
    background:linear-gradient(135deg,var(--gold-light),var(--gold),var(--gold-dark));
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.sec-desc{
    font-size:1.05rem;font-weight:300;font-style:italic;
    color:var(--wf);max-width:520px;margin:0 auto;line-height:1.8;
}

/* ── STORY SECTION ── */
.story-grid{display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.story-img-wrap{position:relative}
.story-img-frame{position:relative;border-radius:3px;overflow:hidden}
.story-img-frame img{width:100%;height:460px;object-fit:cover;
    filter:brightness(.78) saturate(.82);
    transition:filter .5s,transform .7s var(--ease)}
.story-img-frame:hover img{filter:brightness(.65) saturate(.7);transform:scale(1.03)}
.story-img-frame::after{
    content:'';position:absolute;inset:0;
    background:linear-gradient(135deg,rgba(212,160,23,.1) 0%,transparent 55%);
    pointer-events:none;
}
.story-corner{position:absolute;width:48px;height:48px;border-color:var(--gold);border-style:solid;opacity:.6;transition:opacity .3s;pointer-events:none}
.story-img-wrap:hover .story-corner{opacity:1}
.story-corner.tl{top:-10px;left:-10px;border-width:2px 0 0 2px}
.story-corner.br{bottom:-10px;right:-10px;border-width:0 2px 2px 0}
.story-badge{
    position:absolute;bottom:24px;left:-24px;
    background:var(--bc);border:1px solid var(--bb);border-left:3px solid var(--gold);
    padding:16px 20px;border-radius:2px;box-shadow:0 8px 32px rgba(0,0,0,.6);z-index:2;
}
.story-badge-val{font-family:'Cinzel',serif;font-size:1.8rem;font-weight:700;color:var(--gold);line-height:1}
.story-badge-lbl{font-family:'Cinzel',serif;font-size:.58rem;letter-spacing:.2em;text-transform:uppercase;color:var(--wf);margin-top:4px}
.story-text{display:flex;flex-direction:column;gap:22px}
.story-eyebrow{display:inline-flex;align-items:center;gap:10px;font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.28em;text-transform:uppercase;color:var(--gold)}
.story-eyebrow-line{display:block;width:28px;height:1px;background:linear-gradient(90deg,transparent,var(--gold))}
.story-title{font-family:'Cinzel',serif;font-size:clamp(1.7rem,3vw,2.5rem);font-weight:700;color:var(--white);line-height:1.2;letter-spacing:.02em}
.story-title span{background:linear-gradient(135deg,var(--gold-light),var(--gold),var(--gold-dark));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.story-divider{width:48px;height:2px;background:linear-gradient(90deg,var(--gold),transparent);border:none}
.story-desc{font-size:1.05rem;font-weight:300;font-style:italic;color:var(--wf);line-height:1.85}
.story-points{display:flex;flex-direction:column;gap:12px}
.story-point{
    display:flex;align-items:flex-start;gap:14px;padding:14px 16px;
    border:1px solid var(--bb);border-radius:2px;background:rgba(212,160,23,.03);
    transition:border-color .3s,background .3s;
}
.story-point:hover{border-color:rgba(212,160,23,.35);background:rgba(212,160,23,.06)}
.sp-icon{
    width:30px;height:30px;flex-shrink:0;border-radius:2px;
    background:var(--gold-muted);border:1px solid rgba(212,160,23,.28);
    display:flex;align-items:center;justify-content:center;color:var(--gold);
    font-size:.75rem;font-weight:700;transition:background .3s;
}
.story-point:hover .sp-icon{background:rgba(212,160,23,.22)}
.sp-title{font-family:'Cinzel',serif;font-size:.76rem;font-weight:700;color:var(--white);letter-spacing:.06em;text-transform:uppercase;margin-bottom:3px}
.sp-text{font-size:.92rem;font-weight:300;color:var(--wf);line-height:1.65}

/* ── STATS BAND ── */
.stats-band{
    background:var(--bc);border-top:1px solid var(--bb);border-bottom:1px solid var(--bb);
    padding:60px 40px;position:relative;overflow:hidden;
}
.stats-band::before{
    content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse at 50% 0%,rgba(212,160,23,.07) 0%,transparent 65%);
    pointer-events:none;
}
.stats-band-inner{
    max-width:1000px;margin:0 auto;
    display:grid;grid-template-columns:repeat(4,1fr);gap:0;
    position:relative;z-index:1;
}
.sb-item{text-align:center;padding:12px 20px;border-right:1px solid var(--bb)}
.sb-item:last-child{border-right:none}
.sb-val{
    font-family:'Cinzel',serif;font-size:clamp(1.8rem,4vw,2.6rem);font-weight:700;
    background:linear-gradient(135deg,var(--gold-light),var(--gold));
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    line-height:1;display:block;
}
.sb-lbl{font-family:'Cinzel',serif;font-size:.62rem;letter-spacing:.18em;text-transform:uppercase;color:var(--wf);margin-top:8px;display:block}

/* ── TEAM CARDS ── */
.team-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px}
.team-card{
    background:var(--bc);border:1px solid var(--bb);border-radius:3px;overflow:hidden;
    opacity:0;transform:translateY(40px);
    transition:opacity .7s ease,transform .7s var(--ease),border-color .3s,box-shadow .3s;
}
.team-card.in{opacity:1;transform:translateY(0)}
.team-card:hover{border-color:rgba(212,160,23,.4);box-shadow:0 20px 50px rgba(0,0,0,.6),0 0 30px rgba(212,160,23,.08);transform:translateY(-8px)!important}
.tc-img-wrap{position:relative;height:220px;overflow:hidden}
.tc-img-wrap img{width:100%;height:100%;object-fit:cover;object-position:top;filter:brightness(.75) saturate(.8);transition:transform .7s var(--ease),filter .5s}
.team-card:hover .tc-img-wrap img{transform:scale(1.08);filter:brightness(.6) saturate(.7)}
.tc-img-overlay{
    position:absolute;inset:0;
    background:linear-gradient(to bottom,transparent 40%,rgba(13,13,13,1) 100%);
    z-index:1;
}
.tc-social{
    position:absolute;top:12px;right:12px;z-index:2;
    display:flex;flex-direction:column;gap:6px;
    opacity:0;transform:translateX(10px);transition:opacity .3s,transform .3s var(--ease);
}
.team-card:hover .tc-social{opacity:1;transform:translateX(0)}
.tc-soc-btn{
    width:30px;height:30px;border-radius:2px;
    background:rgba(6,6,6,.7);border:1px solid rgba(212,160,23,.4);
    display:flex;align-items:center;justify-content:center;
    color:var(--gold);text-decoration:none;font-size:.7rem;
    backdrop-filter:blur(6px);transition:background .25s;
}
.tc-soc-btn:hover{background:var(--gold);color:#060606}
.tc-body{padding:18px 20px 22px;position:relative}
.tc-body::before{
    content:'';position:absolute;top:0;left:20px;right:20px;height:1px;
    background:linear-gradient(90deg,transparent,var(--gold),transparent);
    transform:scaleX(0);transform-origin:left;transition:transform .5s var(--ease);
}
.team-card:hover .tc-body::before{transform:scaleX(1)}
.tc-name{font-family:'Cinzel',serif;font-size:.92rem;font-weight:700;color:var(--white);letter-spacing:.04em;margin-bottom:4px;transition:color .3s}
.team-card:hover .tc-name{color:var(--gold-light)}
.tc-role{font-family:'Cinzel',serif;font-size:.58rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold);opacity:.75;margin-bottom:10px}
.tc-bio{font-size:.88rem;font-weight:300;color:var(--wf);line-height:1.65}

/* ── VALUES GRID ── */
.values-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
.value-card{
    background:var(--bc);border:1px solid var(--bb);border-radius:3px;
    padding:32px 28px;position:relative;overflow:hidden;
    opacity:0;transform:translateY(36px);
    transition:opacity .7s ease,transform .7s var(--ease),border-color .3s,box-shadow .3s;
}
.value-card.in{opacity:1;transform:translateY(0)}
.value-card::before{
    content:'';position:absolute;inset:0;
    background:linear-gradient(135deg,var(--gold-muted),transparent 55%);
    opacity:0;transition:opacity .35s;
}
.value-card:hover{border-color:rgba(212,160,23,.4);box-shadow:0 16px 44px rgba(0,0,0,.55);transform:translateY(-6px)!important}
.value-card:hover::before{opacity:1}
.vc-icon{
    width:52px;height:52px;border-radius:3px;margin-bottom:20px;
    background:var(--gold-muted);border:1px solid rgba(212,160,23,.3);
    display:flex;align-items:center;justify-content:center;
    transition:background .3s,transform .4s var(--ease);position:relative;z-index:1;
}
.vc-icon svg{width:22px;height:22px;stroke:var(--gold);fill:none;stroke-width:1.6}
.value-card:hover .vc-icon{background:var(--gold);transform:rotate(8deg) scale(1.1)}
.value-card:hover .vc-icon svg{stroke:#060606}
.vc-title{font-family:'Cinzel',serif;font-size:.88rem;font-weight:700;color:var(--white);letter-spacing:.08em;text-transform:uppercase;margin-bottom:12px;position:relative;z-index:1;transition:color .3s}
.value-card:hover .vc-title{color:var(--gold-light)}
.vc-text{font-size:.95rem;font-weight:300;color:var(--wf);line-height:1.75;position:relative;z-index:1}

/* ── TIMELINE ── */
.timeline{position:relative;max-width:760px;margin:0 auto}
.timeline::before{
    content:'';position:absolute;left:50%;transform:translateX(-50%);
    top:0;bottom:0;width:1px;
    background:linear-gradient(180deg,transparent,var(--gold) 15%,var(--gold) 85%,transparent);
    opacity:.4;
}
.tl-item{
    display:flex;gap:40px;align-items:flex-start;margin-bottom:48px;
    opacity:0;transform:translateY(28px);
    transition:opacity .7s ease,transform .7s var(--ease);
}
.tl-item.in{opacity:1;transform:translateY(0)}
.tl-item:nth-child(odd){flex-direction:row}
.tl-item:nth-child(even){flex-direction:row-reverse}
.tl-content{
    flex:1;background:var(--bc);border:1px solid var(--bb);border-radius:3px;
    padding:22px 24px;position:relative;
    transition:border-color .3s,box-shadow .3s;
}
.tl-content:hover{border-color:rgba(212,160,23,.35);box-shadow:0 8px 28px rgba(0,0,0,.5)}
.tl-year{
    font-family:'Cinzel',serif;font-size:.62rem;font-weight:700;letter-spacing:.18em;
    text-transform:uppercase;color:var(--gold);margin-bottom:8px;
}
.tl-title-text{font-family:'Cinzel',serif;font-size:.9rem;font-weight:700;color:var(--white);letter-spacing:.05em;margin-bottom:8px}
.tl-desc{font-size:.9rem;font-weight:300;color:var(--wf);line-height:1.7}
.tl-dot-wrap{
    flex-shrink:0;width:40px;display:flex;flex-direction:column;align-items:center;padding-top:18px;
}
.tl-dot{
    width:14px;height:14px;border-radius:50%;
    background:var(--gold);border:2px solid var(--black);
    box-shadow:0 0 12px var(--gold-glow);
    animation:dotpulse 2s ease-in-out infinite;
}
@keyframes dotpulse{0%,100%{box-shadow:0 0 6px var(--gold-glow)}50%{box-shadow:0 0 18px var(--gold-light)}}

/* ── CTA BAND ── */
.cta-band{
    background:var(--bc);border-top:1px solid var(--bb);
    padding:80px 40px;text-align:center;position:relative;overflow:hidden;
}
.cta-band::before{
    content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse at 50% 50%,rgba(212,160,23,.07) 0%,transparent 65%);
    pointer-events:none;
}
.cta-band-content{position:relative;z-index:1}
.cta-title{font-family:'Cinzel',serif;font-size:clamp(1.6rem,3.5vw,2.6rem);font-weight:700;color:var(--white);letter-spacing:.03em;margin-bottom:16px}
.cta-title span{background:linear-gradient(135deg,var(--gold-light),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.cta-sub{font-size:1.1rem;font-weight:300;font-style:italic;color:var(--wf);margin-bottom:36px;max-width:480px;margin-left:auto;margin-right:auto}
.cta-btns{display:flex;justify-content:center;gap:14px;flex-wrap:wrap}
.btn-gold{
    display:inline-flex;align-items:center;gap:10px;padding:13px 32px;
    background:linear-gradient(135deg,var(--gold-dark),var(--gold),var(--gold-light));
    color:#060606;font-family:'Cinzel',serif;font-size:.7rem;font-weight:700;
    letter-spacing:.14em;text-transform:uppercase;text-decoration:none;
    border-radius:2px;box-shadow:0 4px 22px rgba(212,160,23,.35);
    transition:box-shadow .3s,transform .2s;border:none;cursor:pointer;
}
.btn-gold:hover{box-shadow:0 8px 36px rgba(212,160,23,.6);transform:translateY(-2px)}
.btn-gold svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2}
.btn-outline{
    display:inline-flex;align-items:center;gap:10px;padding:12px 30px;
    border:1px solid rgba(212,160,23,.5);border-radius:2px;
    background:rgba(212,160,23,.07);color:var(--gold-light);
    font-family:'Cinzel',serif;font-size:.7rem;font-weight:600;
    letter-spacing:.14em;text-transform:uppercase;text-decoration:none;
    transition:border-color .3s,background .3s,transform .2s;
}
.btn-outline:hover{border-color:var(--gold-light);background:rgba(212,160,23,.15);transform:translateY(-2px)}

/* ── RESPONSIVE ── */
@media(max-width:1050px){.team-grid{grid-template-columns:repeat(2,1fr)}.values-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:860px){
    .story-grid{grid-template-columns:1fr;gap:44px}
    .story-img-frame img{height:300px}.story-badge{left:0}
    .stats-band-inner{grid-template-columns:repeat(2,1fr)}
    .sb-item{border-bottom:1px solid var(--bb);border-right:none}
    .sb-item:nth-child(odd){border-right:1px solid var(--bb)}
    .timeline::before{left:20px}
    .tl-item,.tl-item:nth-child(even){flex-direction:row}
    .tl-dot-wrap{align-items:flex-start;padding-left:6px}
    .section{padding:72px 20px}
    .cta-band{padding:60px 20px}
    .stats-band{padding:44px 20px}
}
@media(max-width:640px){
    .team-grid{grid-template-columns:1fr}.values-grid{grid-template-columns:1fr}
    .ab-hero{height:75vh}
    .stats-band-inner{grid-template-columns:1fr 1fr}
}
</style>
</head>
<body>

@include('layouts.partials.header')

{{-- ════════ HERO ════════ --}}
<section class="ab-hero" aria-label="About Us Hero">
    <div class="ab-hero-bg"></div>
    <div class="ab-hero-ov"></div>
    <div class="ab-hero-content">
        <div class="ab-hero-eyebrow">
            <span class="ab-hero-eyebrow-dot"></span>
            Our Story
        </div>
        <h1 class="ab-hero-title">
            Built by Traders,<br><span>For Traders</span>
        </h1>
        <p class="ab-hero-sub">We started with a simple belief — every serious investor deserves institutional-grade intelligence, community, and tools.</p>
    </div>
</section>

{{-- ════════ STORY ════════ --}}
<section class="section">
    <div class="container">
        <div class="story-grid">
            <div class="story-img-wrap fu">
                <div class="story-img-frame">
                    <img src="https://images.unsplash.com/photo-1642790106117-e829e14a795f?w=900&q=80" alt="CryptoOnly founding team" loading="lazy">
                </div>
                <div class="story-corner tl"></div>
                <div class="story-corner br"></div>
                <div class="story-badge">
                    <div class="story-badge-val">2019</div>
                    <div class="story-badge-lbl">Est. Founded</div>
                </div>
            </div>
            <div class="story-text fu fu-d2">
                <div class="story-eyebrow"><span class="story-eyebrow-line"></span>Who We Are</div>
                <h2 class="story-title">A Platform Born from<br><span>Real Market Experience</span></h2>
                <div class="story-divider"></div>
                <p class="story-desc">CryptoOnly was founded in 2019 by a team of ex-institutional traders and DeFi researchers who were tired of seeing retail investors get left behind. We built the community, tools, and education we wished we had when we started.</p>
                <div class="story-points">
                    <div class="story-point">
                        <div class="sp-icon">✦</div>
                        <div><div class="sp-title">Our Mission</div><div class="sp-text">To democratise crypto wealth by equipping every member with knowledge, signals, and a thriving peer community.</div></div>
                    </div>
                    <div class="story-point">
                        <div class="sp-icon">◈</div>
                        <div><div class="sp-title">Our Edge</div><div class="sp-text">A team of 20+ certified analysts, ex-institutional traders, and DeFi researchers working daily on your behalf.</div></div>
                    </div>
                    <div class="story-point">
                        <div class="sp-icon">▲</div>
                        <div><div class="sp-title">Our Promise</div><div class="sp-text">Transparency, accountability, and results — everything we publish is backed by real data and real trades.</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════ STATS ════════ --}}
<div class="stats-band">
    <div class="stats-band-inner">
        <div class="sb-item fu"><span class="sb-val">320K+</span><span class="sb-lbl">Active Members</span></div>
        <div class="sb-item fu fu-d1"><span class="sb-val">$4.2B+</span><span class="sb-lbl">Trading Volume</span></div>
        <div class="sb-item fu fu-d2"><span class="sb-val">180+</span><span class="sb-lbl">Crypto Assets</span></div>
        <div class="sb-item fu fu-d3"><span class="sb-val">60+</span><span class="sb-lbl">Countries</span></div>
    </div>
</div>

{{-- ════════ TEAM ════════ --}}
<section class="section alt">
    <div class="container">
        <div class="sec-head fu">
            <div class="sec-eyebrow"><span class="sec-eyebrow-line"></span>The People<span class="sec-eyebrow-line r"></span></div>
            <h2 class="sec-title">Meet the <span>Expert Team</span></h2>
            <p class="sec-desc">Certified analysts, former institutional traders, and DeFi specialists — all working for you.</p>
        </div>
        <div class="team-grid">
            @php
            $team = [
                ['img'=>'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80','name'=>'Badar Tanvir','role'=>'Founder & CEO','bio'=>'Ex-institutional trader with 12 years in derivatives markets. Founded CryptoOnly to bridge the gap between retail and institutional crypto.'],
                ['img'=>'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&q=80','name'=>'Sara Malik','role'=>'Head of Research','bio'=>'Certified Blockchain Expert and DeFi protocol researcher. Leads our signal generation and market analysis division.'],
                ['img'=>'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&q=80','name'=>'Omar Raza','role'=>'Lead Analyst','bio'=>'Technical analysis specialist with expertise in Elliott Wave, Smart Money Concepts, and liquidity-based trading strategies.'],
                ['img'=>'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&q=80','name'=>'Fatima Ali','role'=>'Education Director','bio'=>'Former university lecturer turned crypto educator. Designed all 40+ courses on the platform with a focus on practical, results-driven learning.'],
            ];
            @endphp
            @foreach($team as $i => $member)
            <div class="team-card" style="transition-delay:{{ $i * 0.1 }}s" data-anim>
                <div class="tc-img-wrap">
                    <img src="{{ $member['img'] }}" alt="{{ $member['name'] }}" loading="lazy">
                    <div class="tc-img-overlay"></div>
                    <div class="tc-social">
                        <a href="#" class="tc-soc-btn" aria-label="Twitter">𝕏</a>
                        <a href="#" class="tc-soc-btn" aria-label="LinkedIn">in</a>
                    </div>
                </div>
                <div class="tc-body">
                    <div class="tc-name">{{ $member['name'] }}</div>
                    <div class="tc-role">{{ $member['role'] }}</div>
                    <p class="tc-bio">{{ $member['bio'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════ VALUES ════════ --}}
<section class="section">
    <div class="container">
        <div class="sec-head fu">
            <div class="sec-eyebrow"><span class="sec-eyebrow-line"></span>What We Stand For<span class="sec-eyebrow-line r"></span></div>
            <h2 class="sec-title">Our Core <span>Values</span></h2>
            <p class="sec-desc">Every decision we make is guided by these principles — they are non-negotiable.</p>
        </div>
        <div class="values-grid">
            @php
            $values = [
                ['icon'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>','title'=>'Trust & Transparency','text'=>'Every signal, every call, every result is published publicly. We hold ourselves accountable to the community — always.','d'=>0],
                ['icon'=>'<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>','title'=>'Speed & Accuracy','text'=>'Markets move fast. Our team operates 24/7 to deliver real-time signals and analysis before opportunities disappear.','d'=>1],
                ['icon'=>'<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>','title'=>'Community First','text'=>'CryptoOnly is built on peer power. 320,000 members share insights, hold each other accountable, and grow together.','d'=>2],
                ['icon'=>'<path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3.33 1.67 8.67 1.67 12 0v-5"/>','title'=>'Education Over Hype','text'=>'We teach principles, not trends. Our structured curriculum is designed to make you independently profitable — not dependent on us.','d'=>0],
                ['icon'=>'<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>','title'=>'Real Returns','text'=>'Everything we do is measured by one metric: member profitability. No vanity stats — just verified results that speak for themselves.','d'=>1],
                ['icon'=>'<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>','title'=>'Security & Privacy','text'=>'Your data and funds are protected by enterprise-grade security. We never sell member data — your privacy is a fundamental right.','d'=>2],
            ];
            @endphp
            @foreach($values as $v)
            <div class="value-card" style="transition-delay:{{ $v['d'] * 0.1 }}s" data-anim>
                <div class="vc-icon"><svg viewBox="0 0 24 24">{!! $v['icon'] !!}</svg></div>
                <div class="vc-title">{{ $v['title'] }}</div>
                <p class="vc-text">{{ $v['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════ TIMELINE ════════ --}}
<section class="section alt">
    <div class="container">
        <div class="sec-head fu">
            <div class="sec-eyebrow"><span class="sec-eyebrow-line"></span>Our Journey<span class="sec-eyebrow-line r"></span></div>
            <h2 class="sec-title">From Zero to <span>Global Platform</span></h2>
            <p class="sec-desc">Five years of relentless building, learning, and growing alongside our community.</p>
        </div>
        <div class="timeline">
            @php
            $milestones = [
                ['year'=>'2019','title'=>'CryptoOnly Founded','desc'=>'Started as a small Telegram group of 12 traders sharing signals. Incorporated as a company within 6 months.'],
                ['year'=>'2020','title'=>'10,000 Members','desc'=>'Launched paid courses and the Premium Group. Hit 10K members during the DeFi Summer boom.'],
                ['year'=>'2021','title'=>'P2P Platform Launch','desc'=>'Launched our escrow-secured P2P trading platform. Processed over $200M in trades in the first year.'],
                ['year'=>'2022','title'=>'Live Sessions & $1B Volume','desc'=>'Introduced weekly live trading sessions with our analyst team. Community trading volume crossed $1B.'],
                ['year'=>'2023','title'=>'Global Expansion','desc'=>'Expanded to 60+ countries, launched in Arabic & Urdu, onboarded 5 new senior analysts.'],
                ['year'=>'2024','title'=>'320K Members & $4.2B Volume','desc'=>'Became one of the largest crypto education and trading communities in the world. Still growing.'],
            ];
            @endphp
            @foreach($milestones as $m)
            <div class="tl-item" data-anim>
                <div class="tl-content">
                    <div class="tl-year">{{ $m['year'] }}</div>
                    <div class="tl-title-text">{{ $m['title'] }}</div>
                    <p class="tl-desc">{{ $m['desc'] }}</p>
                </div>
                <div class="tl-dot-wrap"><div class="tl-dot"></div></div>
                <div style="flex:1"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════ CTA ════════ --}}
<section class="cta-band fu">
    <div class="cta-band-content">
        <h2 class="cta-title">Ready to Join <span>320,000+ Traders?</span></h2>
        <p class="cta-sub">Start your journey today — your first 7 days in the Premium Group are on us.</p>
        <div class="cta-btns">
            <a href="{{ url('/courses') }}" class="btn-gold">
                Explore Courses
                <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ url('/contact') }}" class="btn-outline">Contact Us</a>
        </div>
    </div>
</section>

@include('layouts.partials.footer')

<script>
(function(){
    var all = document.querySelectorAll('.fu, [data-anim]');
    if(!('IntersectionObserver' in window)){all.forEach(function(e){e.classList.add('in')});return}
    var io = new IntersectionObserver(function(entries){
        entries.forEach(function(en){
            if(en.isIntersecting){en.target.classList.add('in');io.unobserve(en.target)}
        });
    },{threshold:.1});
    all.forEach(function(e){io.observe(e)});
})();
</script>
</body>
</html>