<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C97A;
            --gold-dim: #7a6230;
            --black: #0d0d0d;
            --card: #161616;
            --border: rgba(201,168,76,0.18);
            --border-h: rgba(201,168,76,0.5);
            --text: #D8D0C0;
            --muted: #7a7060;
            --red: #C0392B;
            --green: #27ae60;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--black);
            color: var(--text);
            font-family: Georgia, serif;
            font-size: 14px;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-family: Cinzel, serif;
            font-size: 2.2rem;
            color: #fff;
        }
        .header h1 span {
            color: var(--gold);
            border-bottom: 2px solid var(--gold);
            padding-bottom: 4px;
        }
        .btn-primary {
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold-light);
            font-family: Cinzel, serif;
            font-size: 0.75rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 12px 24px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: color 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gold);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }
        .btn-primary:hover::before { transform: scaleX(1); }
        .btn-primary:hover { color: var(--black); }
        .btn-primary span { position: relative; z-index: 1; }
        
        .alert {
            padding: 16px 20px;
            margin-bottom: 24px;
            border-radius: 4px;
            border-left: 4px solid;
        }
        .alert-success {
            background: rgba(39, 174, 96, 0.08);
            border-color: var(--green);
            color: #5dde95;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }
        .course-card {
            background: var(--card);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: border-color 0.3s, transform 0.3s;
            position: relative;
        }
        .course-card:hover {
            border-color: var(--border-h);
            transform: translateY(-4px);
        }
        .course-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .course-card:hover::before { opacity: 1; }
        
        .course-thumbnail {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, var(--gold-dim), var(--black));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            overflow: hidden;
        }
        .course-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .course-body {
            padding: 20px;
        }
        .course-level {
            display: inline-block;
            font-family: Cinzel, serif;
            font-size: 7px;
            letter-spacing: 0.17em;
            text-transform: uppercase;
            color: var(--gold);
            background: rgba(201, 168, 76, 0.1);
            padding: 4px 8px;
            margin-bottom: 10px;
            border-radius: 2px;
        }
        .course-title {
            font-family: Cinzel, serif;
            font-size: 1.1rem;
            color: #fff;
            margin-bottom: 8px;
            min-height: 32px;
        }
        .course-price {
            font-size: 1.4rem;
            color: var(--gold-light);
            font-weight: 700;
            margin-bottom: 12px;
        }
        .course-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 0.8rem;
            color: var(--muted);
        }
        .course-actions {
            display: flex;
            gap: 8px;
        }
        .btn-small {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid var(--border);
            background: rgba(201, 168, 76, 0.05);
            color: var(--gold-light);
            font-family: Cinzel, serif;
            font-size: 0.7rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-small:hover {
            background: rgba(201, 168, 76, 0.15);
            border-color: var(--gold);
        }
        .btn-danger {
            color: var(--red);
            border-color: var(--red);
        }
        .btn-danger:hover {
            background: rgba(192, 57, 43, 0.1);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 <span>Courses</span></h1>
            <a href="{{ route('courses.create') }}" class="btn-primary">
                <span>+ New Course</span>
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($courses->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📖</div>
                <h2>No courses yet</h2>
                <p>Create your first course to get started</p>
            </div>
        @else
            <div class="grid">
                @foreach($courses as $course)
                    <div class="course-card">
                        <div class="course-thumbnail">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
                            @else
                                📖
                            @endif
                        </div>
                        <div class="course-body">
                            <span class="course-level">{{ ucfirst($course->level) }}</span>
                            <h3 class="course-title">{{ $course->title }}</h3>
                            <div class="course-price">${{ number_format($course->price, 2) }}</div>
                            <div class="course-meta">
                                <span>{{ $course->duration_in_weeks ?? '-' }} weeks</span>
                                <span class="course-status" style="color: {{ $course->status === 'published' ? 'var(--green)' : 'var(--muted)' }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </div>
                            <div class="course-actions">
                                <a href="{{ route('courses.show', $course) }}" class="btn-small">View</a>
                                <a href="{{ route('courses.edit', $course) }}" class="btn-small">Edit</a>
                                <form method="POST" action="{{ route('courses.destroy', $course) }}" style="flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-small btn-danger" style="width: 100%" onclick="return confirm('Delete this course?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
