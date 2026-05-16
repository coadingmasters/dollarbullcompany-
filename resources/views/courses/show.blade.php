@extends('layouts.admin')

@section('title', $course->title . ' — Admin')
@section('breadcrumb', 'Course Details')
@section('page_eyebrow', 'Paid Courses')
@section('page_title', $course->title)

@section('page_actions')
    <a href="{{ route('courses.edit', $course) }}" class="btn-sm btn-gold">Edit Course</a>
    <a href="{{ route('courses.index') }}" class="btn-sm btn-outline-gold">All Courses</a>
@endsection

@push('styles')
<style>
    .container { max-width: 1000px; margin: 0 auto; padding: 32px 20px; }
    .course-hero { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: start; margin-bottom: 40px; }
    @media (max-width: 768px) { .course-hero { grid-template-columns: 1fr; gap: 24px; } }
    .course-image { width: 100%; height: 340px; background: linear-gradient(135deg, #7a6230, #0d0d0d); border: 1px solid rgba(201,168,76,.18); display: flex; align-items: center; justify-content: center; font-size: 5rem; overflow: hidden; }
    .course-image img { width: 100%; height: 100%; object-fit: cover; }
    .course-level { display: inline-block; font-family: Cinzel, serif; font-size: 8px; letter-spacing: .17em; text-transform: uppercase; color: #C9A84C; background: rgba(201,168,76,.1); padding: 6px 12px; margin-bottom: 12px; }
    .course-title { font-family: Cinzel, serif; font-size: 2rem; color: #fff; margin-bottom: 16px; line-height: 1.2; }
    .course-price { font-size: 2rem; color: #E8C97A; font-weight: 700; margin-bottom: 20px; }
    .course-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; padding: 20px; background: rgba(201,168,76,.04); border: 1px solid rgba(201,168,76,.18); }
    .meta-label { font-family: Cinzel, serif; font-size: 7px; letter-spacing: .17em; text-transform: uppercase; color: #7a7060; margin-bottom: 4px; }
    .meta-value { font-size: 1.1rem; color: #D8D0C0; }
    .status-badge { display: inline-block; padding: 6px 12px; font-family: Cinzel, serif; font-size: .75rem; letter-spacing: .15em; text-transform: uppercase; width: fit-content; }
    .status-published { background: rgba(39,174,96,.15); color: #5dde95; }
    .status-draft { background: rgba(201,168,76,.1); color: #E8C97A; }
    .status-archived { background: rgba(192,57,43,.1); color: #e07b73; }
    .section-title { font-family: Cinzel, serif; font-size: 1.2rem; color: #C9A84C; margin-bottom: 12px; border-bottom: 1px solid rgba(201,168,76,.18); padding-bottom: 8px; }
    .course-description { margin-bottom: 32px; }
    .course-description p { line-height: 1.6; color: #D8D0C0; margin-bottom: 12px; }
    .empty-description { color: #7a7060; font-style: italic; }
    .course-info { background: #161616; border: 1px solid rgba(201,168,76,.18); padding: 24px; margin-bottom: 24px; }
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
    .info-label { font-family: Cinzel, serif; font-size: 7px; letter-spacing: .17em; text-transform: uppercase; color: #7a7060; margin-bottom: 6px; }
    .info-value { font-size: 1.1rem; color: #E8C97A; }
    .course-actions { display: flex; gap: 12px; }
    .act-btn { flex: 1; padding: 13px 24px; background: transparent; border: 1px solid #C9A84C; color: #E8C97A; font-family: Cinzel, serif; font-size: .75rem; letter-spacing: .2em; text-transform: uppercase; cursor: pointer; position: relative; overflow: hidden; transition: color .3s; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
    .act-btn::before { content:''; position:absolute; inset:0; background:#C9A84C; transform:scaleX(0); transform-origin:left; transition:transform .35s cubic-bezier(.4,0,.2,1); z-index:0; }
    .act-btn:hover::before { transform:scaleX(1); }
    .act-btn:hover { color:#0d0d0d; }
    .act-btn span { position:relative; z-index:1; }
    .act-btn-secondary { background: rgba(201,168,76,.05); border-color: rgba(201,168,76,.18); color: #7a7060; }
</style>
@endpush

@section('content')
<div class="container">
    <div class="course-hero">
        <div class="course-image">
            @if($course->thumbnail_url)
                <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
            @else
                📚
            @endif
        </div>

        <div class="course-details">
            <span class="course-level">{{ ucfirst($course->level) }}</span>
            <h1 class="course-title">{{ $course->title }}</h1>
            <div class="course-price">${{ number_format($course->price, 2) }}</div>

            <div class="course-meta">
                <div>
                    <div class="meta-label">Status</div>
                    <span class="status-badge status-{{ $course->status }}">{{ ucfirst($course->status) }}</span>
                </div>
                <div>
                    <div class="meta-label">Duration</div>
                    <div class="meta-value">{{ $course->duration_in_weeks ? $course->duration_in_weeks . ' weeks' : 'Self-paced' }}</div>
                </div>
                <div>
                    <div class="meta-label">Featured</div>
                    <div class="meta-value">{{ $course->is_featured ? '⭐ Yes' : 'No' }}</div>
                </div>
                <div>
                    <div class="meta-label">Created</div>
                    <div class="meta-value">{{ $course->created_at->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="course-description">
        <h2 class="section-title">📖 Description</h2>
        @if($course->description)
            <p>{{ $course->description }}</p>
        @else
            <p class="empty-description">No description provided yet.</p>
        @endif
    </div>

    <div class="course-info">
        <h2 class="section-title">ℹ️ Course Information</h2>
        <div class="info-grid">
            <div>
                <div class="info-label">Level</div>
                <div class="info-value">{{ ucfirst($course->level) }}</div>
            </div>
            <div>
                <div class="info-label">Price</div>
                <div class="info-value">${{ number_format($course->price, 2) }}</div>
            </div>
            <div>
                <div class="info-label">Duration</div>
                <div class="info-value">{{ $course->duration_in_weeks ? $course->duration_in_weeks . ' weeks' : 'Self-paced' }}</div>
            </div>
            <div>
                <div class="info-label">Last Updated</div>
                <div class="info-value">{{ $course->updated_at->format('M d, Y') }}</div>
            </div>
        </div>

        <div class="course-actions">
            <a href="{{ route('courses.edit', $course) }}" class="act-btn"><span>Edit Course</span></a>
            <a href="{{ route('courses.index') }}" class="act-btn act-btn-secondary"><span>Back to List</span></a>
        </div>
    </div>
</div>
@endsection
