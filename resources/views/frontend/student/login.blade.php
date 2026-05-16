@extends('layouts.frontend')

@section('title', 'Student Login — ' . config('app.name', 'CryptoOnly'))

@push('styles')
<style>
    :root { --gold:#C9A84C; --gold-light:#E8C97A; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
    .login-page { padding: 40px 20px 80px; display: flex; justify-content: center; align-items: flex-start; }
    .box { background: var(--card); border: 1px solid var(--border); padding: 40px; width: 100%; max-width: 420px; }
    h1 { font-family: Cinzel, serif; color: var(--gold-light); margin-bottom: 8px; font-size: 1.4rem; }
    p { color: var(--muted); font-size: .85rem; margin-bottom: 24px; line-height: 1.55; }
    label { display: block; font-size: .75rem; color: var(--muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .1em; }
    input { width: 100%; padding: 10px; margin-bottom: 16px; background: rgba(255,255,255,.03); border: 1px solid var(--border); color: var(--text); font-family: inherit; }
    button { width: 100%; padding: 12px; background: transparent; border: 1px solid var(--gold); color: var(--gold-light); font-family: Cinzel, serif; cursor: pointer; letter-spacing: .1em; text-transform: uppercase; }
    .err { color: #e07b73; font-size: .85rem; margin-bottom: 12px; }
    a { color: var(--gold); }
</style>
@endpush

@section('content')
<div class="login-page">
    <div class="box">
        <h1>Student login</h1>
        <p>Log in after admin has approved your course enrollment. Use the email and password you set when you enrolled.</p>
        @if($errors->any())<div class="err">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('student.login.submit') }}">
            @csrf
            <input type="hidden" name="redirect" value="{{ $redirect ?? route('courses.frontend') }}">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <label style="display:flex;align-items:center;gap:8px;text-transform:none;letter-spacing:0;font-size:.85rem">
                <input type="checkbox" name="remember" style="width:auto;margin:0"> Remember me
            </label>
            <button type="submit">Log in</button>
        </form>
        <p style="margin-top:20px">Not registered yet? <a href="{{ route('live-sessions.index') }}">Register for a live session</a></p>
        <p style="margin-top:8px">Looking for courses? <a href="{{ route('courses.frontend') }}">Browse courses &amp; enroll</a></p>
    </div>
</div>
@endsection
