<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Courses - Learn & Earn</title>
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
        .wrap {
            padding: 28px 20px 40px;
            background: var(--black);
            min-height: 100vh;
        }
        .hd {
            text-align: center;
            margin-bottom: 24px;
            animation: fd 0.8s ease both;
        }
        .tag {
            display: inline-block;
            font-family: Cinzel, serif;
            font-size: 9px;
            letter-spacing: 0.22em;
            color: var(--gold);
            border: 1px solid var(--border);
            padding: 4px 14px;
            margin-bottom: 10px;
        }
        .hd h1 {
            font-family: Cinzel, serif;
            font-size: clamp(1.4rem, 4vw, 2.2rem);
            color: #fff;
            margin-bottom: 8px;
        }
        .hd h1 em {
            color: var(--gold);
            font-style: normal;
            display: inline-block;
            border-bottom: 1px solid var(--gold);
            padding-bottom: 2px;
        }
        .subtitle {
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: 12px;
            font-style: italic;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .div {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 30px 0;
        }
        .div span {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold-dim));
        }
        .div span:last-child {
            background: linear-gradient(270deg, transparent, var(--gold-dim));
        }

        .filters {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }
        .filter-btn {
            padding: 8px 16px;
            border: 1px solid var(--border);
            background: rgba(201, 168, 76, 0.05);
            color: var(--text);
            font-family: Cinzel, serif;
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
        }
        .filter-btn:hover, .filter-btn.active {
            border-color: var(--gold);
            background: rgba(201, 168, 76, 0.15);
            color: var(--gold-light);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            animation: fu 0.7s 0.2s ease both;
        }
        @media (max-width: 600px) {
            .grid { grid-template-columns: 1fr; }
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

        .course-img {
            width: 100%;
            height: 160px;
            background: linear-gradient(135deg, var(--gold-dim), var(--black));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            overflow: hidden;
        }
        .course-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .course-content {
            padding: 20px;
        }
        .course-level {
            display: inline-block;
            font-family: Cinzel, serif;
            font-size: 7px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--gold);
            background: rgba(201, 168, 76, 0.1);
            padding: 4px 8px;
            margin-bottom: 10px;
        }
        .course-title {
            font-family: Cinzel, serif;
            font-size: 1rem;
            color: #fff;
            margin-bottom: 8px;
            min-height: 30px;
            line-height: 1.3;
        }
        .course-desc {
            font-size: 0.8rem;
            color: var(--muted);
            margin-bottom: 12px;
            line-height: 1.4;
            min-height: 40px;
        }
        .course-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
            font-size: 0.75rem;
            color: var(--muted);
            padding: 10px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .course-price {
            font-size: 1.3rem;
            color: var(--gold-light);
            font-weight: 700;
            margin-bottom: 14px;
        }
        .course-btn {
            width: 100%;
            padding: 10px 16px;
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold-light);
            font-family: Cinzel, serif;
            font-size: 0.7rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .course-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gold);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }
        .course-btn:hover::before { transform: scaleX(1); }
        .course-btn:hover { color: var(--black); }
        .course-btn span { position: relative; z-index: 1; }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        @keyframes fd {
            from { opacity: 0; transform: translateY(-22px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fu {
            from { opacity: 0; transform: translateY(26px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <header class="hd">
            <div class="tag">📚 Learning Hub</div>
            <h1>Master <em>Crypto</em> Trading</h1>
            <p class="subtitle">Structured courses from beginner to advanced. Learn from certified instructors and earn recognized credentials.</p>
        </header>

        <div class="div"><span></span><span style="color:var(--gold);font-size:8px">◆</span><span></span></div>

        <div class="filters">
            <button class="filter-btn active">All Courses</button>
            <button class="filter-btn">Beginner</button>
            <button class="filter-btn">Intermediate</button>
            <button class="filter-btn">Advanced</button>
        </div>

        @if($courses->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📖</div>
                <h2>No courses available yet</h2>
                <p>Check back soon for new crypto trading courses!</p>
            </div>
        @else
            <div class="grid">
                @foreach($courses as $course)
                    <div class="course-card">
                        <div class="course-img">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
                            @else
                                📚
                            @endif
                        </div>
                        <div class="course-content">
                            <span class="course-level">{{ ucfirst($course->level) }}</span>
                            <h3 class="course-title">{{ $course->title }}</h3>
                            <p class="course-desc">{{ \Illuminate\Support\Str::limit($course->description, 80) }}</p>
                            <div class="course-meta">
                                <span>{{ $course->duration_in_weeks ? $course->duration_in_weeks . 'w' : 'Flex' }}</span>
                                <span>{{ ucfirst($course->status) }}</span>
                            </div>
                            <div class="course-price">${{ number_format($course->price, 0) }}</div>
                            <a href="#enroll" class="course-btn">
                                <span>Enroll Now →</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
