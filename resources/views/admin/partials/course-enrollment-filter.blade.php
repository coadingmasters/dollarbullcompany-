<form method="GET" action="{{ route('course-enrollments.admin') }}" style="margin-bottom:24px;display:flex;gap:12px;flex-wrap:wrap;align-items:center">
    <label style="font-family:Cinzel,serif;font-size:.7rem;letter-spacing:.12em;color:var(--gold);text-transform:uppercase">Filter by course</label>
    <select name="course_id" onchange="this.form.submit()" style="background:rgba(255,255,255,.03);border:1px solid var(--border);color:var(--text);padding:8px 12px;min-width:220px">
        <option value="">All courses</option>
        @foreach($courses as $c)
            <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
        @endforeach
    </select>
</form>
