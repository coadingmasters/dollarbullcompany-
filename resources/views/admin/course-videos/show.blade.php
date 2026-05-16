@extends('layouts.admin')

@section('title', $course->title . ' — Videos')
@section('breadcrumb', 'Upload Videos')
@section('page_eyebrow', 'Course videos')
@section('page_title', $course->title)

@section('page_actions')
    <a href="{{ route('admin.course-videos.index') }}" class="btn-sm btn-outline-gold">All courses</a>
@endsection

@push('styles')
<style>
    .video-manager-wrap{
        background:var(--bc);border:1px solid var(--bb);border-radius:3px;
        padding:24px;max-width:900px;
    }
    .video-manager-wrap label{
        font-family:'Cinzel',serif;font-size:.65rem;letter-spacing:.12em;
        text-transform:uppercase;color:var(--gold);display:block;margin-bottom:8px;
    }
    .video-manager-wrap input[type=text],
    .video-manager-wrap textarea,
    .video-manager-wrap input[type=file]{
        width:100%;padding:10px 12px;background:var(--black);
        border:1px solid var(--bb);color:var(--wd);font-family:inherit;margin-bottom:14px;
    }
    .video-manager-wrap .form-group{margin-bottom:16px}
    .video-manager-wrap .help-text{font-size:.8rem;color:var(--wf);margin-top:4px}
    .video-manager-wrap .btn-sm{margin-top:8px}
    .video-list li{
        display:flex;justify-content:space-between;align-items:center;
        padding:12px 0;border-bottom:1px solid var(--bb);gap:12px;color:var(--wd);
    }
</style>
@endpush

@section('content')
<div class="video-manager-wrap">
    @include('courses.partials.video-manager', ['course' => $course])
</div>
@endsection
