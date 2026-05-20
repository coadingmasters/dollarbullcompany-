@extends('layouts.admin')
@section('title', 'Edit: ' . $blog->title . ' – Admin')
@section('breadcrumb', 'Blog & News')
@section('page_eyebrow', 'Content Management')
@section('page_title', 'Edit Post')
@section('page_actions')
    @if($blog->status === 'published')
    <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(39,174,96,.08);color:#6fcf97;border:1px solid rgba(39,174,96,.25);font-family:Cinzel,serif;font-size:.62rem;letter-spacing:.1em;text-transform:uppercase;text-decoration:none">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        View Live
    </a>
    @endif
    <a href="{{ route('admin.blogs.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(201,168,76,.08);color:#E8C97A;border:1px solid rgba(201,168,76,.25);font-family:Cinzel,serif;font-size:.62rem;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;transition:all .2s" onmouseover="this.style.background='rgba(201,168,76,.18)'" onmouseout="this.style.background='rgba(201,168,76,.08)'">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        All Posts
    </a>
@endsection

@section('content')
@include('admin.blogs._form', ['blog' => $blog])
@endsection
