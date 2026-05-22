<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Submitted — P2P Trading</title>
  <link rel="icon" type="image/svg+xml" href="/favicon.svg">
  <style>
    :root{--gold:#C9A84C;--gold-light:#E8C97A;--black:#0d0d0d;--card:#161616;--border:rgba(201,168,76,.18);--muted:#7a7060}
    *{box-sizing:border-box;margin:0;padding:0}
    body{background:var(--black);color:#D8D0C0;font-family:Georgia,serif;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
    .box{background:var(--card);border:1px solid var(--border);padding:40px 36px;max-width:480px;width:100%;text-align:center}
    .icon{font-size:3rem;margin-bottom:16px}
    h1{font-family:Cinzel,serif;font-size:1.3rem;color:#fff;margin-bottom:10px}
    p{color:var(--muted);font-size:.9rem;line-height:1.6;margin-bottom:8px}
    .gold{color:var(--gold)}
    .back{display:inline-block;margin-top:24px;padding:11px 28px;border:1px solid var(--gold);color:var(--gold-light);font-family:Cinzel,serif;font-size:.68rem;letter-spacing:.18em;text-transform:uppercase;text-decoration:none;transition:background .25s}
    .back:hover{background:rgba(201,168,76,.1)}
  </style>
</head>
<body>
  <div class="box">
    <div class="icon">✅</div>
    <h1>Registration Submitted!</h1>
    <p>Thank you for registering for the <span class="gold">P2P Trading</span> program.</p>
    <p>Our team will review your payment and contact you within <span class="gold">48 hours</span> via email or WhatsApp.</p>
    <a href="{{ url('/') }}" class="back">← Back to Home</a>
  </div>
</body>
</html>
