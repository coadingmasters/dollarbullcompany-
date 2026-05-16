<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }}</title>
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
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .header {
            margin-bottom: 40px;
        }
        .header a {
            color: var(--gold);
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 16px;
            display: inline-block;
        }
        .header a:hover { color: var(--gold-light); }

        .course-hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
            margin-bottom: 40px;
        }
        @media (max-width: 768px) {
            .course-hero { grid-template-columns: 1fr; gap: 24px; }
        }

        .course-image {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, var(--gold-dim), var(--black));
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            overflow: hidden;
        }
        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .course-details {
            display: flex;
            flex-direction: column;
        }
        .course-header {
            margin-bottom: 24px;
        }
        .course-level {
            display: inline-block;
            font-family: Cinzel, serif;
            font-size: 8px;
            letter-spacing: 0.17em;
            text-transform: uppercase;
            color: var(--gold);
            background: rgba(201, 168, 76, 0.1);
            padding: 6px 12px;
            margin-bottom: 12px;
            border-radius: 2px;
        }
        .course-title {
            font-family: Cinzel, serif;
            font-size: 2rem;
            color: #fff;
            margin-bottom: 16px;
            line-height: 1.2;
        }
        .course-price {
            font-size: 2rem;
            color: var(--gold-light);
            font-weight: 700;
            margin-bottom: 20px;
        }

        .course-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
            padding: 20px;
            background: rgba(201, 168, 76, 0.04);
            border: 1px solid var(--border);
        }
        .meta-item {
            display: flex;
            flex-direction: column;
        }
        .meta-label {
            font-family: Cinzel, serif;
            font-size: 7px;
            letter-spacing: 0.17em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 4px;
        }
        .meta-value {
            font-size: 1.1rem;
            color: var(--text);
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 2px;
            font-family: Cinzel, serif;
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            width: fit-content;
        }
        .status-published {
            background: rgba(39, 174, 96, 0.15);
            color: #5dde95;
        }
        .status-draft {
            background: rgba(201, 168, 76, 0.1);
            color: var(--gold-light);
        }
        .status-archived {
            background: rgba(192, 57, 43, 0.1);
            color: #e07b73;
        }

        .course-description {
            margin-bottom: 32px;
        }
        .section-title {
            font-family: Cinzel, serif;
            font-size: 1.2rem;
            color: var(--gold);
            margin-bottom: 12px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 8px;
        }
        .course-description p {
            line-height: 1.6;
            color: var(--text);
            margin-bottom: 12px;
        }

        .course-info {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 24px;
            margin-bottom: 24px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
        }
        .info-label {
            font-family: Cinzel, serif;
            font-size: 7px;
            letter-spacing: 0.17em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 6px;
        }
        .info-value {
            font-size: 1.1rem;
            color: var(--gold-light);
        }

        .course-actions {
            display: flex;
            gap: 12px;
        }
        .btn {
            flex: 1;
            padding: 13px 24px;
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold-light);
            font-family: Cinzel, serif;
            font-size: 0.75rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: color 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gold);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }
        .btn:hover::before { transform: scaleX(1); }
        .btn:hover { color: var(--black); }
        .btn span { position: relative; z-index: 1; }

        .btn-secondary {
            background: rgba(201,168,76,0.05);
            border-color: var(--border);
            color: var(--muted);
        }
        .btn-secondary:hover {
            background: rgba(192,57,43,0.1);
            border-color: var(--red);
            color: var(--red);
        }

        .empty-description {
            color: var(--muted);
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('courses.index') }}">← Back to Courses</a>
        </div>

        <div class="course-hero">
            <div class="course-image">
                @if($course->thumbnail_url)
                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                @else
                    📚
                @endif
            </div>

            <div class="course-details">
                <div class="course-header">
                    <span class="course-level">{{ ucfirst($course->level) }}</span>
                    <h1 class="course-title">{{ $course->title }}</h1>
                    <div class="course-price">${{ number_format($course->price, 2) }}</div>
                </div>

                <div class="course-meta">
                    <div class="meta-item">
                        <span class="meta-label">Status</span>
                        <span class="status-badge status-{{ $course->status }}">{{ ucfirst($course->status) }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Duration</span>
                        <span class="meta-value">{{ $course->duration_in_weeks ? $course->duration_in_weeks . ' weeks' : 'Self-paced' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Featured</span>
                        <span class="meta-value">{{ $course->is_featured ? '⭐ Yes' : 'No' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Created</span>
                        <span class="meta-value">{{ $course->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($course->description)
            <div class="course-description">
                <h2 class="section-title">📖 Description</h2>
                <p>{{ $course->description }}</p>
            </div>
        @else
            <div class="course-description">
                <h2 class="section-title">📖 Description</h2>
                <p class="empty-description">No description provided yet.</p>
            </div>
        @endif

        <div class="course-info">
            <h2 class="section-title">ℹ️ Course Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Level</span>
                    <span class="info-value">{{ ucfirst($course->level) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Price</span>
                    <span class="info-value">${{ number_format($course->price, 2) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Duration</span>
                    <span class="info-value">{{ $course->duration_in_weeks ? $course->duration_in_weeks . ' weeks' : 'Self-paced' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Last Updated</span>
                    <span class="info-value">{{ $course->updated_at->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="course-actions">
                <a href="{{ route('courses.edit', $course) }}" class="btn"><span>Edit Course</span></a>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary"><span>Back to List</span></a>
            </div>
        </div>
    </div>
</body>
</html>
