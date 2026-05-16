<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Successful — {{ $course->title }}</title>
    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C97A;
            --black: #0d0d0d;
            --card: #161616;
            --border: rgba(201, 168, 76, 0.18);
            --text: #D8D0C0;
            --muted: #7a7060;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--black);
            color: var(--text);
            font-family: Georgia, serif;
            font-size: 14px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&display=swap');
        .success-container {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 60px 40px;
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        h1 {
            font-family: Cinzel, serif;
            font-size: 28px;
            color: var(--gold-light);
            margin-bottom: 12px;
        }
        .subtitle { color: var(--muted); margin-bottom: 32px; line-height: 1.6; }
        .course-name { color: var(--gold-light); font-weight: 600; }
        .actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-top: 24px; }
        a {
            padding: 10px 24px;
            background: var(--gold);
            color: var(--black);
            border: 1px solid var(--gold);
            font-weight: 600;
            text-decoration: none;
            font-size: 13px;
        }
        a.secondary {
            background: transparent;
            color: var(--text);
            border-color: var(--border);
            font-weight: normal;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <span style="font-size:64px;display:block;margin-bottom:24px">✓</span>
        <h1>Enrollment Successful!</h1>
        <p class="subtitle">
            Your enrollment for <span class="course-name">{{ $course->title }}</span> was submitted and your student account was created.
            After admin approval, log in with your email and password to view course videos.
        </p>
        <div class="actions">
            <a href="{{ route('student.login') }}">Student login</a>
            <a href="{{ route('courses.frontend') }}">Browse courses</a>
            <a href="{{ url('/') }}" class="secondary">Home</a>
        </div>
    </div>
</body>
</html>
