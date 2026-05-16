@extends('layouts.admin')

@section('title', 'Edit Live Session — Admin')
@section('breadcrumb', 'Edit Live Session')
@section('page_eyebrow', 'Live Sessions')
@section('page_title', 'Edit Live Session')

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
        <form method="POST" action="{{ route('admin.live-sessions.update', $session->id) }}">
            @csrf
            @method('PUT')

            <div class="ls-form-group">
                <label for="title">Title <span style="color:var(--gold)">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $session->title) }}" required>
                @error('title')<div class="ls-field-error">{{ $message }}</div>@enderror
            </div>

            <div class="ls-form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description', $session->description) }}</textarea>
                @error('description')<div class="ls-field-error">{{ $message }}</div>@enderror
            </div>

            @include('admin.live-sessions.partials.scheduled-at-field', [
                'value' => old('scheduled_at', $session->scheduled_at?->format('Y-m-d H:i')),
            ])

            <button type="submit" class="btn-sm btn-gold">Update Session</button>
        </form>
    </div>
@endsection

@include('admin.live-sessions.partials.flatpickr-assets')
