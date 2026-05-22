<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>P2P Trading — Register</title>
  <link rel="icon" type="image/svg+xml" href="/favicon.svg">
  <style>
    :root{--gold:#C9A84C;--gold-light:#E8C97A;--gold-dim:#7a6230;--black:#0d0d0d;--card:#161616;--border:rgba(201,168,76,.18);--border-h:rgba(201,168,76,.5);--text:#D8D0C0;--muted:#7a7060;--red:#C0392B}
    *{box-sizing:border-box;margin:0;padding:0}
    body{background:var(--black);color:var(--text);font-family:Georgia,serif;font-size:14px}
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Pro:ital,wght@0,300;0,400;1,300&display=swap');
    .wrap{padding:28px 20px 60px;min-height:100vh}
    .hd{text-align:center;margin-bottom:24px;animation:fd .8s ease both}
    .tag{display:inline-block;font-family:Cinzel,serif;font-size:9px;letter-spacing:.22em;color:var(--gold);border:1px solid var(--border);padding:4px 14px;margin-bottom:10px}
    .hd h1{font-family:Cinzel,serif;font-size:clamp(1.4rem,4vw,2.2rem);color:#fff;margin-bottom:8px}
    .hd h1 em{color:var(--gold);font-style:normal;display:inline-block;border-bottom:1px solid var(--gold);padding-bottom:2px}
    .hd p{color:var(--muted);font-size:.88rem;font-style:italic}
    .div{display:flex;align-items:center;gap:10px;margin:20px 0}
    .div span{flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--gold-dim))}
    .div span:last-child{background:linear-gradient(270deg,transparent,var(--gold-dim))}
    .grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;animation:fu .7s .2s ease both}
    @media(max-width:640px){.grid{grid-template-columns:1fr}}
    .panel{background:var(--card);border:1px solid var(--border);padding:24px;position:relative;transition:border-color .3s}
    .panel:hover{border-color:var(--border-h)}
    .panel::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--gold),transparent);opacity:0;transition:opacity .3s}
    .panel:hover::before{opacity:1}
    .ptitle{font-family:Cinzel,serif;font-size:8px;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);margin-bottom:18px;display:flex;align-items:center;gap:8px}
    .ptitle::after{content:'';flex:1;height:1px;background:var(--border)}
    .bb{background:rgba(201,168,76,.04);border:1px solid var(--border);border-left:3px solid var(--gold);padding:14px 16px;margin-bottom:12px}
    .bname{font-family:Cinzel,serif;font-size:8px;letter-spacing:.14em;color:var(--gold);margin-bottom:7px;text-transform:uppercase}
    .br{display:flex;gap:8px;margin-bottom:4px;font-size:.78rem}
    .br .lb{color:var(--muted);min-width:52px;font-style:italic}
    .notice{background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.22);padding:12px 14px;margin-top:16px;font-size:.78rem}
    .notice p{color:#e07b73;margin-bottom:3px}
    .notice .ct{color:var(--gold);font-family:Cinzel,serif;font-size:.74rem;margin-top:6px}
    .frow{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px}
    @media(max-width:500px){.frow{grid-template-columns:1fr}}
    .field{display:flex;flex-direction:column;gap:4px;margin-bottom:10px}
    .field label{font-family:Cinzel,serif;font-size:7.5px;letter-spacing:.17em;text-transform:uppercase;color:var(--muted)}
    .field label .req{color:var(--gold);margin-left:1px}
    input,select{background:rgba(255,255,255,.03);border:1px solid var(--border);color:var(--text);padding:8px 10px;font-size:.85rem;outline:none;width:100%;transition:border-color .25s,background .25s}
    input:focus,select:focus{border-color:var(--gold-dim);background:rgba(201,168,76,.05)}
    select option{background:#1a1a1a}
    .ph{display:flex}
    .pfx{background:rgba(201,168,76,.1);border:1px solid var(--border);border-right:none;padding:8px;color:var(--gold);font-family:Cinzel,serif;font-size:.74rem;white-space:nowrap}
    .ph input{border-left:none}
    .fl{border:1px dashed var(--border);padding:10px 12px;display:flex;align-items:center;gap:10px;cursor:pointer;background:rgba(255,255,255,.02);font-size:.82rem;color:var(--muted);transition:border-color .25s,background .25s}
    .fl:hover{border-color:var(--gold-dim);background:rgba(201,168,76,.04)}
    .fl-icon{color:var(--gold);font-size:1rem}
    .btn{width:100%;margin-top:18px;padding:13px 24px;background:transparent;border:1px solid var(--gold);color:var(--gold-light);font-family:Cinzel,serif;font-size:.75rem;letter-spacing:.2em;text-transform:uppercase;cursor:pointer;position:relative;overflow:hidden;transition:color .3s}
    .btn::before{content:'';position:absolute;inset:0;background:var(--gold);transform:scaleX(0);transform-origin:left;transition:transform .35s cubic-bezier(.4,0,.2,1);z-index:0}
    .btn:hover::before{transform:scaleX(1)}
    .btn:hover{color:var(--black)}
    .btn span{position:relative;z-index:1}
    .error-text{color:var(--red);font-size:.75rem;margin-top:4px;display:block}
    .help-hint{color:var(--muted);font-size:.75rem;margin-top:4px;font-style:italic;display:block}
    @keyframes fd{from{opacity:0;transform:translateY(-22px)}to{opacity:1;transform:translateY(0)}}
    @keyframes fu{from{opacity:0;transform:translateY(26px)}to{opacity:1;transform:translateY(0)}}
  </style>
</head>
<body>
<div class="wrap">

  <header class="hd">
    <div class="tag">◆ Dollar Bull University ◆</div>
    <h1>Join <em>P2P Trading</em></h1>
    <p>Register to access our exclusive P2P trading community</p>
  </header>

  <div class="div"><span></span><span style="color:var(--gold);font-size:8px">◆</span><span></span></div>

  <div class="grid">

    {{-- Left: Payment info --}}
    <div class="panel">
      <div class="ptitle">Payment Details</div>
      <p style="font-size:.82rem;color:var(--muted);line-height:1.65;margin-bottom:18px;font-style:italic">
        Pay the registration fee and attach your payment proof. Our team will contact you within
        <strong style="color:var(--gold)">48 hours</strong> via email or WhatsApp.
      </p>

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

    {{-- Right: Registration form --}}
    <div class="panel">
      <div class="ptitle">Registration Form</div>

      <form method="POST" action="{{ route('p2p.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="frow">
          <div class="field">
            <label>First Name <span class="req">*</span></label>
            <input type="text" name="first_name" placeholder="John" value="{{ old('first_name') }}" required>
            @error('first_name')<span class="error-text">{{ $message }}</span>@enderror
          </div>
          <div class="field">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Doe" value="{{ old('last_name') }}">
          </div>
        </div>

        <div class="field">
          <label>Email Address <span class="req">*</span></label>
          <input type="email" name="email" placeholder="john@example.com" value="{{ old('email') }}" required>
          @error('email')<span class="error-text">{{ $message }}</span>@enderror
        </div>

        <div class="frow">
          <div class="field">
            <label>WhatsApp Number <span class="req">*</span></label>
            <div class="ph">
              <span class="pfx">+</span>
              <input type="tel" name="whatsapp_number" placeholder="923001234567" value="{{ old('whatsapp_number') }}" required>
            </div>
            <span class="help-hint">Include country code</span>
            @error('whatsapp_number')<span class="error-text">{{ $message }}</span>@enderror
          </div>

          <div class="field">
            <label>Country <span class="req">*</span></label>
            <select name="country" required>
              <option value="">Select country</option>
              @foreach(['Afghanistan','Albania','Algeria','Argentina','Australia','Austria','Azerbaijan','Bahrain','Bangladesh','Belgium','Bolivia','Brazil','Canada','Chile','China','Colombia','Croatia','Cyprus','Czech Republic','Denmark','Egypt','Ethiopia','Finland','France','Germany','Ghana','Greece','Guatemala','Hungary','India','Indonesia','Iran','Iraq','Ireland','Israel','Italy','Jamaica','Japan','Jordan','Kazakhstan','Kenya','Kuwait','Kyrgyzstan','Latvia','Lebanon','Libya','Lithuania','Luxembourg','Malaysia','Maldives','Mali','Malta','Mexico','Moldova','Morocco','Myanmar','Nepal','Netherlands','New Zealand','Nigeria','Norway','Oman','Pakistan','Palestine','Panama','Peru','Philippines','Poland','Portugal','Qatar','Romania','Russia','Rwanda','Saudi Arabia','Senegal','Serbia','Singapore','Slovakia','Slovenia','Somalia','South Africa','South Korea','Spain','Sri Lanka','Sudan','Sweden','Switzerland','Syria','Taiwan','Tanzania','Thailand','Tunisia','Turkey','Uganda','Ukraine','United Arab Emirates','United Kingdom','United States','Uruguay','Uzbekistan','Venezuela','Vietnam','Yemen','Zambia','Zimbabwe'] as $c)
                <option value="{{ $c }}" {{ old('country') === $c ? 'selected' : '' }}>{{ $c }}</option>
              @endforeach
            </select>
            @error('country')<span class="error-text">{{ $message }}</span>@enderror
          </div>
        </div>

        <div class="field">
          <label>Exchange Used (e.g. Binance, Bybit)</label>
          <input type="text" name="exchange" placeholder="Binance" value="{{ old('exchange') }}">
        </div>

        <div class="field">
          <label>Payment Screenshot <span class="req">*</span></label>
          <div class="fl" id="fileInput">
            <span class="fl-icon">📎</span>
            <div>
              <div>Click to attach payment proof</div>
              <div style="color:var(--muted);font-size:.75rem" id="fileName">No file chosen</div>
            </div>
          </div>
          <input type="file" name="payment_screenshot" id="paymentFile" style="display:none" accept="image/*" required>
          @error('payment_screenshot')<span class="error-text">{{ $message }}</span>@enderror
        </div>

        @if($errors->any())
          <div style="background:rgba(192,57,43,.1);border:1px solid rgba(192,57,43,.3);border-left:3px solid var(--red);padding:12px;margin:16px 0;color:#e07b73;font-size:.85rem">
            <strong>Please fix the errors above:</strong>
            <ul style="margin-left:20px;margin-top:8px">
              @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
          </div>
        @endif

        <button type="submit" class="btn"><span>Submit Registration →</span></button>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById('fileInput').addEventListener('click', function () {
    document.getElementById('paymentFile').click();
  });
  document.getElementById('paymentFile').addEventListener('change', function () {
    document.getElementById('fileName').textContent = this.files[0]?.name || 'No file chosen';
  });
</script>
</body>
</html>
