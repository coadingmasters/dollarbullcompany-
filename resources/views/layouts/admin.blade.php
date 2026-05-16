<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin â€” CryptoOnly')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Crimson+Pro:ital,wght@0,300;0,400;0,600&display=swap" rel="stylesheet">
<style>
/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   TOKENS
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
:root{
    --gold:#D4A017;--gold-light:#F5C842;--gold-dark:#A07810;
    --gold-glow:rgba(212,160,23,.45);--gold-muted:rgba(212,160,23,.12);
    --black:#060606;--bc:#0d0d0d;--bb:#1a1a1a;--b2:#242424;
    --white:#ffffff;--wd:rgba(255,255,255,.75);--wf:rgba(255,255,255,.38);
    --sidebar-w:260px;--header-h:64px;
    --ease:cubic-bezier(.16,1,.3,1);
    --green:#22c55e;--red:#ef4444;--blue:#3b82f6;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden}
body{background:var(--black);font-family:'Crimson Pro',Georgia,serif;color:var(--wd);display:flex}

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   SIDEBAR
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.sidebar{
    width:var(--sidebar-w);flex-shrink:0;height:100vh;
    background:var(--bc);border-right:1px solid var(--bb);
    display:flex;flex-direction:column;position:fixed;top:0;left:0;
    z-index:200;transform:translateX(0);
    transition:transform .38s var(--ease),width .35s var(--ease);
    overflow:hidden;
}
.sidebar.collapsed{width:64px}
.sidebar::before{
    content:'';position:absolute;top:0;right:0;width:1px;height:100%;
    background:linear-gradient(180deg,transparent,var(--gold),transparent);opacity:.35;
}

/* Sidebar logo */
.sb-logo{
    height:var(--header-h);display:flex;align-items:center;
    padding:0 20px;gap:10px;border-bottom:1px solid var(--bb);
    flex-shrink:0;text-decoration:none;overflow:hidden;
}
.sb-logo-icon{
    display:flex;align-items:center;flex-shrink:0;
    filter:drop-shadow(0 0 6px var(--gold-glow));
    animation:pulseIcon 3s ease-in-out infinite;
}
@keyframes pulseIcon{0%,100%{filter:drop-shadow(0 0 5px var(--gold-glow))}50%{filter:drop-shadow(0 0 12px var(--gold-light))}}
.sb-logo-text{
    font-family:'Cinzel',serif;font-size:1.15rem;font-weight:700;
    letter-spacing:.04em;white-space:nowrap;overflow:hidden;
    transition:opacity .2s,width .35s;
}
.sb-logo-c{color:#fff}
.sb-logo-o{
    background:linear-gradient(135deg,var(--gold-light),var(--gold));
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.sidebar.collapsed .sb-logo-text{opacity:0;width:0}
.sidebar.collapsed .sb-logo{padding:0;justify-content:center}

/* Nav section label */
.sb-label{
    font-family:'Cinzel',serif;font-size:.54rem;letter-spacing:.24em;
    text-transform:uppercase;color:var(--wf);
    padding:20px 20px 8px;white-space:nowrap;
    transition:opacity .2s;
}
.sidebar.collapsed .sb-label{opacity:0;pointer-events:none}

/* Nav items */
.sb-nav{flex:1;overflow-y:auto;overflow-x:hidden;padding:8px 0}
.sb-nav::-webkit-scrollbar{width:3px}
.sb-nav::-webkit-scrollbar-track{background:transparent}
.sb-nav::-webkit-scrollbar-thumb{background:var(--bb)}

.sb-item{
    display:flex;align-items:center;gap:12px;
    padding:10px 20px;cursor:pointer;
    font-family:'Cinzel',serif;font-size:.68rem;font-weight:600;
    letter-spacing:.1em;text-transform:uppercase;
    color:var(--wf);text-decoration:none;
    position:relative;white-space:nowrap;overflow:hidden;
    transition:color .25s,background .25s,padding .35s;
    border-left:2px solid transparent;
}
.sidebar.collapsed .sb-item{padding:10px;justify-content:center}
.sb-item::before{
    content:'';position:absolute;inset:0;
    background:linear-gradient(90deg,var(--gold-muted),transparent);
    transform:translateX(-100%);
    transition:transform .35s var(--ease);
}
.sb-item:hover,.sb-item.active{color:var(--gold-light);border-left-color:var(--gold)}
.sb-item:hover::before,.sb-item.active::before{transform:translateX(0)}
.sb-item-icon{
    width:20px;height:20px;flex-shrink:0;
    stroke:currentColor;fill:none;stroke-width:1.6;
}
.sb-item-text{transition:opacity .2s,width .35s;overflow:hidden}
.sidebar.collapsed .sb-item-text{opacity:0;width:0;pointer-events:none}
.sb-badge{
    margin-left:auto;padding:2px 7px;border-radius:10px;
    font-size:.55rem;font-weight:700;letter-spacing:.06em;
    background:var(--gold-muted);color:var(--gold);
    border:1px solid rgba(212,160,23,.3);
    transition:opacity .2s;
}
.sidebar.collapsed .sb-badge{opacity:0;pointer-events:none}

/* Sidebar user at bottom */
.sb-user{
    padding:16px 20px;border-top:1px solid var(--bb);
    display:flex;align-items:center;gap:12px;overflow:hidden;flex-shrink:0;
}
.sb-avatar{
    width:36px;height:36px;border-radius:2px;flex-shrink:0;
    background:linear-gradient(135deg,var(--gold-dark),var(--gold));
    display:flex;align-items:center;justify-content:center;
    font-family:'Cinzel',serif;font-size:.75rem;font-weight:700;color:#060606;
}
.sb-user-info{overflow:hidden;transition:opacity .2s,width .35s}
.sb-user-name{font-family:'Cinzel',serif;font-size:.72rem;font-weight:700;color:var(--white);white-space:nowrap}
.sb-user-role{font-size:.72rem;color:var(--wf);white-space:nowrap}
.sidebar.collapsed .sb-user-info{opacity:0;width:0}
.sidebar.collapsed .sb-user{padding:16px;justify-content:center}

/* Sidebar mobile overlay */
.sb-overlay{
    display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);
    z-index:199;backdrop-filter:blur(4px);
    opacity:0;pointer-events:none;transition:opacity .3s;
}
.sb-overlay.show{opacity:1;pointer-events:all}

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   MAIN AREA
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.main-area{
    margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;
    min-height:100vh;transition:margin-left .35s var(--ease);overflow:hidden;
}
.main-area.expanded{margin-left:64px}

/* â”€â”€ TOP HEADER â”€â”€ */
.top-header{
    height:var(--header-h);background:var(--bc);
    border-bottom:1px solid var(--bb);
    display:flex;align-items:center;padding:0 28px;gap:16px;
    flex-shrink:0;position:sticky;top:0;z-index:100;
}

/* Shimmer top line */
.top-header::before{
    content:'';position:absolute;top:0;left:0;right:0;height:2px;
    background:linear-gradient(90deg,transparent,var(--gold-dark),var(--gold-light),var(--gold-dark),transparent);
    background-size:200% 100%;
    animation:shimmer 4s linear infinite;
}
@keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}

.toggle-btn{
    width:36px;height:36px;background:transparent;
    border:1px solid var(--bb);border-radius:2px;
    cursor:pointer;display:flex;flex-direction:column;
    align-items:center;justify-content:center;gap:4px;
    flex-shrink:0;transition:border-color .25s,background .25s;
}
.toggle-btn:hover{border-color:var(--gold);background:var(--gold-muted)}
.toggle-bar{
    display:block;width:16px;height:1.5px;
    background:var(--gold);border-radius:1px;transition:all .3s var(--ease);
}
.toggle-btn.active .toggle-bar:nth-child(1){transform:translateY(5.5px) rotate(45deg)}
.toggle-btn.active .toggle-bar:nth-child(2){opacity:0;transform:scaleX(0)}
.toggle-btn.active .toggle-bar:nth-child(3){transform:translateY(-5.5px) rotate(-45deg)}

/* Breadcrumb */
.breadcrumb{
    display:flex;align-items:center;gap:8px;
    font-family:'Cinzel',serif;font-size:.65rem;
    letter-spacing:.1em;text-transform:uppercase;color:var(--wf);
}
.breadcrumb a{color:var(--gold);text-decoration:none;transition:opacity .25s}
.breadcrumb a:hover{opacity:.75}
.breadcrumb span{color:var(--wf)}

/* Header right actions */
.header-actions{margin-left:auto;display:flex;align-items:center;gap:10px}
.h-action-btn{
    position:relative;width:36px;height:36px;
    background:transparent;border:1px solid var(--bb);
    border-radius:2px;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    color:var(--wf);transition:border-color .25s,color .25s,background .25s;
}
.h-action-btn svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:1.8}
.h-action-btn:hover{border-color:var(--gold);color:var(--gold);background:var(--gold-muted)}
.h-notif-dot{
    position:absolute;top:6px;right:6px;width:7px;height:7px;
    border-radius:50%;background:var(--gold);
    border:1.5px solid var(--bc);
    animation:notifPulse 2s ease-in-out infinite;
}
@keyframes notifPulse{0%,100%{box-shadow:0 0 0 0 var(--gold-glow)}70%{box-shadow:0 0 0 5px transparent}}

.header-date{
    font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.12em;
    text-transform:uppercase;color:var(--wf);padding:0 12px;
    border-left:1px solid var(--bb);
}

/* Live indicator */
.header-live{
    display:flex;align-items:center;gap:7px;padding:6px 14px;
    border:1px solid rgba(34,197,94,.3);border-radius:2px;
    background:rgba(34,197,94,.06);
    font-family:'Cinzel',serif;font-size:.58rem;letter-spacing:.14em;
    text-transform:uppercase;color:var(--green);
}
.live-dot{
    width:6px;height:6px;border-radius:50%;background:var(--green);
    box-shadow:0 0 0 0 rgba(34,197,94,.4);
    animation:livePulse 2s ease-in-out infinite;
}
@keyframes livePulse{0%{box-shadow:0 0 0 0 rgba(34,197,94,.4)}70%{box-shadow:0 0 0 6px transparent}100%{box-shadow:0 0 0 0 transparent}}

/* â”€â”€ PAGE CONTENT â”€â”€ */
.page-content{flex:1;overflow-y:auto;padding:28px;background:var(--black)}
.page-content::-webkit-scrollbar{width:4px}
.page-content::-webkit-scrollbar-track{background:transparent}
.page-content::-webkit-scrollbar-thumb{background:var(--bb);border-radius:2px}

/* Page title row */
.page-title-row{
    display:flex;align-items:flex-start;justify-content:space-between;
    gap:20px;margin-bottom:28px;flex-wrap:wrap;
}
.page-title-block{}
.page-eyebrow{
    font-family:'Cinzel',serif;font-size:.58rem;letter-spacing:.24em;
    text-transform:uppercase;color:var(--gold);margin-bottom:6px;
}
.page-title{
    font-family:'Cinzel',serif;font-size:clamp(1.4rem,2.8vw,2rem);
    font-weight:700;color:var(--white);letter-spacing:.03em;line-height:1.2;
}
.page-title-actions{display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin-top:4px}
.btn-sm{
    display:inline-flex;align-items:center;gap:7px;padding:9px 18px;
    font-family:'Cinzel',serif;font-size:.6rem;font-weight:700;
    letter-spacing:.14em;text-transform:uppercase;
    border-radius:2px;cursor:pointer;text-decoration:none;
    transition:all .25s;border:none;
}
.btn-sm svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2}
.btn-gold{background:linear-gradient(135deg,var(--gold-dark),var(--gold));color:#060606;box-shadow:0 4px 16px rgba(212,160,23,.25)}
.btn-gold:hover{box-shadow:0 6px 24px rgba(212,160,23,.45);transform:translateY(-1px)}
.btn-outline-gold{background:var(--gold-muted);border:1px solid rgba(212,160,23,.4);color:var(--gold-light)}
.btn-outline-gold:hover{border-color:var(--gold);background:rgba(212,160,23,.18)}

/* â”€â”€ STAT CARDS â”€â”€ */
.stats-grid{
    display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:24px;
}
.stat-card{
    background:var(--bc);border:1px solid var(--bb);border-radius:3px;
    padding:22px 24px;position:relative;overflow:hidden;
    opacity:0;transform:translateY(20px);
    animation:cardIn .6s var(--ease) forwards;
}
@keyframes cardIn{to{opacity:1;transform:translateY(0)}}
.stat-card::before{
    content:'';position:absolute;inset:0;
    background:linear-gradient(135deg,var(--gold-muted),transparent 60%);
    opacity:0;transition:opacity .35s;
}
.stat-card:hover::before{opacity:1}
.stat-card:hover{border-color:rgba(212,160,23,.35);box-shadow:0 8px 32px rgba(0,0,0,.5),0 0 20px rgba(212,160,23,.06)}

.sc-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px}
.sc-label{
    font-family:'Cinzel',serif;font-size:.6rem;letter-spacing:.18em;
    text-transform:uppercase;color:var(--wf);
}
.sc-icon{
    width:34px;height:34px;border-radius:2px;
    background:var(--gold-muted);border:1px solid rgba(212,160,23,.25);
    display:flex;align-items:center;justify-content:center;
}
.sc-icon svg{width:16px;height:16px;stroke:var(--gold);fill:none;stroke-width:1.8}
.sc-value{
    font-family:'Cinzel',serif;font-size:clamp(1.5rem,3vw,2rem);font-weight:700;
    background:linear-gradient(135deg,var(--gold-light),var(--gold));
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    line-height:1;margin-bottom:10px;
}
.sc-change{display:flex;align-items:center;gap:5px;font-size:.8rem}
.sc-change.up{color:var(--green)}
.sc-change.down{color:var(--red)}
.sc-change svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2}
.sc-bar{height:3px;background:var(--bb);border-radius:2px;margin-top:14px;overflow:hidden}
.sc-bar-fill{height:100%;border-radius:2px;background:linear-gradient(90deg,var(--gold-dark),var(--gold-light));width:0;transition:width 1.2s var(--ease)}

/* â”€â”€ MAIN GRID (chart + side) â”€â”€ */
.main-grid{display:grid;grid-template-columns:1fr 340px;gap:18px;margin-bottom:24px}

/* Chart card */
.chart-card{
    background:var(--bc);border:1px solid var(--bb);border-radius:3px;
    padding:24px;
    opacity:0;transform:translateY(16px);
    animation:cardIn .65s var(--ease) .15s forwards;
}
.card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px}
.card-title{
    font-family:'Cinzel',serif;font-size:.78rem;font-weight:700;
    letter-spacing:.12em;text-transform:uppercase;color:var(--white);
    display:flex;align-items:center;gap:10px;
}
.card-title::before{
    content:'';display:block;width:3px;height:16px;
    background:linear-gradient(180deg,var(--gold-light),var(--gold));
    border-radius:2px;
}
.card-filters{display:flex;gap:6px}
.cf-btn{
    padding:5px 12px;font-family:'Cinzel',serif;font-size:.55rem;
    letter-spacing:.14em;text-transform:uppercase;
    background:transparent;border:1px solid var(--bb);border-radius:2px;
    color:var(--wf);cursor:pointer;transition:all .25s;
}
.cf-btn:hover,.cf-btn.active{border-color:var(--gold);color:var(--gold);background:var(--gold-muted)}

/* Fake SVG chart */
.chart-wrap{width:100%;height:200px;position:relative}
.chart-svg{width:100%;height:100%}
.chart-grid-line{stroke:#1e1e1e;stroke-width:1}
.chart-area{fill:url(#chartGrad);opacity:.6}
.chart-line{fill:none;stroke:url(#lineGrad);stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
.chart-dot{fill:var(--gold);stroke:var(--bc);stroke-width:2}

/* Activity / quick stats side */
.side-stack{display:flex;flex-direction:column;gap:18px}

/* Activity feed */
.activity-card{
    background:var(--bc);border:1px solid var(--bb);border-radius:3px;
    padding:20px;flex:1;
    opacity:0;transform:translateY(16px);
    animation:cardIn .65s var(--ease) .2s forwards;
}
.activity-list{display:flex;flex-direction:column;gap:2px;max-height:280px;overflow-y:auto}
.activity-list::-webkit-scrollbar{width:3px}
.activity-list::-webkit-scrollbar-thumb{background:var(--bb)}
.act-item{
    display:flex;align-items:flex-start;gap:12px;
    padding:10px;border-radius:2px;
    transition:background .25s;
}
.act-item:hover{background:rgba(255,255,255,.02)}
.act-dot{
    width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:5px;
}
.act-dot.gold{background:var(--gold)}
.act-dot.green{background:var(--green)}
.act-dot.blue{background:var(--blue)}
.act-dot.red{background:var(--red)}
.act-text{font-size:.88rem;color:var(--wf);line-height:1.5}
.act-text strong{color:var(--wd);font-weight:600;font-style:normal}
.act-time{font-family:'Cinzel',serif;font-size:.55rem;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.22);margin-top:2px}

/* â”€â”€ BOTTOM GRID (table + quick actions) â”€â”€ */
.bottom-grid{display:grid;grid-template-columns:1fr 280px;gap:18px;margin-bottom:24px}

/* Table card */
.table-card{
    background:var(--bc);border:1px solid var(--bb);border-radius:3px;
    overflow:hidden;
    opacity:0;transform:translateY(16px);
    animation:cardIn .65s var(--ease) .25s forwards;
}
.table-card .card-header{padding:20px 24px 0}
.data-table{width:100%;border-collapse:collapse}
.data-table th{
    padding:10px 16px;font-family:'Cinzel',serif;font-size:.58rem;
    letter-spacing:.16em;text-transform:uppercase;color:var(--wf);
    border-bottom:1px solid var(--bb);text-align:left;background:rgba(255,255,255,.01);
}
.data-table td{
    padding:13px 16px;font-size:.9rem;color:var(--wd);
    border-bottom:1px solid rgba(255,255,255,.04);
    transition:background .2s;
}
.data-table tr:last-child td{border-bottom:none}
.data-table tbody tr:hover td{background:rgba(212,160,23,.03)}
.td-avatar{
    width:30px;height:30px;border-radius:2px;flex-shrink:0;
    background:linear-gradient(135deg,var(--gold-dark),var(--gold));
    display:flex;align-items:center;justify-content:center;
    font-family:'Cinzel',serif;font-size:.62rem;font-weight:700;color:#060606;
}
.td-user{display:flex;align-items:center;gap:10px}
.td-name{font-weight:600;color:var(--white);font-size:.88rem}
.td-email{font-size:.78rem;color:var(--wf)}
.pill{
    display:inline-block;padding:3px 10px;border-radius:10px;
    font-family:'Cinzel',serif;font-size:.55rem;letter-spacing:.1em;text-transform:uppercase;
}
.pill-gold{background:var(--gold-muted);color:var(--gold);border:1px solid rgba(212,160,23,.3)}
.pill-green{background:rgba(34,197,94,.1);color:#4ade80;border:1px solid rgba(34,197,94,.3)}
.pill-blue{background:rgba(59,130,246,.1);color:#93c5fd;border:1px solid rgba(59,130,246,.3)}
.pill-red{background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.3)}

/* Quick actions */
.qa-card{
    background:var(--bc);border:1px solid var(--bb);border-radius:3px;
    padding:20px;
    opacity:0;transform:translateY(16px);
    animation:cardIn .65s var(--ease) .3s forwards;
}
.qa-list{display:flex;flex-direction:column;gap:8px;margin-top:16px}
.qa-btn{
    display:flex;align-items:center;gap:12px;padding:12px 14px;
    background:transparent;border:1px solid var(--bb);border-radius:2px;
    color:var(--wf);cursor:pointer;text-align:left;width:100%;
    font-family:'Cinzel',serif;font-size:.62rem;letter-spacing:.1em;text-transform:uppercase;
    transition:border-color .25s,color .25s,background .25s,transform .2s;
    position:relative;overflow:hidden;
}
.qa-btn::before{
    content:'';position:absolute;inset:0;
    background:linear-gradient(90deg,var(--gold-muted),transparent);
    transform:translateX(-100%);transition:transform .35s var(--ease);
}
.qa-btn:hover{border-color:rgba(212,160,23,.4);color:var(--gold-light);transform:translateX(3px)}
.qa-btn:hover::before{transform:translateX(0)}
.qa-btn-icon{
    width:28px;height:28px;border-radius:2px;
    background:var(--gold-muted);border:1px solid rgba(212,160,23,.2);
    display:flex;align-items:center;justify-content:center;flex-shrink:0;position:relative;z-index:1;
}
.qa-btn-icon svg{width:13px;height:13px;stroke:var(--gold);fill:none;stroke-width:2}
.qa-btn span{position:relative;z-index:1}

/* â”€â”€ FOOTER â”€â”€ */
.admin-footer{
    padding:16px 28px;background:var(--bc);border-top:1px solid var(--bb);
    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;
    gap:12px;flex-shrink:0;
}
.af-copy{font-size:.78rem;color:rgba(255,255,255,.22)}
.af-copy span{color:var(--gold);opacity:.65}
.af-links{display:flex;gap:18px}
.af-links a{
    font-family:'Cinzel',serif;font-size:.55rem;letter-spacing:.12em;
    text-transform:uppercase;color:rgba(255,255,255,.22);
    text-decoration:none;transition:color .25s;
}
.af-links a:hover{color:var(--gold)}
.af-version{
    font-family:'Cinzel',serif;font-size:.55rem;letter-spacing:.14em;
    text-transform:uppercase;color:rgba(255,255,255,.2);
}

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   RESPONSIVE
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
@media(max-width:1200px){
    .stats-grid{grid-template-columns:repeat(2,1fr)}
    .main-grid{grid-template-columns:1fr}
    .bottom-grid{grid-template-columns:1fr}
}
@media(max-width:900px){
    .sidebar{transform:translateX(-100%)}
    .sidebar.mobile-open{transform:translateX(0);width:var(--sidebar-w)!important}
    .main-area{margin-left:0!important}
    .sb-overlay{display:block}
    .header-date,.header-live{display:none}
    .page-content{padding:16px}
    .stats-grid{grid-template-columns:repeat(2,1fr);gap:12px}
    .breadcrumb{display:none}
}
@media(max-width:480px){
    .stats-grid{grid-template-columns:1fr}
    .page-title-row{flex-direction:column}
}

/* Inner admin pages (courses, enrollments, etc.) */
.admin-alert{padding:14px 18px;margin-bottom:20px;border-radius:3px;border-left:3px solid var(--gold);background:var(--gold-muted);color:var(--gold-light);font-size:.9rem}
.admin-alert-success{border-left-color:var(--green);background:rgba(34,197,94,.08);color:#86efac}
</style>
@stack('styles')
</head>
<body>

{{-- â•â• SIDEBAR OVERLAY (mobile) â•â• --}}
<div class="sb-overlay" id="sbOverlay"></div>

{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
     SIDEBAR
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<aside class="sidebar" id="sidebar" aria-label="Admin Navigation">

    {{-- Logo --}}
    <a href="{{ url('/admin/dashboard') }}" class="sb-logo">
        <span class="sb-logo-icon">
            <svg width="26" height="26" viewBox="0 0 28 28" fill="none">
                <polygon points="14,2 26,8 26,20 14,26 2,20 2,8" stroke="#D4A017" stroke-width="1.5" fill="none"/>
                <polygon points="14,6 22,10 22,18 14,22 6,18 6,10" fill="#D4A017" opacity="0.15"/>
                <text x="14" y="18" text-anchor="middle" font-family="serif" font-size="11" fill="#D4A017" font-weight="bold">â‚¿</text>
            </svg>
        </span>
        <span class="sb-logo-text">
            <span class="sb-logo-c">Crypto</span><span class="sb-logo-o">Only</span>
        </span>
    </a>

    {{-- Navigation --}}
    <nav class="sb-nav" role="navigation">

        <div class="sb-label">Main</div>

        <a href="{{ route('admin.dashboard') }}" class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            <span class="sb-item-text">Dashboard</span>
        </a>
        <a href="{{ url('/admin/users') }}" class="sb-item">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            <span class="sb-item-text">Members</span>
            <span class="sb-badge">320K</span>
        </a>

        <div class="sb-label">Services</div>

        <a href="{{ route('enrollments.admin') }}" class="sb-item {{ request()->routeIs('enrollments.*') ? 'active' : '' }}">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><path d="M3 18h18M5 18l-1-9 5 4 3-7 3 7 5-4-1 9H5z" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span class="sb-item-text">Premium Group</span>
        </a>
        <a href="{{ route('courses.index') }}" class="sb-item {{ request()->routeIs('courses.index') || request()->routeIs('courses.create') || request()->routeIs('courses.show') || request()->routeIs('courses.edit') ? 'active' : '' }}">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3.33 1.67 8.67 1.67 12 0v-5"/></svg>
            <span class="sb-item-text">Paid Courses</span>
            @php $courseCount = \App\Models\Course::count(); @endphp
            @if($courseCount > 0)<span class="sb-badge">{{ $courseCount }}</span>@endif
        </a>
        <a href="{{ route('admin.course-videos.index') }}" class="sb-item {{ request()->routeIs('admin.course-videos.*') ? 'active' : '' }}">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
            <span class="sb-item-text">Upload Videos</span>
        </a>
        <a href="{{ route('course-enrollments.admin') }}" class="sb-item {{ request()->routeIs('course-enrollments.*') ? 'active' : '' }}">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            <span class="sb-item-text">Course Students</span>
        </a>
        <a href="{{ route('admin.live-sessions.index') }}" class="sb-item {{ request()->routeIs('admin.live-sessions.*') ? 'active' : '' }}">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><rect x="2" y="7" width="15" height="10" rx="1"/><path d="M17 9l5-2v10l-5-2V9z"/></svg>
            <span class="sb-item-text">Live Sessions</span>
        </a>
        <a href="{{ url('/admin/p2p') }}" class="sb-item">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><path d="M17 1l4 4-4 4M3 11V9a4 4 0 014-4h14M7 23l-4-4 4-4M21 13v2a4 4 0 01-4 4H3"/></svg>
            <span class="sb-item-text">P2P Trading</span>
        </a>

        <div class="sb-label">Content</div>

        <a href="{{ url('/admin/slider') }}" class="sb-item">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M8 10l4-4 4 4M8 14l4 4 4-4"/></svg>
            <span class="sb-item-text">Hero Slider</span>
        </a>
        <a href="{{ url('/admin/blog') }}" class="sb-item">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <span class="sb-item-text">Blog & News</span>
        </a>
        <a href="{{ url('/admin/signals') }}" class="sb-item">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <span class="sb-item-text">Signals</span>
            <span class="sb-badge">Live</span>
        </a>

        <div class="sb-label">System</div>

        <a href="{{ url('/admin/settings') }}" class="sb-item">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
            <span class="sb-item-text">Settings</span>
        </a>
        <a href="{{ route('admin.logout') }}" class="sb-item"
           onclick="event.preventDefault();document.getElementById('logout-form').submit()">
            <svg class="sb-item-icon" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
            <span class="sb-item-text">Sign Out</span>
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none">@csrf</form>

    </nav>

    {{-- Admin user --}}
    <div class="sb-user">
        <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
        <div class="sb-user-info">
            <div class="sb-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="sb-user-role">Super Admin</div>
        </div>
    </div>

</aside>

{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
     MAIN AREA
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div class="main-area" id="mainArea">

    {{-- â”€â”€ TOP HEADER â”€â”€ --}}
    <header class="top-header">
        <button class="toggle-btn" id="toggleBtn" aria-label="Toggle sidebar">
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
        </button>

        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Admin</a>
            <span>/</span>
            <span>@yield('breadcrumb', 'Dashboard')</span>
        </nav>

        <div class="header-actions">
            <div class="header-date" id="headerDate">â€”</div>

            <button class="h-action-btn" aria-label="Search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
            <button class="h-action-btn" aria-label="Notifications">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                <span class="h-notif-dot" aria-hidden="true"></span>
            </button>
            <button class="h-action-btn" aria-label="Messages">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            </button>

            <div class="header-live">
                <span class="live-dot" aria-hidden="true"></span>
                Live
            </div>
        </div>
    </header>

    {{-- â”€â”€ PAGE CONTENT â”€â”€ --}}
    <main class="page-content" role="main">
        @hasSection('page_title')
        <div class="page-title-row">
            <div class="page-title-block">
                <div class="page-eyebrow">@yield('page_eyebrow', 'Management')</div>
                <h1 class="page-title">@yield('page_title')</h1>
            </div>
            @hasSection('page_actions')
            <div class="page-title-actions">@yield('page_actions')</div>
            @endif
        </div>
        @endif

        @if(session('success'))
            <div class="admin-alert admin-alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="admin-alert" style="border-left-color:var(--red);background:rgba(239,68,68,.08);color:#fca5a5">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="admin-alert" style="border-left-color:var(--red)">
                <strong>Please fix the following:</strong>
                <ul style="margin:8px 0 0 18px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        @yield('content')

    </main>

    {{-- â”€â”€ FOOTER â”€â”€ --}}
    <footer class="admin-footer">
        <p class="af-copy">&copy; {{ date('Y') }} <span>CryptoOnly</span> Admin Panel. All rights reserved.</p>
        <nav class="af-links" aria-label="Admin footer links">
            <a href="{{ url('/admin/settings') }}">Settings</a>
            <a href="{{ url('/admin/help') }}">Help</a>
            <a href="{{ url('/') }}" target="_blank">View Site</a>
        </nav>
        <span class="af-version">v2.4.1</span>
    </footer>

</div>

<script>
(function(){
    var sidebar = document.getElementById('sidebar');
    var mainArea = document.getElementById('mainArea');
    var toggleBtn = document.getElementById('toggleBtn');
    var overlay = document.getElementById('sbOverlay');
    var collapsed = false;
    var mobileOpen = false;
    var isMobile = window.innerWidth <= 900;

    function setDate(){
        var d = new Date();
        var opts = {weekday:'short',month:'short',day:'numeric'};
        var el = document.getElementById('headerDate');
        if(el) el.textContent = d.toLocaleDateString('en-US',opts).toUpperCase();
    }
    setDate();

    toggleBtn.addEventListener('click', function(){
        isMobile = window.innerWidth <= 900;
        if(isMobile){
            mobileOpen = !mobileOpen;
            sidebar.classList.toggle('mobile-open', mobileOpen);
            overlay.classList.toggle('show', mobileOpen);
            toggleBtn.classList.toggle('active', mobileOpen);
        } else {
            collapsed = !collapsed;
            sidebar.classList.toggle('collapsed', collapsed);
            mainArea.classList.toggle('expanded', collapsed);
            toggleBtn.classList.toggle('active', collapsed);
        }
    });

    overlay.addEventListener('click', function(){
        mobileOpen = false;
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('show');
        toggleBtn.classList.remove('active');
    });

    window.addEventListener('resize', function(){
        isMobile = window.innerWidth <= 900;
        if(!isMobile && mobileOpen){
            mobileOpen = false;
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('show');
        }
    });

    // Chart filter buttons
    document.querySelectorAll('.cf-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            document.querySelectorAll('.cf-btn').forEach(function(b){ b.classList.remove('active'); });
            btn.classList.add('active');
        });
    });

    // Animate progress bars
    setTimeout(function(){
        document.querySelectorAll('.sc-bar-fill').forEach(function(bar){
            bar.style.width = (bar.dataset.w || '50') + '%';
        });
    }, 400);

})();
</script>
@stack('scripts')
</body>
</html>
