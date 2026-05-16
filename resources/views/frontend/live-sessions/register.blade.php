@extends('layouts.frontend')

@section('title', 'Register — ' . $session->title)

@push('styles')
<style>
  :root {
    --gold: #C9A84C; --gold-light: #E8C97A; --gold-dim: #7a6230;
    --black: #0d0d0d; --card: #161616;
    --border: rgba(201,168,76,.18); --border-h: rgba(201,168,76,.5);
    --text: #D8D0C0; --muted: #7a7060; --red: #C0392B
  }
  * { box-sizing: border-box; margin: 0; padding: 0 }
  body { background: var(--black); color: var(--text); font-family: Georgia, serif; font-size: 14px }
  .wrap { padding: 28px 20px 40px; background: var(--black); min-height: 100vh }
  .hd { text-align: center; margin-bottom: 24px; animation: fd .8s ease both }
  .tag { display: inline-block; font-family: Cinzel, serif; font-size: 9px; letter-spacing: .22em; color: var(--gold); border: 1px solid var(--border); padding: 4px 14px; margin-bottom: 10px }
  .hd h1 { font-family: Cinzel, serif; font-size: clamp(1.4rem,4vw,2.2rem); color: #fff; margin-bottom: 8px }
  .hd h1 em { color: var(--gold); font-style: normal; border-bottom: 1px solid var(--gold); padding-bottom: 2px }
  .div { display: flex; align-items: center; gap: 10px; margin: 20px 0 }
  .div span { flex: 1; height: 1px; background: linear-gradient(90deg,transparent,var(--gold-dim)) }
  .div span:last-child { background: linear-gradient(270deg,transparent,var(--gold-dim)) }
  .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; animation: fu .7s .2s ease both }
  @media(max-width:600px) { .grid { grid-template-columns: 1fr } }
  .panel { background: var(--card); border: 1px solid var(--border); padding: 24px; position: relative; transition: border-color .3s }
  .panel:hover { border-color: var(--border-h) }
  .panel::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,transparent,var(--gold),transparent); opacity:0; transition:opacity .3s }
  .panel:hover::before { opacity:1 }
  .ptitle { font-family: Cinzel, serif; font-size: 8px; letter-spacing: .22em; text-transform: uppercase; color: var(--gold); margin-bottom: 18px; display: flex; align-items: center; gap: 8px }
  .ptitle::after { content:''; flex:1; height:1px; background:var(--border) }
  .bb { background: rgba(201,168,76,.04); border: 1px solid var(--border); border-left: 3px solid var(--gold); padding: 14px 16px; margin-bottom: 12px; transition: background .3s }
  .bb:hover { background: rgba(201,168,76,.09) }
  .bname { font-family: Cinzel, serif; font-size: 8px; letter-spacing: .14em; color: var(--gold); margin-bottom: 7px; text-transform: uppercase }
  .br { display: flex; gap: 8px; margin-bottom: 4px; font-size: .78rem }
  .br .lb { color: var(--muted); min-width: 52px; font-style: italic }
  .notice { background: rgba(192,57,43,.08); border: 1px solid rgba(192,57,43,.22); padding: 12px 14px; margin-top: 16px; font-size: .78rem }
  .notice p { color: #e07b73; margin-bottom: 3px }
  .notice .ct { color: var(--gold); font-family: Cinzel, serif; font-size: .74rem; margin-top: 6px }
  .proc { font-size: .82rem; color: var(--muted); line-height: 1.65; margin-bottom: 18px; font-style: italic }
  .frow { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px }
  @media(max-width:600px) { .frow { grid-template-columns: 1fr } }
  .field { display: flex; flex-direction: column; gap: 4px; margin-bottom: 10px }
  .field label { font-family: Cinzel, serif; font-size: 7.5px; letter-spacing: .17em; text-transform: uppercase; color: var(--muted) }
  .field label .req { color: var(--gold); margin-left: 1px }
  input, select { background: rgba(255,255,255,.03); border: 1px solid var(--border); color: var(--text); padding: 8px 10px; font-size: .85rem; outline: none; width: 100%; transition: border-color .25s, background .25s }
  input:focus, select:focus { border-color: var(--gold-dim); background: rgba(201,168,76,.05) }
  select { cursor: pointer }
  select option { background: #1a1a1a }
  .ph { display: flex }
  .pfx { background: rgba(201,168,76,.1); border: 1px solid var(--border); border-right: none; padding: 8px; color: var(--gold); font-family: Cinzel, serif; font-size: .74rem; white-space: nowrap }
  .ph input { border-left: none }
  .fl { border: 1px dashed var(--border); padding: 10px 12px; display: flex; align-items: center; gap: 10px; cursor: pointer; background: rgba(255,255,255,.02); font-size: .82rem; color: var(--muted); transition: border-color .25s, background .25s }
  .fl:hover { border-color: var(--gold-dim); background: rgba(201,168,76,.04) }
  .fl-icon { color: var(--gold); font-size: 1rem }
  .btn { width: 100%; margin-top: 18px; padding: 13px 24px; background: transparent; border: 1px solid var(--gold); color: var(--gold-light); font-family: Cinzel, serif; font-size: .75rem; letter-spacing: .2em; text-transform: uppercase; cursor: pointer; position: relative; overflow: hidden; transition: color .3s }
  .btn::before { content:''; position:absolute; inset:0; background:var(--gold); transform:scaleX(0); transform-origin:left; transition:transform .35s cubic-bezier(.4,0,.2,1); z-index:0 }
  .btn:hover::before { transform:scaleX(1) }
  .btn:hover { color: var(--black) }
  .btn span { position: relative; z-index: 1 }
  @keyframes fd { from { opacity:0; transform:translateY(-22px) } to { opacity:1; transform:translateY(0) } }
  @keyframes fu { from { opacity:0; transform:translateY(26px) } to { opacity:1; transform:translateY(0) } }
  .error-text { color: var(--red); font-size: .75rem; margin-top: 4px; display: block }
  .help-hint { color: var(--muted); font-size: .75rem; margin-top: 4px; font-style: italic; display: block }
  .visually-hidden-file { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0 }
  .face-cap { border: 1px dashed var(--border); padding: 14px 12px; text-align: center; cursor: pointer; background: rgba(255,255,255,.02); transition: border-color .25s, background .25s }
  .face-cap:hover { border-color: var(--gold-dim); background: rgba(201,168,76,.04) }
  .face-cap.has-photo { border-color: rgba(201,168,76,.4); border-style: solid }
  .face-cap .fc-icon { color: var(--gold); font-size: 1.4rem; margin-bottom: 6px }
  .face-preview { display: none; max-height: 110px; margin: 10px auto 0; border-radius: 4px; border: 1px solid var(--border) }
  .face-cap.has-photo .face-preview { display: block }
  .face-fallback { margin-top: 8px; background: none; border: none; color: var(--gold-dim); font-size: .72rem; text-decoration: underline; cursor: pointer; font-family: inherit }
  .face-fallback:hover { color: var(--gold-light) }
  .cam-wrap { display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,.92); align-items: center; justify-content: center; padding: 16px }
  .cam-wrap.on { display: flex }
  .cam-panel { background: var(--card); border: 1px solid var(--border); max-width: 520px; width: 100%; padding: 18px }
  .cam-panel h3 { font-family: Cinzel, serif; font-size: .72rem; letter-spacing: .18em; color: var(--gold); text-transform: uppercase; margin-bottom: 12px }
  .cam-panel video { width: 100%; border-radius: 4px; background: #000; max-height: 46vh; object-fit: cover }
  .cam-actions { display: flex; gap: 10px; margin-top: 14px; flex-wrap: wrap; justify-content: center }
  .cam-actions button { font-family: Cinzel, serif; font-size: .65rem; letter-spacing: .14em; text-transform: uppercase; padding: 10px 18px; border: 1px solid var(--border); background: rgba(201,168,76,.08); color: var(--gold-light); cursor: pointer }
  .cam-actions .btn-cap { border-color: var(--gold); color: var(--gold-light) }
  .cam-actions .btn-cancel { color: var(--muted) }
</style>
@endpush

@section('content')
<div class="wrap">
  <p style="margin-bottom:16px"><a href="{{ route('live-sessions.show', $session->id) }}" style="color:var(--gold-light);text-decoration:none;font-size:.85rem">← Back to session</a></p>

  <header class="hd">
    <div class="tag">📡 Live Session Registration</div>
    <h1>Register for <em>{{ $session->title }}</em></h1>
    @if($session->scheduled_at)
      <div style="color:var(--muted);font-size:.82rem;margin-top:6px">{{ $session->scheduled_at->format('l, M j, Y · g:i A') }}</div>
    @endif
  </header>

  <div class="div"><span></span><span style="color:var(--gold);font-size:8px">◆</span><span></span></div>

  <div class="grid">
    {{-- Payment Details --}}
    <div class="panel">
      <div class="ptitle">Payment Details</div>
      <p class="proc">Complete your payment and attach proof below. Our team will contact you within <strong style="color:var(--gold)">48 hours</strong> via email or WhatsApp after verification.</p>
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

    {{-- Registration Form --}}
    <div class="panel">
      <div class="ptitle">Registration Form</div>
      <form method="POST" action="{{ route('live-sessions.register.store', $session->id) }}" enctype="multipart/form-data">
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
            <label>Password <span class="req">*</span></label>
            <input type="password" name="password" required autocomplete="new-password">
            @error('password')<span class="error-text">{{ $message }}</span>@enderror
            <span class="help-hint">Use this to log in after approval</span>
          </div>
          <div class="field">
            <label>Confirm Password <span class="req">*</span></label>
            <input type="password" name="password_confirmation" required autocomplete="new-password">
          </div>
        </div>

        <div class="frow">
          <div class="field">
            <label>WhatsApp Number <span class="req">*</span></label>
            <div class="ph">
              <span class="pfx">+</span>
              <input type="tel" name="whatsapp_number" placeholder="923001234567" value="{{ old('whatsapp_number') }}" required>
            </div>
            <span class="help-hint">Include country code (e.g., 923001234567)</span>
            @error('whatsapp_number')<span class="error-text">{{ $message }}</span>@enderror
          </div>
          <div class="field">
            <label>Country <span class="req">*</span></label>
            <select name="country" required>
              <option value="">Select your country</option>
              @foreach(['Afghanistan','Albania','Algeria','Andorra','Angola','Argentina','Australia','Austria','Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia and Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina Faso','Burundi','Cambodia','Cameroon','Canada','Cape Verde','Central African Republic','Chad','Chile','China','Colombia','Comoros','Congo','Costa Rica','Croatia','Cuba','Cyprus','Czech Republic','Denmark','Djibouti','Dominica','Dominican Republic','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Eswatini','Ethiopia','Fiji','Finland','France','Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana','Haiti','Honduras','Hungary','Iceland','India','Indonesia','Iran','Iraq','Ireland','Israel','Italy','Jamaica','Japan','Jordan','Kazakhstan','Kenya','Kiribati','Kosovo','Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg','Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar','Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','North Korea','North Macedonia','Norway','Oman','Pakistan','Palau','Palestine','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal','Qatar','Romania','Russia','Rwanda','Saint Kitts and Nevis','Saint Lucia','Saint Vincent and the Grenadines','Samoa','San Marino','Sao Tome and Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Korea','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Sweden','Switzerland','Syria','Taiwan','Tajikistan','Tanzania','Thailand','Timor-Leste','Togo','Tonga','Trinidad and Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu','Uganda','Ukraine','United Arab Emirates','United Kingdom','United States','Uruguay','Uzbekistan','Vanuatu','Vatican City','Venezuela','Vietnam','Yemen','Zambia','Zimbabwe'] as $country)
                <option value="{{ $country }}" {{ old('country') === $country ? 'selected' : '' }}>{{ $country }}</option>
              @endforeach
            </select>
            @error('country')<span class="error-text">{{ $message }}</span>@enderror
          </div>
        </div>

        <div class="field" style="margin-bottom:14px">
          <label>CICNI <span class="req">*</span></label>
          <input type="text" name="cicni" placeholder="Enter your CICNI" value="{{ old('cicni') }}" required>
          @error('cicni')<span class="error-text">{{ $message }}</span>@enderror
        </div>

        <div class="field" style="margin-bottom:14px;position:relative">
          <label>Face Photo <span class="req">*</span></label>
          <input type="file" name="face_photo" id="facePhotoInput" accept="image/jpeg,image/png,image/webp" class="visually-hidden-file" tabindex="-1">
          <div class="face-cap" id="faceCapTrigger" role="button" tabindex="0">
            <div class="fc-icon">📷</div>
            <div style="color:var(--text);font-size:.82rem">Tap to open camera &amp; capture</div>
            <div style="color:var(--muted);font-size:.72rem;margin-top:4px">Your face must be clearly visible</div>
            <img class="face-preview" id="facePreview" alt="Captured preview">
          </div>
          <button type="button" class="face-fallback" id="faceUploadFallback">Or upload a clear face photo</button>
          @error('face_photo')<span class="error-text">{{ $message }}</span>@enderror
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
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <button type="submit" class="btn"><span>Submit Registration →</span></button>
      </form>

      <p style="margin-top:16px;font-size:.82rem;color:var(--muted)">Already registered? <a href="{{ route('student.login') }}" style="color:var(--gold)">Log in here</a></p>
    </div>
  </div>
</div>

<div class="cam-wrap" id="camWrap" aria-hidden="true">
  <div class="cam-panel">
    <h3>Position your face in the frame</h3>
    <video id="faceVideo" playsinline autoplay muted></video>
    <div class="cam-actions">
      <button type="button" class="btn-cap" id="btnSnap">Capture</button>
      <button type="button" class="btn-cancel" id="btnCamCancel">Cancel</button>
    </div>
  </div>
</div>
<canvas id="faceCanvas" width="1280" height="720" style="display:none"></canvas>
@endsection

@push('scripts')
<script>
  let faceStream = null;

  function stopFaceCam() {
    if (faceStream) { faceStream.getTracks().forEach(t => t.stop()); faceStream = null; }
    var v = document.getElementById('faceVideo');
    if (v) v.srcObject = null;
  }

  function openFaceCam() {
    var wrap = document.getElementById('camWrap');
    var video = document.getElementById('faceVideo');
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
      alert('Camera not supported. Use the upload option below.');
      document.getElementById('facePhotoInput').click();
      return;
    }
    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: { ideal: 1280 }, height: { ideal: 720 } }, audio: false })
      .then(function (stream) {
        faceStream = stream;
        video.srcObject = stream;
        wrap.classList.add('on');
        wrap.setAttribute('aria-hidden', 'false');
      })
      .catch(function () {
        alert('Could not access camera. Use "Or upload a clear face photo" below.');
      });
  }

  function closeFaceCam() {
    stopFaceCam();
    var wrap = document.getElementById('camWrap');
    wrap.classList.remove('on');
    wrap.setAttribute('aria-hidden', 'true');
  }

  document.getElementById('faceUploadFallback').addEventListener('click', function () {
    document.getElementById('facePhotoInput').click();
  });

  document.getElementById('facePhotoInput').addEventListener('change', function () {
    var f = this.files && this.files[0];
    if (!f) return;
    document.getElementById('facePreview').src = URL.createObjectURL(f);
    document.getElementById('faceCapTrigger').classList.add('has-photo');
  });

  document.getElementById('faceCapTrigger').addEventListener('click', function (e) {
    e.preventDefault();
    openFaceCam();
  });
  document.getElementById('faceCapTrigger').addEventListener('keydown', function (e) {
    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openFaceCam(); }
  });

  document.getElementById('btnCamCancel').addEventListener('click', closeFaceCam);

  document.getElementById('btnSnap').addEventListener('click', function () {
    var video = document.getElementById('faceVideo');
    var canvas = document.getElementById('faceCanvas');
    var ctx = canvas.getContext('2d');
    var w = video.videoWidth, h = video.videoHeight;
    if (!w || !h) { alert('Camera not ready. Try again.'); return; }
    canvas.width = w; canvas.height = h;
    ctx.drawImage(video, 0, 0, w, h);
    canvas.toBlob(function (blob) {
      if (!blob) return;
      var file = new File([blob], 'face-capture.jpg', { type: 'image/jpeg' });
      var dt = new DataTransfer();
      dt.items.add(file);
      document.getElementById('facePhotoInput').files = dt.files;
      document.getElementById('facePreview').src = URL.createObjectURL(blob);
      document.getElementById('faceCapTrigger').classList.add('has-photo');
      closeFaceCam();
    }, 'image/jpeg', 0.92);
  });

  document.getElementById('camWrap').addEventListener('click', function (e) {
    if (e.target === this) closeFaceCam();
  });

  document.getElementById('fileInput').addEventListener('click', function () {
    document.getElementById('paymentFile').click();
  });

  document.getElementById('paymentFile').addEventListener('change', function () {
    document.getElementById('fileName').textContent = this.files[0]?.name || 'No file chosen';
  });

  document.querySelector('form').addEventListener('submit', function (e) {
    var inp = document.getElementById('facePhotoInput');
    if (!inp.files || !inp.files.length) {
      e.preventDefault();
      alert('Please capture or upload your face photo before submitting.');
    }
  });
</script>
@endpush
