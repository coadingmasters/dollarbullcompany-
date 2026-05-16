<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        :root { --gold:#C9A84C; --gold-light:#E8C97A; --black:#0d0d0d; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
        body { background:var(--black); color:var(--text); font-family:Georgia,serif; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; }
        .box { background:var(--card); border:1px solid var(--border); padding:40px; width:100%; max-width:400px; }
        h1 { font-family:Cinzel,serif; color:var(--gold-light); margin-bottom:8px; font-size:1.4rem; }
        p { color:var(--muted); font-size:.85rem; margin-bottom:24px; }
        label { display:block; font-size:.75rem; color:var(--muted); margin-bottom:6px; text-transform:uppercase; letter-spacing:.1em; }
        input { width:100%; padding:10px; margin-bottom:16px; background:rgba(255,255,255,.03); border:1px solid var(--border); color:var(--text); }
        button { width:100%; padding:12px; background:transparent; border:1px solid var(--gold); color:var(--gold-light); font-family:Cinzel,serif; cursor:pointer; letter-spacing:.1em; text-transform:uppercase; }
        .err { color:#e07b73; font-size:.85rem; margin-bottom:12px; }
        a { color:var(--gold); }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="box">
        <h1>Student login</h1>
        <p>Log in to view course videos after admin has verified your enrollment. New students enroll on a course page (Enroll now) — that form creates your account.</p>
        @if($errors->any())<div class="err">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('student.login.submit') }}">
            @csrf
            <input type="hidden" name="redirect" value="{{ $redirect ?? route('courses.frontend') }}">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <label style="display:flex;align-items:center;gap:8px;text-transform:none;letter-spacing:0"><input type="checkbox" name="remember" style="width:auto;margin:0"> Remember me</label>
            <button type="submit">Log in</button>
        </form>
        <p style="margin-top:20px">New student? <a href="{{ route('courses.frontend') }}">Enroll in a course</a> (same registration form)</p>
    </div>
</body>
</html>
