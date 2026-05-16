@extends('layouts.admin')

@section('title', 'Upload Course Videos — Admin')
@section('breadcrumb', 'Upload Videos')
@section('page_eyebrow', 'Courses')
@section('page_title', 'Upload Course Videos')

@section('content')
<style>
    .video-hub-intro{color:var(--wf);margin-bottom:24px;font-size:.95rem;max-width:720px;line-height:1.6}
    .course-video-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:18px}
    .cv-card{background:var(--bc);border:1px solid var(--bb);border-radius:3px;padding:20px;display:flex;flex-direction:column;gap:12px;transition:border-color .25s}
    .cv-card:hover{border-color:rgba(212,160,23,.35)}
    .cv-title{font-family:'Cinzel',serif;font-size:.95rem;color:var(--white);letter-spacing:.04em}
    .cv-meta{font-size:.82rem;color:var(--wf)}
    .cv-count{font-family:'Cinzel',serif;font-size:.62rem;letter-spacing:.12em;text-transform:uppercase;color:var(--gold)}
    .cv-actions{margin-top:auto;display:flex;gap:8px;flex-wrap:wrap}
</style>

<p class="video-hub-intro">
    Select a course to upload or manage lesson videos. Verified students will see these on the course learn page after enrollment is approved.
</p>

@if($courses->isEmpty())
    <div class="table-card" style="padding:40px;text-align:center;color:var(--wf)">
        <p>No courses yet. <a href="{{ route('courses.create') }}" style="color:var(--gold)">Create a course</a> first.</p>
    </div>
@else
    <div class="course-video-grid">
        @foreach($courses as $course)
            <article class="cv-card">
                <div class="cv-count">{{ $course->videos_count }} {{ Str::plural('video', $course->videos_count) }}</div>
                <h2 class="cv-title">{{ $course->title }}</h2>
                <p class="cv-meta">{{ ucfirst($course->level) }} · {{ ucfirst($course->status) }}</p>
                <div class="cv-actions">
                    <a href="{{ route('admin.course-videos.show', $course) }}" class="btn-sm btn-gold">Manage videos</a>
                    <a href="{{ route('courses.edit', $course) }}" class="btn-sm btn-outline-gold">Edit course</a>
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection
