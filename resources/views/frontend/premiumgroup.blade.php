<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Group Enrollment</title>
    <style>
:root{--gold:#C9A84C;--gold-light:#E8C97A;--gold-dim:#7a6230;--black:#0d0d0d;--card:#161616;--border:rgba(201,168,76,0.18);--border-h:rgba(201,168,76,0.5);--text:#D8D0C0;--muted:#7a7060;--red:#C0392B}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--black);color:var(--text);font-family:Georgia,serif;font-size:14px}
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Pro:ital,wght@0,300;0,400;1,300&display=swap');
.wrap{padding:28px 20px 40px;background:var(--black);min-height:100vh}
.hd{text-align:center;margin-bottom:24px;animation:fd .8s ease both}
.tag{display:inline-block;font-family:Cinzel,serif;font-size:9px;letter-spacing:.22em;color:var(--gold);border:1px solid var(--border);padding:4px 14px;margin-bottom:10px}
.hd h1{font-family:Cinzel,serif;font-size:clamp(1.4rem,4vw,2.2rem);color:#fff;margin-bottom:8px}
.hd h1 em{color:var(--gold);font-style:normal;display:inline-block;border-bottom:1px solid var(--gold);padding-bottom:2px}
.prices{display:flex;align-items:center;justify-content:center;gap:12px;font-family:Cinzel,serif}
.old{font-size:1.1rem;color:var(--muted);text-decoration:line-through;text-decoration-color:var(--red)}
.new{font-size:1.6rem;color:var(--gold-light);font-weight:700}
.div{display:flex;align-items:center;gap:10px;margin:20px 0}
.div span{flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--gold-dim))}
.div span:last-child{background:linear-gradient(270deg,transparent,var(--gold-dim))}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;animation:fu .7s .2s ease both}
@media(max-width:600px){.grid{grid-template-columns:1fr}}
.panel{background:var(--card);border:1px solid var(--border);padding:24px;position:relative;transition:border-color .3s}
.panel:hover{border-color:var(--border-h)}
.panel::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--gold),transparent);opacity:0;transition:opacity .3s}
.panel:hover::before{opacity:1}
.ptitle{font-family:Cinzel,serif;font-size:8px;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);margin-bottom:18px;display:flex;align-items:center;gap:8px}
.ptitle::after{content:'';flex:1;height:1px;background:var(--border)}
.bb{background:rgba(201,168,76,.04);border:1px solid var(--border);border-left:3px solid var(--gold);padding:14px 16px;margin-bottom:12px;transition:background .3s}
.bb:hover{background:rgba(201,168,76,.09)}
.bname{font-family:Cinzel,serif;font-size:8px;letter-spacing:.14em;color:var(--gold);margin-bottom:7px;text-transform:uppercase}
.br{display:flex;gap:8px;margin-bottom:4px;font-size:.78rem}
.br .lb{color:var(--muted);min-width:52px;font-style:italic}
.notice{background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.22);padding:12px 14px;margin-top:16px;font-size:.78rem}
.notice p{color:#e07b73;margin-bottom:3px}
.notice .ct{color:var(--gold);font-family:Cinzel,serif;font-size:.74rem;margin-top:6px}
.proc{font-size:.82rem;color:var(--muted);line-height:1.65;margin-bottom:18px;font-style:italic}
.frow{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px}
.field{display:flex;flex-direction:column;gap:4px;margin-bottom:10px}
.field label{font-family:Cinzel,serif;font-size:7.5px;letter-spacing:.17em;text-transform:uppercase;color:var(--muted)}
.field label .req{color:var(--gold);margin-left:1px}
input,select{background:rgba(255,255,255,.03);border:1px solid var(--border);color:var(--text);padding:8px 10px;font-size:.85rem;outline:none;width:100%;transition:border-color .25s,background .25s}
input:focus,select:focus{border-color:var(--gold-dim);background:rgba(201,168,76,.05)}
select{cursor:pointer}
select option{background:#1a1a1a}
.ph{display:flex}
.pfx{background:rgba(201,168,76,.1);border:1px solid var(--border);border-right:none;padding:8px 8px;color:var(--gold);font-family:Cinzel,serif;font-size:.74rem;white-space:nowrap}
.ph input{border-left:none}
.cg{display:flex;flex-direction:column;gap:7px}
.ci{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.82rem}
.ci input{width:14px;height:14px;accent-color:var(--gold);cursor:pointer;flex-shrink:0}
.fgl{font-family:Cinzel,serif;font-size:7.5px;letter-spacing:.17em;text-transform:uppercase;color:var(--muted);margin-bottom:8px;display:block}
.fl{border:1px dashed var(--border);padding:10px 12px;display:flex;align-items:center;gap:10px;cursor:pointer;background:rgba(255,255,255,.02);font-size:.82rem;color:var(--muted);transition:border-color .25s,background .25s}
.fl:hover{border-color:var(--gold-dim);background:rgba(201,168,76,.04)}
.fl-icon{color:var(--gold);font-size:1rem}
.btn{width:100%;margin-top:18px;padding:13px 24px;background:transparent;border:1px solid var(--gold);color:var(--gold-light);font-family:Cinzel,serif;font-size:.75rem;letter-spacing:.2em;text-transform:uppercase;cursor:pointer;position:relative;overflow:hidden;transition:color .3s}
.btn::before{content:'';position:absolute;inset:0;background:var(--gold);transform:scaleX(0);transform-origin:left;transition:transform .35s cubic-bezier(.4,0,.2,1);z-index:0}
.btn:hover::before{transform:scaleX(1)}
.btn:hover{color:var(--black)}
.btn span{position:relative;z-index:1}
@keyframes fd{from{opacity:0;transform:translateY(-22px)}to{opacity:1;transform:translateY(0)}}
@keyframes fu{from{opacity:0;transform:translateY(26px)}to{opacity:1;transform:translateY(0)}}
    </style>
</head>
<body>

<div class="wrap">
  <header class="hd">
    <div class="tag">◆ Trade Campus ◆</div>
    <h1>Enroll for <em>Batch-23</em></h1>
    <div class="prices"><span class="old">$250</span><span class="new">$200</span></div>
    <div style="color:var(--muted);font-size:.74rem;margin-top:6px;font-style:italic">*Terms & Conditions Apply</div>
  </header>
  <div class="div"><span></span><span style="color:var(--gold);font-size:8px">◆</span><span></span></div>
  <div class="grid">
    <div class="panel">
      <div class="ptitle">Payment Details</div>
      <p class="proc">Pay $200 in favour of <strong style="color:var(--text)">Trade Campus</strong> and attach payment proof. Team contacts you within <strong style="color:var(--gold)">48 hours</strong> via email or WhatsApp.</p>
      <div class="bb">
        <div class="bname">🏦 Meezan Bank — Tulsa Road</div>
        <div class="br"><span class="lb">IBAN</span><span>PK88MEZN0008230109103971</span></div>
        <div class="br"><span class="lb">Title</span><span>BADAR TANVIR ENTERPRISES (SMC-PRIVATE) LTD</span></div>
        <div class="br"><span class="lb">SWIFT</span><span>MEZNPKKA</span></div>
      </div>
      <div class="bb">
        <div class="bname">🔶 Binance Pay</div>
        <div class="br"><span class="lb">Pay ID</span><span>81442671</span></div>
        <div class="br"><span class="lb">TRC20</span><span style="font-size:.72rem">TX9cFkKCu3hLfmoLnAkuZtBX5MqHiSb6oh</span></div>
      </div>
      <div class="notice">
        <p>⚠ After payment, wait <strong>48 hours</strong> for verification.</p>
        <p>For delays or issues, contact:</p>
        <div class="ct">📲 +92 333 9073110</div>
      </div>
    </div>
    <div class="panel">
      <div class="ptitle">Enrollment Form</div>
      <div class="frow">
        <div class="field"><label>First Name <span class="req">*</span></label><input type="text" placeholder="John"></div>
        <div class="field"><label>Last Name</label><input type="text" placeholder="Doe"></div>
      </div>
      <div class="field"><label>Email Address <span class="req">*</span></label><input type="email" placeholder="john@doe.com"></div>
      <div class="field"><label>WhatsApp Number <span class="req">*</span></label>
        <div class="ph"><span class="pfx">🇵🇰 +92</span><input type="tel" placeholder="3001234567"></div>
      </div>
      <div class="field"><label>Country <span class="req">*</span></label>
        <select><option value="">Select country</option><option>Pakistan</option><option>UAE</option><option>Saudi Arabia</option><option>United Kingdom</option><option>Other</option></select>
      </div>
      <div class="field" style="margin-bottom:14px">
        <span class="fgl">Experience</span>
        <div class="cg">
          <label class="ci"><input type="radio" name="exp" value="lt6"> Less than 6 months <em style="color:var(--muted);font-size:.78rem">(Beginners welcome)</em></label>
          <label class="ci"><input type="radio" name="exp" value="gt6"> More than 6 months</label>
        </div>
      </div>
      <div class="field" style="margin-bottom:14px">
        <span class="fgl">Enrolling For</span>
        <label class="ci"><input type="radio" name="type" checked> Online Lectures — $200</label>
      </div>
      <div class="field"><label>Select Course <span class="req">*</span></label>
        <select><option>Advanced Liquidity Bootcamp Batch 23</option></select>
      </div>
      <div class="field"><label>Screenshot of Payment <span class="req">*</span></label>
        <div class="fl"><span class="fl-icon">📎</span><div><div>Click to attach payment proof</div><div style="color:var(--muted);font-size:.75rem">No file chosen</div></div></div>
      </div>
      <button class="btn"><span>Submit Enrollment →</span></button>
    </div>
  </div>
</div>
</body>
</html>
