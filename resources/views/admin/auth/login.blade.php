<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — CryptoOnly</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300&display=swap" rel="stylesheet">
<style>
:root {
    --gold: #D4A017; --gold-light: #F5C842; --gold-dark: #A07810;
    --gold-glow: rgba(212,160,23,0.45); --gold-muted: rgba(212,160,23,0.12);
    --black: #060606; --black-card: #0d0d0d; --black-border: #1e1e1e;
    --white: #ffffff; --white-dim: rgba(255,255,255,0.7);
    --white-faint: rgba(255,255,255,0.35);
    --ease: cubic-bezier(0.16,1,0.3,1);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden}
body{background:var(--black);font-family:'Crimson Pro',Georgia,serif;display:flex;align-items:stretch}

/* ── LEFT PANEL ──────────────────────────────────────── */
.login-left{
    flex:1;position:relative;display:flex;align-items:center;
    justify-content:center;overflow:hidden;
}
.login-left-bg{
    position:absolute;inset:0;
    background:url('https://images.unsplash.com/photo-1639762681485-074b7f938ba0?w=1200&q=80') center/cover no-repeat;
    animation:bgzoom 20s ease-in-out infinite alternate;
}
@keyframes bgzoom{0%{transform:scale(1)}100%{transform:scale(1.06)}}
.login-left-overlay{
    position:absolute;inset:0;
    background:linear-gradient(135deg,rgba(6,6,6,0.88) 0%,rgba(6,6,6,0.55) 50%,rgba(6,6,6,0.75) 100%);
}
.login-left-overlay::after{
    content:'';position:absolute;right:0;top:0;width:1px;height:100%;
    background:linear-gradient(180deg,transparent,var(--gold),transparent);opacity:.5;
}
.login-left-content{
    position:relative;z-index:1;padding:60px;max-width:520px;
    opacity:0;transform:translateX(-30px);
    animation:slideInLeft .9s var(--ease) .3s forwards;
}
@keyframes slideInLeft{to{opacity:1;transform:translateX(0)}}
.ll-eyebrow{
    display:inline-flex;align-items:center;gap:9px;
    font-family:'Cinzel',serif;font-size:.58rem;letter-spacing:.28em;
    text-transform:uppercase;color:var(--gold);margin-bottom:28px;
}
.ll-dot{width:5px;height:5px;border-radius:50%;background:var(--gold);animation:blink 1.6s ease-in-out infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.15}}
.ll-title{
    font-family:'Cinzel',serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;
    color:var(--white);line-height:1.15;letter-spacing:.02em;margin-bottom:20px;
}
.ll-title span{
    display:block;
    background:linear-gradient(135deg,var(--gold-light),var(--gold),var(--gold-dark));
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.ll-desc{
    font-size:1.05rem;font-weight:300;font-style:italic;
    color:var(--white-faint);line-height:1.8;margin-bottom:40px;max-width:380px;
}
.ll-stats{display:flex;gap:28px;flex-wrap:wrap}
.ll-stat{text-align:center}
.ll-stat-val{
    font-family:'Cinzel',serif;font-size:1.5rem;font-weight:700;
    background:linear-gradient(135deg,var(--gold-light),var(--gold));
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    display:block;line-height:1;
}
.ll-stat-lbl{font-size:.68rem;color:var(--white-faint);letter-spacing:.12em;text-transform:uppercase;margin-top:4px;display:block}

/* ── RIGHT PANEL ─────────────────────────────────────── */
.login-right{
    width:480px;flex-shrink:0;background:var(--black-card);
    border-left:1px solid var(--black-border);
    display:flex;flex-direction:column;align-items:center;
    justify-content:center;padding:60px 52px;position:relative;overflow:hidden;
}
.login-right::before{
    content:'';position:absolute;top:-150px;right:-150px;
    width:350px;height:350px;
    background:radial-gradient(circle,rgba(212,160,23,.07) 0%,transparent 70%);
    pointer-events:none;
}
.login-right::after{
    content:'';position:absolute;bottom:-100px;left:-100px;
    width:280px;height:280px;
    background:radial-gradient(circle,rgba(212,160,23,.05) 0%,transparent 70%);
    pointer-events:none;
}

/* Form entrance animation */
.login-form-wrap{
    width:100%;position:relative;z-index:1;
    opacity:0;transform:translateY(24px);
    animation:slideUp .8s var(--ease) .5s forwards;
}
@keyframes slideUp{to{opacity:1;transform:translateY(0)}}

/* Logo */
.login-logo{
    display:flex;align-items:center;gap:10px;text-decoration:none;
    margin-bottom:36px;justify-content:center;
}
.login-logo-icon{
    display:flex;align-items:center;
    filter:drop-shadow(0 0 8px var(--gold-glow));
    animation:pulseIcon 3s ease-in-out infinite;
}
@keyframes pulseIcon{0%,100%{filter:drop-shadow(0 0 6px var(--gold-glow))}50%{filter:drop-shadow(0 0 16px var(--gold-light))}}
.login-logo-text{font-family:'Cinzel',serif;font-size:1.4rem;font-weight:700;line-height:1}
.login-logo-c{color:#fff}
.login-logo-o{
    background:linear-gradient(135deg,var(--gold-light),var(--gold),var(--gold-dark));
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}

/* Form header */
.login-form-title{
    font-family:'Cinzel',serif;font-size:1.1rem;font-weight:700;
    color:var(--white);text-align:center;letter-spacing:.08em;margin-bottom:6px;
}
.login-form-sub{
    font-size:.88rem;font-weight:300;font-style:italic;
    color:var(--white-faint);text-align:center;margin-bottom:36px;
}

/* Gold divider */
.form-divider{
    width:100%;height:1px;margin-bottom:32px;
    background:linear-gradient(90deg,transparent,var(--gold-dark),var(--gold-light),var(--gold-dark),transparent);
    opacity:.5;
}

/* Input groups */
.form-group{position:relative;margin-bottom:20px}
.form-label{
    display:block;font-family:'Cinzel',serif;font-size:.6rem;
    font-weight:600;letter-spacing:.18em;text-transform:uppercase;
    color:var(--gold);margin-bottom:8px;
}
.form-input-wrap{position:relative}
.form-input-icon{
    position:absolute;left:14px;top:50%;transform:translateY(-50%);
    display:flex;align-items:center;
}
.form-input-icon svg{width:16px;height:16px;stroke:var(--white-faint);fill:none;stroke-width:1.8;transition:stroke .3s}
.form-input{
    width:100%;padding:13px 44px 13px 42px;
    background:rgba(255,255,255,.04);
    border:1px solid var(--black-border);border-radius:2px;
    color:var(--white);font-family:'Crimson Pro',serif;font-size:1rem;
    outline:none;
    transition:border-color .3s,background .3s,box-shadow .3s;
}
.form-input::placeholder{color:var(--white-faint)}
.form-input:focus{
    border-color:rgba(212,160,23,.55);
    background:rgba(212,160,23,.04);
    box-shadow:0 0 0 3px rgba(212,160,23,.08);
}
.form-input:focus + .form-input-icon svg,
.form-input-wrap:focus-within .form-input-icon svg{stroke:var(--gold)}
/* Fix icon z-order */
.form-input-wrap .form-input-icon{z-index:1;pointer-events:none}

/* Password toggle */
.pwd-toggle{
    position:absolute;right:14px;top:50%;transform:translateY(-50%);
    background:none;border:none;cursor:pointer;padding:2px;
    display:flex;align-items:center;
    color:var(--white-faint);transition:color .25s;
}
.pwd-toggle:hover{color:var(--gold)}
.pwd-toggle svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:1.8}

/* Remember / forgot row */
.form-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px}
.form-check{display:flex;align-items:center;gap:8px;cursor:pointer}
.form-check input[type=checkbox]{
    appearance:none;width:16px;height:16px;border:1px solid #333;
    border-radius:2px;background:transparent;cursor:pointer;
    position:relative;transition:border-color .25s,background .25s;flex-shrink:0;
}
.form-check input[type=checkbox]:checked{
    background:var(--gold);border-color:var(--gold);
}
.form-check input[type=checkbox]:checked::after{
    content:'';position:absolute;left:4px;top:1px;
    width:5px;height:9px;border:2px solid #060606;
    border-top:none;border-left:none;transform:rotate(45deg);
}
.form-check-label{font-size:.85rem;color:var(--white-faint)}
.form-forgot{
    font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.12em;
    text-transform:uppercase;color:var(--gold);opacity:.75;
    text-decoration:none;transition:opacity .25s;
}
.form-forgot:hover{opacity:1}

/* Submit button */
.btn-login{
    width:100%;padding:14px;
    background:linear-gradient(135deg,var(--gold-dark),var(--gold),var(--gold-light));
    color:var(--black);font-family:'Cinzel',serif;font-size:.75rem;
    font-weight:700;letter-spacing:.18em;text-transform:uppercase;
    border:none;border-radius:2px;cursor:pointer;
    position:relative;overflow:hidden;
    box-shadow:0 4px 20px rgba(212,160,23,.3);
    transition:box-shadow .3s,transform .2s;
}
.btn-login::before{
    content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);
    transform:skewX(-20deg);transition:left .55s ease;
}
.btn-login:hover::before{left:160%}
.btn-login:hover{box-shadow:0 8px 32px rgba(212,160,23,.55);transform:translateY(-1px)}
.btn-login:active{transform:translateY(0)}

/* Error messages */
.form-error{
    display:none;font-size:.82rem;color:#f87171;
    margin-top:6px;padding-left:2px;
}
.form-group.has-error .form-input{border-color:#f87171}
.form-group.has-error .form-error{display:block}

/* Alert box */
.alert-box{
    padding:12px 16px;border-radius:2px;margin-bottom:20px;
    font-size:.9rem;font-style:italic;
    display:none;
}
.alert-box.error{background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.35);color:#f87171}
.alert-box.success{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.35);color:#4ade80}
.alert-box.show{display:block}

/* Back link */
.login-back{
    display:flex;align-items:center;gap:7px;margin-top:28px;justify-content:center;
    font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.14em;
    text-transform:uppercase;color:var(--white-faint);text-decoration:none;
    transition:color .25s;
}
.login-back svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;transition:transform .3s var(--ease)}
.login-back:hover{color:var(--gold)}
.login-back:hover svg{transform:translateX(-4px)}

/* Loading spinner on button */
.btn-spinner{
    display:none;width:16px;height:16px;border:2px solid rgba(6,6,6,.3);
    border-top-color:var(--black);border-radius:50%;
    animation:spin .7s linear infinite;margin:0 auto;
}
@keyframes spin{to{transform:rotate(360deg)}}
.btn-login.loading .btn-text{display:none}
.btn-login.loading .btn-spinner{display:block}

/* ── RESPONSIVE ──────────────────────────────────────── */
@media(max-width:900px){
    body{overflow:auto}
    .login-left{display:none}
    .login-right{width:100%;min-height:100vh;padding:48px 28px}
}
@media(max-width:400px){
    .login-right{padding:36px 20px}
}
</style>
</head>
<body>

    {{-- ══ LEFT PANEL ══ --}}
    <div class="login-left" aria-hidden="true">
        <div class="login-left-bg"></div>
        <div class="login-left-overlay"></div>
        <div class="login-left-content">
            <div class="ll-eyebrow">
                <span class="ll-dot"></span>
                Admin Control Centre
            </div>
            <h1 class="ll-title">
                Manage Your
                <span>CryptoOnly</span>
                Platform
            </h1>
            <p class="ll-desc">
                Full control over members, courses, signals, P2P trading, live sessions, and real-time analytics — all from one secure dashboard.
            </p>
            <div class="ll-stats">
                <div class="ll-stat">
                    <span class="ll-stat-val">320K+</span>
                    <span class="ll-stat-lbl">Members</span>
                </div>
                <div class="ll-stat">
                    <span class="ll-stat-val">$4.2B</span>
                    <span class="ll-stat-lbl">Volume</span>
                </div>
                <div class="ll-stat">
                    <span class="ll-stat-val">180+</span>
                    <span class="ll-stat-lbl">Assets</span>
                </div>
                <div class="ll-stat">
                    <span class="ll-stat-val">99.98%</span>
                    <span class="ll-stat-lbl">Uptime</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ RIGHT PANEL ══ --}}
    <div class="login-right">
        <div class="login-form-wrap">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="login-logo">
                <span class="login-logo-icon">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <polygon points="14,2 26,8 26,20 14,26 2,20 2,8" stroke="#D4A017" stroke-width="1.5" fill="none"/>
                        <polygon points="14,6 22,10 22,18 14,22 6,18 6,10" fill="#D4A017" opacity="0.15"/>
                        <text x="14" y="18" text-anchor="middle" font-family="serif" font-size="11" fill="#D4A017" font-weight="bold">₿</text>
                    </svg>
                </span>
                <span class="login-logo-text">
                    <span class="login-logo-c">Crypto</span><span class="login-logo-o">Only</span>
                </span>
            </a>

            <h2 class="login-form-title">Admin Sign In</h2>
            <p class="login-form-sub">Secure access to your control panel</p>

            <div class="form-divider"></div>

            {{-- Alert box --}}
            @if(session('error'))
            <div class="alert-box error show">{{ session('error') }}</div>
            @endif
            <div class="alert-box error" id="alertError"></div>

            {{-- Login Form --}}
            <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm" novalidate>
                @csrf

                {{-- Email --}}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label class="form-label" for="email">Email Address</label>
                    <div class="form-input-wrap">
                        <div class="form-input-icon">
                            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <input
                            class="form-input"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="admin@cryptoonly.com"
                            autocomplete="email"
                            required
                        >
                    </div>
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label class="form-label" for="password">Password</label>
                    <div class="form-input-wrap">
                        <div class="form-input-icon">
                            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </div>
                        <input
                            class="form-input"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="pwd-toggle" id="pwdToggle" aria-label="Toggle password visibility">
                            <svg id="eyeIcon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Remember / forgot --}}
                <div class="form-row">
                    <label class="form-check">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="form-check-label">Remember me</span>
                    </label>
                    <a href="#" class="form-forgot">Forgot password?</a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="btn-text">Sign In to Dashboard</span>
                    <span class="btn-spinner"></span>
                </button>

            </form>

            <a href="{{ url('/') }}" class="login-back">
                <svg viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to Website
            </a>

        </div>
    </div>

<script>
// Password toggle
document.getElementById('pwdToggle').addEventListener('click', function(){
    var inp = document.getElementById('password');
    var icon = document.getElementById('eyeIcon');
    if(inp.type === 'password'){
        inp.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        inp.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
});

// Loading state on submit
document.getElementById('loginForm').addEventListener('submit', function(){
    document.getElementById('loginBtn').classList.add('loading');
});
</script>
</body>
</html>