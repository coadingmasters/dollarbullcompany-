@extends('layouts.admin')

@section('title', 'Create Course — Admin')
@section('breadcrumb', 'Create Course')
@section('page_eyebrow', 'Paid Courses')
@section('page_title', 'Create Course')

@section('page_actions')
    <a href="{{ route('courses.index') }}" class="btn-sm btn-outline-gold">All Courses</a>
@endsection

@push('styles')
<style>
    .container { max-width: 800px; margin: 0 auto; padding: 32px 20px; }
    .form-card { background: #161616; border: 1px solid rgba(201,168,76,.18); padding: 32px; }
    .form-group { margin-bottom: 24px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
    @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
    label { display: block; font-family: Cinzel, serif; font-size: 7.5px; letter-spacing: .17em; text-transform: uppercase; color: #7a7060; margin-bottom: 8px; }
    label .req { color: #C9A84C; margin-left: 2px; }
    input[type="text"], input[type="number"], input[type="file"], select, textarea { width: 100%; background: rgba(255,255,255,.03); border: 1px solid rgba(201,168,76,.18); color: #D8D0C0; padding: 10px 12px; font-size: .9rem; font-family: Georgia, serif; outline: none; transition: border-color .25s, background .25s; }
    input:focus, select:focus, textarea:focus { border-color: #7a6230; background: rgba(201,168,76,.05); }
    textarea { resize: vertical; min-height: 120px; }
    select { cursor: pointer; }
    select option { background: #1a1a1a; }
    .checkbox-group { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
    input[type="checkbox"] { width: 18px; height: 18px; accent-color: #C9A84C; cursor: pointer; }
    .checkbox-group label { margin: 0; color: #D8D0C0; font-size: .9rem; text-transform: none; letter-spacing: normal; font-family: Georgia, serif; }
    .form-actions { display: flex; gap: 12px; margin-top: 32px; }
    .act-btn { flex: 1; padding: 13px 24px; background: transparent; border: 1px solid #C9A84C; color: #E8C97A; font-family: Cinzel, serif; font-size: .75rem; letter-spacing: .2em; text-transform: uppercase; cursor: pointer; position: relative; overflow: hidden; transition: color .3s; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
    .act-btn::before { content:''; position:absolute; inset:0; background:#C9A84C; transform:scaleX(0); transform-origin:left; transition:transform .35s cubic-bezier(.4,0,.2,1); z-index:0; }
    .act-btn:hover::before { transform:scaleX(1); }
    .act-btn:hover { color:#0d0d0d; }
    .act-btn span { position:relative; z-index:1; }
    .act-btn-cancel { background: rgba(201,168,76,.05); border-color: rgba(201,168,76,.18); color: #7a7060; }
    .errors { background: rgba(192,57,43,.1); border: 1px solid rgba(192,57,43,.3); border-left: 3px solid #C0392B; padding: 12px 16px; margin-bottom: 24px; color: #e07b73; font-size: .9rem; }
    .errors li { margin-left: 20px; margin-bottom: 4px; }
    .help-text { font-size: .8rem; color: #7a7060; margin-top: 4px; font-style: italic; }
</style>
@endpush

@section('content')
<div class="container">
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
            <a href="{{ route('courses.index') }}" class="act-btn act-btn-cancel"><span>Cancel</span></a>
            <button type="submit" class="act-btn"><span>Create Course</span></button>
        </div>
    </form>
</div>
@endsection
