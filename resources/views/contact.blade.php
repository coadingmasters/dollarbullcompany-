<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us — {{ config('app.name', 'CryptoOnly') }}</title>
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
    --green:#22c55e;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{background:var(--black);color:var(--wd);font-family:'Crimson Pro',Georgia,serif;overflow-x:hidden}

/* ── FADE-UP ── */
.fu{opacity:0;transform:translateY(40px);transition:opacity .75s ease,transform .75s var(--ease)}
.fu.in{opacity:1;transform:translateY(0)}
.fu-d1{transition-delay:.1s}.fu-d2{transition-delay:.2s}.fu-d3{transition-delay:.3s}

/* ── HERO ── */
.ct-hero{
    position:relative;height:52vh;min-height:380px;
    display:flex;align-items:center;justify-content:center;
    overflow:hidden;margin-top:72px;
}
.ct-hero-bg{
    position:absolute;inset:0;
    background:url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1800&q=80') center/cover no-repeat;
    animation:ctbgz 18s ease-in-out infinite alternate;
}
@keyframes ctbgz{0%{transform:scale(1)}100%{transform:scale(1.06)}}
.ct-hero-ov{
    position:absolute;inset:0;
    background:linear-gradient(135deg,rgba(6,6,6,.88) 0%,rgba(6,6,6,.5) 50%,rgba(6,6,6,.8) 100%);
}
.ct-hero-ov::after{
    content:'';position:absolute;bottom:0;left:0;width:100%;height:3px;
    background:linear-gradient(90deg,transparent,var(--gold-dark) 20%,var(--gold-light) 50%,var(--gold-dark) 80%,transparent);
}
.ct-hero-content{
    position:relative;z-index:1;text-align:center;padding:0 20px;
    opacity:0;transform:translateY(28px);animation:slideUp .85s var(--ease) .2s forwards;
}
@keyframes slideUp{to{opacity:1;transform:translateY(0)}}
.ct-eyebrow{display:inline-flex;align-items:center;gap:9px;font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.28em;text-transform:uppercase;color:var(--gold);margin-bottom:18px}
.ct-dot{width:5px;height:5px;border-radius:50%;background:var(--gold);animation:blink 1.6s ease-in-out infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.1}}
.ct-hero-title{font-family:'Cinzel',serif;font-size:clamp(2rem,5.5vw,4rem);font-weight:900;color:var(--white);letter-spacing:.03em;line-height:1.1;margin-bottom:16px}
.ct-hero-title span{background:linear-gradient(135deg,var(--gold-light),var(--gold),var(--gold-dark));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.ct-hero-sub{font-size:clamp(1rem,2vw,1.15rem);font-weight:300;font-style:italic;color:var(--wf);max-width:500px;margin:0 auto}

/* ── MAIN SECTION ── */
.ct-main{padding:100px 40px;position:relative;overflow:hidden}
.ct-main::before{content:'';position:absolute;top:-150px;left:50%;transform:translateX(-50%);width:700px;height:400px;background:radial-gradient(ellipse,rgba(212,160,23,.06) 0%,transparent 70%);pointer-events:none}
.ct-grid{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:1fr 1.1fr;gap:64px;align-items:start;position:relative;z-index:1}

/* ── LEFT INFO ── */
.ct-info{display:flex;flex-direction:column;gap:28px}
.ct-sec-eyebrow{display:inline-flex;align-items:center;gap:10px;font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.28em;text-transform:uppercase;color:var(--gold)}
.ct-sec-eyebrow-line{display:block;width:28px;height:1px;background:linear-gradient(90deg,transparent,var(--gold))}
.ct-sec-title{font-family:'Cinzel',serif;font-size:clamp(1.7rem,3vw,2.5rem);font-weight:700;color:var(--white);line-height:1.2;letter-spacing:.02em}
.ct-sec-title span{background:linear-gradient(135deg,var(--gold-light),var(--gold),var(--gold-dark));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.ct-divider{width:48px;height:2px;background:linear-gradient(90deg,var(--gold),transparent);border:none}
.ct-desc{font-size:1.05rem;font-weight:300;font-style:italic;color:var(--wf);line-height:1.82}

/* Contact info cards */
.ct-info-cards{display:flex;flex-direction:column;gap:10px}
.ct-info-card{
    display:flex;align-items:flex-start;gap:14px;padding:16px 18px;
    border:1px solid var(--bb);border-radius:2px;background:rgba(212,160,23,.025);
    transition:border-color .3s,background .3s;
}
.ct-info-card:hover{border-color:rgba(212,160,23,.35);background:rgba(212,160,23,.055)}
.cic-icon{
    width:38px;height:38px;flex-shrink:0;border-radius:2px;
    background:var(--gold-muted);border:1px solid rgba(212,160,23,.28);
    display:flex;align-items:center;justify-content:center;
    transition:background .3s;
}
.ct-info-card:hover .cic-icon{background:rgba(212,160,23,.22)}
.cic-icon svg{width:16px;height:16px;stroke:var(--gold);fill:none;stroke-width:1.8}
.cic-label{font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold);opacity:.75;margin-bottom:4px}
.cic-value{font-size:.95rem;color:var(--wd);line-height:1.6}
.cic-value a{color:var(--wd);text-decoration:none;transition:color .25s}
.cic-value a:hover{color:var(--gold-light)}

/* Social links */
.ct-socials-row{display:flex;flex-direction:column;gap:10px}
.ct-soc-title{font-family:'Cinzel',serif;font-size:.62rem;letter-spacing:.18em;text-transform:uppercase;color:var(--wf)}
.ct-soc-btns{display:flex;gap:8px;flex-wrap:wrap}
.ct-soc-btn{
    width:40px;height:40px;border:1px solid var(--bb);border-radius:2px;
    display:flex;align-items:center;justify-content:center;
    color:var(--wf);text-decoration:none;font-size:.85rem;
    position:relative;overflow:hidden;
    transition:border-color .3s,color .3s,transform .25s;
}
.ct-soc-btn::before{
    content:'';position:absolute;inset:0;
    background:linear-gradient(135deg,var(--gold-dark),var(--gold));
    transform:scaleY(0);transform-origin:bottom;transition:transform .35s var(--ease);
}
.ct-soc-btn:hover{border-color:var(--gold);color:#060606;transform:translateY(-3px)}
.ct-soc-btn:hover::before{transform:scaleY(1)}
.ct-soc-btn span{position:relative;z-index:1}

/* Office hours */
.ct-hours{
    padding:18px 20px;border:1px solid var(--bb);border-radius:2px;
    background:rgba(212,160,23,.025);border-left:3px solid var(--gold);
}
.ct-hours-title{font-family:'Cinzel',serif;font-size:.65rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold);margin-bottom:12px}
.ct-hours-row{display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid rgba(255,255,255,.04);font-size:.88rem}
.ct-hours-row:last-child{border-bottom:none}
.ct-hours-day{color:var(--wd)}
.ct-hours-time{color:var(--wf)}

/* ── CONTACT FORM ── */
.ct-form-wrap{
    background:var(--bc);border:1px solid var(--bb);border-radius:3px;
    padding:40px;position:relative;overflow:hidden;
}
.ct-form-wrap::before{
    content:'';position:absolute;top:0;left:0;right:0;height:2px;
    background:linear-gradient(90deg,transparent,var(--gold-dark),var(--gold-light),var(--gold-dark),transparent);
    background-size:200% 100%;animation:shimmer 4s linear infinite;
}
@keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
.ct-form-wrap::after{
    content:'';position:absolute;top:-100px;right:-100px;
    width:280px;height:280px;
    background:radial-gradient(circle,rgba(212,160,23,.06) 0%,transparent 70%);
    pointer-events:none;
}
.cf-title{font-family:'Cinzel',serif;font-size:1rem;font-weight:700;color:var(--white);letter-spacing:.1em;text-transform:uppercase;margin-bottom:6px}
.cf-sub{font-size:.9rem;font-weight:300;font-style:italic;color:var(--wf);margin-bottom:28px}
.cf-divider{height:1px;background:linear-gradient(90deg,transparent,var(--gold-dark),var(--gold-light),var(--gold-dark),transparent);opacity:.4;margin-bottom:28px}

/* Form rows */
.cf-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px}
.cf-group{margin-bottom:16px;position:relative}
.cf-label{display:block;font-family:'Cinzel',serif;font-size:.58rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold);margin-bottom:8px}
.cf-input-wrap{position:relative}
.cf-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);pointer-events:none;display:flex;align-items:center}
.cf-icon svg{width:15px;height:15px;stroke:var(--wf);fill:none;stroke-width:1.8;transition:stroke .3s}
.cf-input{
    width:100%;padding:12px 14px 12px 40px;
    background:rgba(255,255,255,.04);border:1px solid var(--bb);border-radius:2px;
    color:var(--white);font-family:'Crimson Pro',serif;font-size:.98rem;
    outline:none;transition:border-color .3s,background .3s,box-shadow .3s;
}
.cf-input::placeholder{color:var(--wf)}
.cf-input:focus{border-color:rgba(212,160,23,.55);background:rgba(212,160,23,.04);box-shadow:0 0 0 3px rgba(212,160,23,.08)}
.cf-input:focus ~ .cf-icon svg,.cf-input-wrap:focus-within .cf-icon svg{stroke:var(--gold)}
select.cf-input{cursor:pointer}
select.cf-input option{background:var(--bc);color:var(--white)}
textarea.cf-input{padding-top:13px;resize:vertical;min-height:120px;line-height:1.6}

/* Subject tabs */
.cf-tabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px}
.cf-tab{
    padding:7px 16px;font-family:'Cinzel',serif;font-size:.58rem;letter-spacing:.14em;
    text-transform:uppercase;background:transparent;border:1px solid var(--bb);
    border-radius:2px;color:var(--wf);cursor:pointer;
    transition:border-color .25s,color .25s,background .25s;
}
.cf-tab:hover,.cf-tab.active{border-color:var(--gold);color:var(--gold-light);background:var(--gold-muted)}

/* Submit */
.cf-submit{
    width:100%;padding:14px;
    background:linear-gradient(135deg,var(--gold-dark),var(--gold),var(--gold-light));
    color:#060606;font-family:'Cinzel',serif;font-size:.72rem;font-weight:700;
    letter-spacing:.18em;text-transform:uppercase;border:none;border-radius:2px;
    cursor:pointer;position:relative;overflow:hidden;
    box-shadow:0 4px 20px rgba(212,160,23,.3);
    transition:box-shadow .3s,transform .2s;margin-top:8px;
}
.cf-submit::before{
    content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);
    transform:skewX(-20deg);transition:left .55s ease;
}
.cf-submit:hover::before{left:160%}
.cf-submit:hover{box-shadow:0 8px 32px rgba(212,160,23,.55);transform:translateY(-1px)}
.cf-submit:active{transform:translateY(0)}

/* Success message */
.cf-success{
    display:none;padding:16px 20px;border-radius:2px;
    background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.35);
    color:#4ade80;font-family:'Cinzel',serif;font-size:.7rem;
    letter-spacing:.1em;text-transform:uppercase;text-align:center;margin-top:14px;
}
.cf-success.show{display:block}
.cf-error-msg{
    display:none;padding:12px 16px;border-radius:2px;margin-top:10px;
    background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);
    color:#f87171;font-size:.88rem;font-style:italic;
}
.cf-error-msg.show{display:block}

/* Field error */
.cf-group.has-error .cf-input{border-color:#ef4444}
.cf-field-err{font-size:.78rem;color:#f87171;margin-top:5px;display:none}
.cf-group.has-error .cf-field-err{display:block}

/* ── FAQ ── */
.faq-section{padding:100px 40px;background:var(--bc)}
.faq-inner{max-width:760px;margin:0 auto}
.faq-sec-head{text-align:center;margin-bottom:52px}
.faq-list{display:flex;flex-direction:column;gap:10px}
.faq-item{
    border:1px solid var(--bb);border-radius:2px;overflow:hidden;
    transition:border-color .3s;
}
.faq-item.open{border-color:rgba(212,160,23,.35)}
.faq-q{
    display:flex;align-items:center;justify-content:space-between;gap:16px;
    padding:18px 20px;cursor:pointer;
    font-family:'Cinzel',serif;font-size:.8rem;font-weight:600;
    letter-spacing:.06em;color:var(--wd);
    transition:color .25s;user-select:none;
}
.faq-item.open .faq-q{color:var(--gold-light)}
.faq-q-icon{
    width:24px;height:24px;flex-shrink:0;
    border:1px solid rgba(212,160,23,.3);border-radius:2px;
    display:flex;align-items:center;justify-content:center;
    color:var(--gold);transition:transform .35s var(--ease),background .25s;
}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--gold-muted)}
.faq-q-icon svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5}
.faq-a{
    max-height:0;overflow:hidden;
    transition:max-height .45s var(--ease);
}
.faq-a-inner{padding:0 20px 18px;font-size:.98rem;font-weight:300;font-style:italic;color:var(--wf);line-height:1.78}

/* ── MAP BAND ── */
.map-band{padding:0;height:320px;position:relative;overflow:hidden;border-top:1px solid var(--bb);border-bottom:1px solid var(--bb)}
.map-band-placeholder{
    width:100%;height:100%;background:var(--bc);
    display:flex;align-items:center;justify-content:center;flex-direction:column;gap:14px;
}
.map-band-placeholder p{font-family:'Cinzel',serif;font-size:.7rem;letter-spacing:.2em;text-transform:uppercase;color:var(--wf)}
.map-pin{width:44px;height:44px;border-radius:50%;background:var(--gold-muted);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center}
.map-pin svg{width:20px;height:20px;stroke:var(--gold);fill:none;stroke-width:1.8}

/* ── RESPONSIVE ── */
@media(max-width:920px){
    .ct-grid{grid-template-columns:1fr;gap:44px}
    .ct-main{padding:72px 20px}
}
@media(max-width:640px){
    .cf-row{grid-template-columns:1fr}
    .ct-form-wrap{padding:28px 20px}
    .faq-section{padding:60px 20px}
    .ct-hero{height:65vh}
}
</style>
</head>
<body>

@include('layouts.partials.header')

{{-- ════════ HERO ════════ --}}
<section class="ct-hero" aria-label="Contact Hero">
    <div class="ct-hero-bg"></div>
    <div class="ct-hero-ov"></div>
    <div class="ct-hero-content">
        <div class="ct-eyebrow"><span class="ct-dot"></span>We're Here to Help</div>
        <h1 class="ct-hero-title">Get In <span>Touch</span></h1>
        <p class="ct-hero-sub">Questions, partnerships, or support — our team responds within 24 hours.</p>
    </div>
</section>

{{-- ════════ MAIN ════════ --}}
<section class="ct-main">
    <div class="ct-grid">

        {{-- ── LEFT: Info ── --}}
        <div class="ct-info fu">
            <div class="ct-sec-eyebrow"><span class="ct-sec-eyebrow-line"></span>Contact Info</div>
            <h2 class="ct-sec-title">Let's Start a<br><span>Conversation</span></h2>
            <div class="ct-divider"></div>
            <p class="ct-desc">Whether you're a new member, a potential partner, or an existing user needing support — we want to hear from you. Our team is standing by.</p>

            <div class="ct-info-cards">
                <div class="ct-info-card">
                    <div class="cic-icon"><svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                    <div><div class="cic-label">Email Us</div><div class="cic-value"><a href="mailto:support@cryptoonly.com">support@cryptoonly.com</a><br><a href="mailto:partnerships@cryptoonly.com">partnerships@cryptoonly.com</a></div></div>
                </div>
                <div class="ct-info-card">
                    <div class="cic-icon"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 0112 18.69a19.5 19.5 0 01-3.07-3.13A19.79 19.79 0 01.08 2.18 2 2 0 012.06 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92v2z"/></svg></div>
                    <div><div class="cic-label">Call / WhatsApp</div><div class="cic-value"><a href="tel:+441234567890">+44 1234 567 890</a><br><a href="https://wa.me/923339073110">+92 333 907 3110</a></div></div>
                </div>
                <div class="ct-info-card">
                    <div class="cic-icon"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                    <div><div class="cic-label">Office</div><div class="cic-value">Level 12, The Shard<br>London SE1 9RY, United Kingdom</div></div>
                </div>
                <div class="ct-info-card">
                    <div class="cic-icon"><svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg></div>
                    <div><div class="cic-label">Telegram</div><div class="cic-value"><a href="#">@CryptoOnlyOfficial</a></div></div>
                </div>
            </div>

            <div class="ct-socials-row">
                <div class="ct-soc-title">Follow Us</div>
                <div class="ct-soc-btns">
                    <a href="#" class="ct-soc-btn" aria-label="Twitter"><span>𝕏</span></a>
                    <a href="#" class="ct-soc-btn" aria-label="Telegram"><span style="font-size:1.05rem">✈</span></a>
                    <a href="#" class="ct-soc-btn" aria-label="Instagram"><span>◎</span></a>
                    <a href="#" class="ct-soc-btn" aria-label="YouTube"><span>▶</span></a>
                    <a href="#" class="ct-soc-btn" aria-label="Discord"><span>⬡</span></a>
                    <a href="#" class="ct-soc-btn" aria-label="LinkedIn"><span style="font-size:.8rem">in</span></a>
                </div>
            </div>

            <div class="ct-hours">
                <div class="ct-hours-title">Office Hours</div>
                <div class="ct-hours-row"><span class="ct-hours-day">Monday – Friday</span><span class="ct-hours-time">9:00 AM – 6:00 PM GMT</span></div>
                <div class="ct-hours-row"><span class="ct-hours-day">Saturday</span><span class="ct-hours-time">10:00 AM – 2:00 PM GMT</span></div>
                <div class="ct-hours-row"><span class="ct-hours-day">Sunday</span><span class="ct-hours-time">Closed</span></div>
                <div class="ct-hours-row"><span class="ct-hours-day">Support (24/7)</span><span class="ct-hours-time" style="color:var(--green)">Always Online</span></div>
            </div>
        </div>

        {{-- ── RIGHT: Form ── --}}
        <div class="ct-form-wrap fu fu-d2">
            <div class="cf-title">Send Us a Message</div>
            <p class="cf-sub">We'll get back to you within 24 hours.</p>
            <div class="cf-divider"></div>

            {{-- Subject tabs --}}
            <div class="cf-tabs" id="cfTabs">
                <button class="cf-tab active" data-subject="General Enquiry">General</button>
                <button class="cf-tab" data-subject="Technical Support">Support</button>
                <button class="cf-tab" data-subject="Partnership">Partnership</button>
                <button class="cf-tab" data-subject="Course Enquiry">Courses</button>
                <button class="cf-tab" data-subject="P2P Trading">P2P</button>
            </div>

            @if(session('success'))
            <div class="cf-success show">✦ {{ session('success') }}</div>
            @endif

            <div class="cf-success" id="cfSuccess">✦ Message sent! We'll be in touch within 24 hours.</div>
            <div class="cf-error-msg" id="cfError">Something went wrong. Please try again.</div>

            <form method="POST" action="{{ route('contact.send') }}" id="contactForm" novalidate>
                @csrf
                <input type="hidden" name="subject" id="subjectInput" value="General Enquiry">

                <div class="cf-row">
                    <div class="cf-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        <label class="cf-label" for="first_name">First Name *</label>
                        <div class="cf-input-wrap">
                            <div class="cf-icon"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                            <input class="cf-input" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="John" required>
                        </div>
                        <div class="cf-field-err">{{ $errors->first('first_name') }}</div>
                    </div>
                    <div class="cf-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        <label class="cf-label" for="last_name">Last Name *</label>
                        <div class="cf-input-wrap">
                            <div class="cf-icon"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                            <input class="cf-input" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                        </div>
                        <div class="cf-field-err">{{ $errors->first('last_name') }}</div>
                    </div>
                </div>

                <div class="cf-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label class="cf-label" for="ct_email">Email Address *</label>
                    <div class="cf-input-wrap">
                        <div class="cf-icon"><svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                        <input class="cf-input" type="email" id="ct_email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required>
                    </div>
                    <div class="cf-field-err">{{ $errors->first('email') }}</div>
                </div>

                <div class="cf-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label class="cf-label" for="ct_phone">WhatsApp / Phone</label>
                    <div class="cf-input-wrap">
                        <div class="cf-icon"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 0112 18.69a19.5 19.5 0 01-3.07-3.13A19.79 19.79 0 01.08 2.18 2 2 0 012.06 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92v2z"/></svg></div>
                        <input class="cf-input" type="tel" id="ct_phone" name="phone" value="{{ old('phone') }}" placeholder="+92 333 000 0000">
                    </div>
                </div>

                <div class="cf-group {{ $errors->has('message') ? 'has-error' : '' }}">
                    <label class="cf-label" for="ct_message">Your Message *</label>
                    <div class="cf-input-wrap">
                        <textarea class="cf-input" id="ct_message" name="message" placeholder="Tell us how we can help you..." required style="padding-left:14px">{{ old('message') }}</textarea>
                    </div>
                    <div class="cf-field-err">{{ $errors->first('message') }}</div>
                </div>

                <button type="submit" class="cf-submit" id="cfSubmitBtn">Send Message</button>
            </form>
        </div>
    </div>
</section>

{{-- ════════ MAP BAND ════════ --}}
<div class="map-band fu">
    <div class="map-band-placeholder">
        <div class="map-pin"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
        <p>Level 12, The Shard, London SE1 9RY, UK</p>
        {{-- Replace below with real Google Maps embed if needed --}}
        {{-- <iframe src="https://maps.google.com/..." width="100%" height="320" style="border:0;position:absolute;inset:0;opacity:.45" allowfullscreen loading="lazy"></iframe> --}}
    </div>
</div>

{{-- ════════ FAQ ════════ --}}
<section class="faq-section">
    <div class="faq-inner">
        <div class="faq-sec-head fu">
            <div style="display:inline-flex;align-items:center;gap:10px;font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.28em;text-transform:uppercase;color:var(--gold);margin-bottom:16px">
                <span style="display:block;width:28px;height:1px;background:linear-gradient(90deg,transparent,var(--gold))"></span>
                FAQ
                <span style="display:block;width:28px;height:1px;background:linear-gradient(90deg,var(--gold),transparent)"></span>
            </div>
            <h2 style="font-family:'Cinzel',serif;font-size:clamp(1.6rem,3vw,2.3rem);font-weight:700;color:#fff;letter-spacing:.02em;margin-bottom:12px">Frequently Asked <span style="background:linear-gradient(135deg,#F5C842,#D4A017,#A07810);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Questions</span></h2>
        </div>
        <div class="faq-list">
            @php
            $faqs = [
                ['q'=>'How quickly will you respond to my message?','a'=>'Our support team is online 24/7. For general enquiries, expect a response within 4–8 hours. For technical issues, we typically respond within 1–2 hours.'],
                ['q'=>'How do I join the Premium Group?','a'=>'Click "Join Now" on our Premium Group card on the homepage, complete the enrollment form, submit payment proof, and our team will verify and grant access within 24 hours.'],
                ['q'=>'What payment methods do you accept?','a'=>'We accept bank transfers (Meezan Bank), Binance Pay, Binance TRC20, and most major cryptocurrencies. Contact us if you need an alternative payment method.'],
                ['q'=>'Can I get a refund if I change my mind?','a'=>'We offer a 7-day satisfaction guarantee on all courses. If you are not satisfied, contact support within 7 days of purchase for a full refund, no questions asked.'],
                ['q'=>'Is there a free trial available?','a'=>'New members receive free access to our starter signals channel and one free course preview. Premium Group trials are available on request — contact us to arrange one.'],
                ['q'=>'How do I report a P2P trade dispute?','a'=>'Go to your P2P dashboard, open the trade in question, and click "Raise Dispute". Our escrow team will investigate and resolve the issue within 24 hours.'],
            ];
            @endphp
            @foreach($faqs as $i => $faq)
            <div class="faq-item fu" data-faq>
                <div class="faq-q">
                    {{ $faq['q'] }}
                    <div class="faq-q-icon"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
                </div>
                <div class="faq-a"><div class="faq-a-inner">{{ $faq['a'] }}</div></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@include('layouts.partials.footer')

<script>
(function(){
    // ── IntersectionObserver entrance animations ──
    var all = document.querySelectorAll('.fu');
    if('IntersectionObserver' in window){
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(en){if(en.isIntersecting){en.target.classList.add('in');io.unobserve(en.target)}});
        },{threshold:.1});
        all.forEach(function(e){io.observe(e)});
    } else { all.forEach(function(e){e.classList.add('in')}) }

    // ── Subject tabs ──
    document.querySelectorAll('.cf-tab').forEach(function(btn){
        btn.addEventListener('click',function(){
            document.querySelectorAll('.cf-tab').forEach(function(b){b.classList.remove('active')});
            btn.classList.add('active');
            document.getElementById('subjectInput').value = btn.dataset.subject;
        });
    });

    // ── FAQ accordion ──
    document.querySelectorAll('[data-faq]').forEach(function(item){
        item.querySelector('.faq-q').addEventListener('click',function(){
            var isOpen = item.classList.contains('open');
            document.querySelectorAll('[data-faq]').forEach(function(i){
                i.classList.remove('open');
                i.querySelector('.faq-a').style.maxHeight = null;
            });
            if(!isOpen){
                item.classList.add('open');
                var a = item.querySelector('.faq-a');
                a.style.maxHeight = a.scrollHeight + 'px';
            }
        });
    });

    // ── Form submit loading state ──
    var form = document.getElementById('contactForm');
    if(form){
        form.addEventListener('submit', function(){
            var btn = document.getElementById('cfSubmitBtn');
            if(btn){ btn.textContent = 'Sending...'; btn.disabled = true; }
        });
    }
})();
</script>
</body>
</html>