@extends('layouts.admin')

@section('title', 'Create Live Session — Admin')
@section('breadcrumb', 'Create Live Session')
@section('page_eyebrow', 'Live Sessions')
@section('page_title', 'Create Live Session')

@section('page_actions')
    <a href="{{ route('admin.live-sessions.index') }}" class="btn-sm btn-outline-gold">← Back</a>
@endsection

@push('styles')
<style>
    .ls-form-card{background:var(--bc);border:1px solid var(--bb);padding:28px;max-width:720px}
    .ls-form-group{margin-bottom:22px}
    .ls-form-group label{display:block;font-family:'Cinzel',serif;font-size:.58rem;letter-spacing:.16em;text-transform:uppercase;color:var(--gold);margin-bottom:8px}
    .ls-form-group input,.ls-form-group textarea{width:100%;padding:11px 14px;background:var(--black);border:1px solid var(--bb);color:var(--wd);font-family:inherit;font-size:.95rem}
    .ls-form-group textarea{min-height:120px;resize:vertical}
    .ls-field-error{color:#fca5a5;font-size:.85rem;margin-top:6px}
</style>
@endpush

@section('content')
    <div class="ls-form-card">
        <form method="POST" action="{{ route('admin.live-sessions.store') }}">
            @csrf

            <div class="ls-form-group">
                <label for="title">Title <span style="color:var(--gold)">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')<div class="ls-field-error">{{ $message }}</div>@enderror
            </div>

            <div class="ls-form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
                @error('description')<div class="ls-field-error">{{ $message }}</div>@enderror
            </div>

            <div class="ls-form-group">
                <label for="scheduled_at">Scheduled Date &amp; Time</label>
                <input type="datetime-local" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}">
                @error('scheduled_at')<div class="ls-field-error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn-sm btn-gold">Create Session</button>
        </form>
    </div>
@endsection
