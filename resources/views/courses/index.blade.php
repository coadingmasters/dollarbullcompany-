@extends('layouts.admin')

@section('title', 'Paid Courses — Admin')
@section('breadcrumb', 'Paid Courses')
@section('page_eyebrow', 'Services')
@section('page_title', 'Paid Courses')

@section('page_actions')
    <a href="{{ route('admin.course-videos.index') }}" class="btn-sm btn-outline-gold">Upload videos</a>
    <a href="{{ route('courses.create') }}" class="btn-sm btn-gold">+ New course</a>
@endsection

@push('styles')
<style>
    .courses-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:18px}
    .course-card{background:var(--bc);border:1px solid var(--bb);overflow:hidden;transition:border-color .25s,transform .25s}
    .course-card:hover{border-color:rgba(212,160,23,.35);transform:translateY(-3px)}
    .course-thumbnail{height:160px;background:var(--b2);display:flex;align-items:center;justify-content:center;font-size:2.5rem;overflow:hidden}
    .course-thumbnail img{width:100%;height:100%;object-fit:cover}
    .course-body{padding:18px}
    .course-level{font-family:'Cinzel',serif;font-size:.55rem;letter-spacing:.14em;text-transform:uppercase;color:var(--gold)}
    .course-title{font-family:'Cinzel',serif;font-size:.95rem;color:var(--white);margin:8px 0}
    .course-price{color:var(--gold-light);font-size:1.2rem;font-weight:700;margin-bottom:10px}
    .course-meta{display:flex;justify-content:space-between;font-size:.8rem;color:var(--wf);margin-bottom:14px}
    .course-actions{display:flex;flex-wrap:wrap;gap:6px}
    .course-actions .btn-sm{flex:1;min-width:70px;justify-content:center}
    .empty-courses{text-align:center;padding:48px;color:var(--wf)}
</style>
@endpush

@section('content')
    @if($courses->isEmpty())
        <div class="table-card empty-courses">
            <p style="font-size:2rem;margin-bottom:12px">📖</p>
            <h2 style="font-family:'Cinzel',serif;color:var(--white);margin-bottom:8px">No courses yet</h2>
            <p>Create your first course to get started.</p>
        </div>
    @else
        <div class="courses-grid">
            @foreach($courses as $course)
                <article class="course-card">
                    <div class="course-thumbnail">
                        @if($course->thumbnail_url)
                            <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                        @else
                            📖
                        @endif
                    </div>
                    <div class="course-body">
                        <span class="course-level">{{ ucfirst($course->level) }}</span>
                        <h3 class="course-title">{{ $course->title }}</h3>
                        <div class="course-price">${{ number_format($course->price, 2) }}</div>
                        <div class="course-meta">
                            <span>{{ $course->duration_in_weeks ?? '—' }} weeks</span>
                            <span style="color:{{ $course->status === 'published' ? 'var(--green)' : 'var(--wf)' }}">{{ ucfirst($course->status) }}</span>
                        </div>
                        <div class="course-actions">
                            <a href="{{ route('courses.show', $course) }}" class="btn-sm btn-outline-gold">View</a>
                            <a href="{{ route('courses.edit', $course) }}" class="btn-sm btn-outline-gold">Edit</a>
                            <a href="{{ route('admin.course-videos.show', $course) }}" class="btn-sm btn-gold">Videos</a>
                            <form method="POST" action="{{ route('courses.destroy', $course) }}" style="flex:1" onsubmit="return confirm('Delete this course?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-outline-gold" style="width:100%;color:var(--red);border-color:rgba(239,68,68,.4)">Delete</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
