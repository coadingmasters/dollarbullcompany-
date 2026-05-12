<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>
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
            max-width: 800px;
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
        .header h1 {
            font-family: Cinzel, serif;
            font-size: 2rem;
            color: #fff;
        }

        .form-card {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 32px;
        }

        .form-group {
            margin-bottom: 24px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }
        @media (max-width: 600px) {
            .form-row { grid-template-columns: 1fr; }
        }

        label {
            display: block;
            font-family: Cinzel, serif;
            font-size: 7.5px;
            letter-spacing: 0.17em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }
        label .req {
            color: var(--gold);
            margin-left: 2px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 10px 12px;
            font-size: 0.9rem;
            font-family: Georgia, serif;
            outline: none;
            transition: border-color 0.25s, background 0.25s;
        }
        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--gold-dim);
            background: rgba(201,168,76,0.05);
        }
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        select {
            cursor: pointer;
        }
        select option {
            background: #1a1a1a;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--gold);
            cursor: pointer;
        }
        .checkbox-group label {
            margin: 0;
            color: var(--text);
            font-size: 0.9rem;
            text-transform: none;
            letter-spacing: normal;
            font-family: Georgia, serif;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
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

        .btn-cancel {
            background: rgba(201,168,76,0.05);
            border-color: var(--border);
            color: var(--muted);
        }
        .btn-cancel:hover {
            background: rgba(192,57,43,0.1);
            border-color: var(--red);
            color: var(--red);
        }

        .errors {
            background: rgba(192,57,43,0.1);
            border: 1px solid rgba(192,57,43,0.3);
            border-left: 3px solid var(--red);
            padding: 12px 16px;
            margin-bottom: 24px;
            color: #e07b73;
            font-size: 0.9rem;
        }
        .errors li {
            margin-left: 20px;
            margin-bottom: 4px;
        }

        .help-text {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 4px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('courses.index') }}">← Back to Courses</a>
            <h1>📝 Create Course</h1>
        </div>

        @if($errors->any())
            <div class="errors">
                <strong>Please fix the errors below:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data" class="form-card">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label>Title <span class="req">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    <label>Slug <span class="req">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug') }}" required>
                    <div class="help-text">URL-friendly version of title (auto-slugified)</div>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description">{{ old('description') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Price <span class="req">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label>Duration (weeks)</label>
                    <input type="number" name="duration_in_weeks" value="{{ old('duration_in_weeks') }}" min="1">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Level <span class="req">*</span></label>
                    <select name="level" required>
                        <option value="">Select Level</option>
                        <option value="beginner" {{ old('level') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('level') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ old('level') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status <span class="req">*</span></label>
                    <select name="status" required>
                        <option value="">Select Status</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Thumbnail Image</label>
                <input type="file" name="thumbnail" accept="image/*">
                <div class="help-text">Recommended: 800x600px or larger. Max 5MB</div>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                <label for="featured">Featured Course</label>
            </div>

            <div class="form-actions">
                <a href="{{ route('courses.index') }}" class="btn btn-cancel"><span>Cancel</span></a>
                <button type="submit" class="btn"><span>Create Course</span></button>
            </div>
        </form>
    </div>
</body>
</html>
