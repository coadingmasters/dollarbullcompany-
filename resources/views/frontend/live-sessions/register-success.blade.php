@extends('layouts.frontend')

@section('title', 'Registration Submitted — ' . $session->title)

@push('styles')
<style>
  :root { --gold:#C9A84C; --gold-light:#E8C97A; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
  .success-page { padding: 60px 20px; display: flex; justify-content: center; align-items: flex-start; }
  .box { background: var(--card); border: 1px solid var(--border); padding: 48px 40px; width: 100%; max-width: 520px; text-align: center; }
  .icon { font-size: 2.8rem; margin-bottom: 20px; }
  h1 { font-family: Cinzel, serif; color: var(--gold-light); margin-bottom: 12px; font-size: 1.5rem; }
  p { color: var(--muted); font-size: .88rem; line-height: 1.65; margin-bottom: 10px; }
  .highlight { color: var(--text); }
  .divider { height: 1px; background: var(--border); margin: 24px 0; }
  .step { text-align: left; background: rgba(201,168,76,.04); border: 1px solid var(--border); border-left: 3px solid var(--gold); padding: 12px 16px; margin-bottom: 10px; font-size: .83rem; color: var(--text); }
  .step strong { font-family: Cinzel, serif; font-size: .7rem; letter-spacing: .1em; color: var(--gold); display: block; margin-bottom: 4px; text-transform: uppercase; }
  .btn { display: inline-block; margin-top: 24px; padding: 12px 28px; border: 1px solid var(--gold); color: var(--gold-light); font-family: Cinzel, serif; font-size: .7rem; letter-spacing: .18em; text-transform: uppercase; text-decoration: none; transition: background .25s, color .25s; }
  .btn:hover { background: var(--gold); color: #0d0d0d; }
</style>
@endpush

@section('content')
<div class="success-page">
  <div class="box">
    <div class="icon">✅</div>
    <h1>Registration Submitted!</h1>
    <p>Your registration for <span class="highlight">{{ $session->title }}</span> has been received.</p>
    <p>Our admin team will review your payment and contact you within <span class="highlight">48 hours</span> via email or WhatsApp.</p>

    <div class="divider"></div>

    <div class="step">
      <strong>Step 1 — Complete</strong>
      Registration form & payment proof submitted.
    </div>
    <div class="step">
      <strong>Step 2 — Pending</strong>
      Admin verifies your payment (up to 48 hours).
    </div>
    <div class="step">
      <strong>Step 3 — After Approval</strong>
      Log in with your email & password to join the live session.
    </div>

    <a href="{{ route('live-sessions.index') }}" class="btn">Browse More Sessions</a>
    <br>
    <a href="{{ route('student.login') }}" style="display:inline-block;margin-top:14px;color:var(--gold);font-size:.82rem">Already approved? Log in →</a>
  </div>
</div>
@endsection
