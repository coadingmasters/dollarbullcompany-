@extends('layouts.admin')
@section('title', 'Blog Posts – Admin')
@section('breadcrumb', 'Blog & News')
@section('page_eyebrow', 'Content Management')
@section('page_title', 'Blog & News')
@section('page_actions')
    <a href="{{ route('admin.blogs.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 18px;background:rgba(201,168,76,.12);color:#E8C97A;border:1px solid rgba(201,168,76,.35);font-family:Cinzel,serif;font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;text-decoration:none;transition:all .2s" onmouseover="this.style.background='rgba(201,168,76,.22)'" onmouseout="this.style.background='rgba(201,168,76,.12)'">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Post
    </a>
@endsection

@push('styles')
<style>
    :root {
        --gold:     #C9A84C;
        --gold-l:   #E8C97A;
        --gold-m:   rgba(201,168,76,.12);
        --gold-b:   rgba(201,168,76,.18);
        --gold-bh:  rgba(201,168,76,.45);
        --card:     #161616;
        --bdr:      rgba(201,168,76,.18);
        --txt:      #D8D0C0;
        --muted:    #7a7060;
    }

    /* ── Stats ── */
    .stats-row { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
    .stat-card {
        background:var(--card); border:1px solid var(--bdr);
        padding:20px 22px; display:flex; align-items:center; gap:14px;
    }
    .stat-icon {
        width:40px; height:40px; border:1px solid var(--bdr);
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
        color:var(--gold);
    }
    .stat-icon svg { width:18px; height:18px; }
    .stat-num  { font-size:1.8rem; font-weight:700; color:var(--gold-l); line-height:1; font-family:Cinzel,serif; }
    .stat-label{ font-size:.7rem; color:var(--muted); margin-top:3px; text-transform:uppercase; letter-spacing:.1em; font-family:Cinzel,serif; }

    /* ── Filter bar ── */
    .filter-bar {
        background:var(--card); border:1px solid var(--bdr);
        padding:14px 18px; margin-bottom:16px;
        display:flex; align-items:center; gap:10px; flex-wrap:wrap;
    }
    .filter-bar form { display:flex; align-items:center; gap:8px; flex-wrap:wrap; flex:1; }
    .search-wrap { position:relative; flex:1; min-width:180px; }
    .search-wrap svg { position:absolute; left:10px; top:50%; transform:translateY(-50%); width:14px; height:14px; color:var(--muted); pointer-events:none; }
    .search-input {
        width:100%; padding:7px 10px 7px 32px;
        background:#0d0d0d; border:1px solid var(--bdr); color:var(--txt);
        font-family:Georgia,serif; font-size:.83rem; outline:none; transition:border-color .18s;
    }
    .search-input::placeholder { color:var(--muted); }
    .search-input:focus { border-color:var(--gold-bh); }
    .filter-select {
        padding:7px 10px; background:#0d0d0d; border:1px solid var(--bdr);
        color:var(--txt); font-family:Georgia,serif; font-size:.83rem; outline:none; cursor:pointer;
    }
    .filter-select:focus { border-color:var(--gold-bh); }
    .btn-gold {
        padding:7px 16px; background:var(--gold-m); color:var(--gold-l);
        border:1px solid var(--gold-b); font-family:Cinzel,serif; font-size:.62rem;
        letter-spacing:.1em; text-transform:uppercase; cursor:pointer;
        text-decoration:none; display:inline-flex; align-items:center; gap:6px;
        transition:all .18s; white-space:nowrap;
    }
    .btn-gold:hover { background:rgba(201,168,76,.22); border-color:var(--gold-bh); }
    .btn-sm {
        padding:4px 12px; font-family:Cinzel,serif; font-size:.58rem;
        letter-spacing:.08em; text-transform:uppercase; cursor:pointer;
        text-decoration:none; display:inline-flex; align-items:center; gap:5px;
        border:1px solid; transition:all .18s;
    }
    .btn-edit   { background:rgba(201,168,76,.08); color:var(--gold-l); border-color:var(--gold-b); }
    .btn-edit:hover { background:var(--gold-m); }
    .btn-view   { background:rgba(39,174,96,.08); color:#6fcf97; border-color:rgba(39,174,96,.25); }
    .btn-view:hover { background:rgba(39,174,96,.15); }
    .btn-delete { background:rgba(192,57,43,.08); color:#e07a72; border-color:rgba(192,57,43,.25); }
    .btn-delete:hover { background:rgba(192,57,43,.15); }

    /* ── Table ── */
    .table-card { background:var(--card); border:1px solid var(--bdr); overflow:hidden; }
    .table-header {
        padding:14px 18px; border-bottom:1px solid var(--bdr);
        display:flex; align-items:center; justify-content:space-between;
    }
    .table-title { font-family:Cinzel,serif; font-size:.72rem; letter-spacing:.15em; text-transform:uppercase; color:var(--gold); }
    table { width:100%; border-collapse:collapse; }
    thead { background:rgba(201,168,76,.04); border-bottom:1px solid var(--bdr); }
    thead th {
        padding:11px 16px; text-align:left;
        font-family:Cinzel,serif; font-size:.62rem; letter-spacing:.15em;
        text-transform:uppercase; color:var(--gold); white-space:nowrap;
    }
    tbody tr { border-bottom:1px solid rgba(201,168,76,.06); transition:background .15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(201,168,76,.03); }
    tbody td { padding:13px 16px; font-size:.84rem; color:var(--txt); vertical-align:middle; }

    .post-title-cell { display:flex; flex-direction:column; gap:3px; }
    .post-title { font-weight:600; color:#D8D0C0; font-size:.86rem; font-family:Cinzel,serif; letter-spacing:.02em; }
    .post-excerpt { font-size:.76rem; color:var(--muted); line-height:1.4; font-style:italic; }

    /* Status badges */
    .badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; font-family:Cinzel,serif; font-size:.58rem; letter-spacing:.1em; text-transform:uppercase; }
    .badge-dot { width:5px; height:5px; border-radius:50%; }
    .badge.published { background:rgba(39,174,96,.1); color:#6fcf97; border:1px solid rgba(39,174,96,.2); }
    .badge.published .badge-dot { background:#27ae60; }
    .badge.draft     { background:rgba(122,112,96,.12); color:var(--muted); border:1px solid rgba(122,112,96,.2); }
    .badge.draft .badge-dot { background:var(--muted); }
    .badge.scheduled { background:rgba(41,128,185,.1); color:#7fb3d3; border:1px solid rgba(41,128,185,.2); }
    .badge.scheduled .badge-dot { background:#2980b9; }

    /* Category */
    .cat-badge {
        display:inline-block; padding:2px 9px;
        background:var(--gold-m); color:var(--gold-l); border:1px solid var(--gold-b);
        font-family:Cinzel,serif; font-size:.58rem; letter-spacing:.08em; text-transform:uppercase;
    }

    .author-cell { display:flex; align-items:center; gap:8px; }
    .author-av {
        width:26px; height:26px; border-radius:50%;
        background:linear-gradient(135deg,#A07810,#D4A017);
        display:flex; align-items:center; justify-content:center;
        font-family:Cinzel,serif; font-size:.6rem; font-weight:700;
        color:#060606; flex-shrink:0;
    }
    .actions-cell { display:flex; align-items:center; gap:6px; }

    input[type="checkbox"] { width:14px; height:14px; accent-color:var(--gold); cursor:pointer; }

    /* Empty state */
    .empty-state {
        text-align:center; padding:70px 20px;
        display:flex; flex-direction:column; align-items:center; gap:14px;
    }
    .empty-icon { width:48px; height:48px; color:var(--muted); opacity:.4; }
    .empty-title { font-family:Cinzel,serif; font-size:.9rem; letter-spacing:.1em; text-transform:uppercase; color:var(--txt); }
    .empty-sub { font-size:.84rem; color:var(--muted); font-style:italic; }

    /* Pagination */
    .pagination-wrap { padding:14px 18px; border-top:1px solid var(--bdr); display:flex; justify-content:flex-end; }
    .pagination-wrap nav { display:flex; gap:4px; align-items:center; }
    .pagination-wrap .page-item a,
    .pagination-wrap .page-item span {
        display:flex; align-items:center; justify-content:center;
        min-width:34px; height:32px; padding:0 8px;
        font-family:Cinzel,serif; font-size:.6rem; letter-spacing:.06em;
        text-decoration:none; border:1px solid var(--bdr);
        color:var(--txt); transition:all .18s; background:#0d0d0d;
    }
    .pagination-wrap .page-item.active span { background:var(--gold-m); color:var(--gold-l); border-color:var(--gold-bh); }
    .pagination-wrap .page-item a:hover { background:var(--gold-m); border-color:var(--gold-bh); color:var(--gold-l); }
    .pagination-wrap .page-item.disabled span { opacity:.3; cursor:not-allowed; }

    @media (max-width:900px) { .stats-row { grid-template-columns:repeat(2,1fr); } }
    @media (max-width:640px) {
        .stats-row { grid-template-columns:1fr 1fr; }
        .filter-bar form { flex-direction:column; align-items:stretch; }
    }
</style>
@endpush

@section('content')
@php
    $total     = \App\Models\Blog::count();
    $published = \App\Models\Blog::where('status','published')->count();
    $drafts    = \App\Models\Blog::where('status','draft')->count();
    $scheduled = \App\Models\Blog::where('status','scheduled')->count();
@endphp

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <div><div class="stat-num">{{ $total }}</div><div class="stat-label">Total Posts</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div><div class="stat-num">{{ $published }}</div><div class="stat-label">Published</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <div><div class="stat-num">{{ $drafts }}</div><div class="stat-label">Drafts</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div><div class="stat-num">{{ $scheduled }}</div><div class="stat-label">Scheduled</div></div>
    </div>
</div>

{{-- Filter bar --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('admin.blogs.index') }}">
        <div class="search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or author…" class="search-input">
        </div>
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="published" {{ request('status')==='published'?'selected':'' }}>Published</option>
            <option value="draft"     {{ request('status')==='draft'    ?'selected':'' }}>Draft</option>
            <option value="scheduled" {{ request('status')==='scheduled'?'selected':'' }}>Scheduled</option>
        </select>
        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach(['General','Tech','Design','Business','Lifestyle'] as $cat)
                <option value="{{ $cat }}" {{ request('category')===$cat?'selected':'' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-gold">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Search
        </button>
        @if(request()->hasAny(['search','status','category']))
            <a href="{{ route('admin.blogs.index') }}" class="btn-sm btn-delete">Clear</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="table-header">
        <span class="table-title">Posts &nbsp;<span style="color:var(--muted);font-weight:400">({{ $blogs->total() }})</span></span>
    </div>

    @if($blogs->isEmpty())
    <div class="empty-state">
        <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        <div class="empty-title">No Posts Found</div>
        <div class="empty-sub">
            @if(request()->hasAny(['search','status','category']))
                Try adjusting your filters or <a href="{{ route('admin.blogs.index') }}" style="color:var(--gold-l)">clear them</a>.
            @else
                Get started by <a href="{{ route('admin.blogs.create') }}" style="color:var(--gold-l)">creating your first post</a>.
            @endif
        </div>
    </div>
    @else
    <div style="overflow-x:auto">
    <table>
        <thead>
            <tr>
                <th style="width:36px"><input type="checkbox" id="selectAll"></th>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Status</th>
                <th>Published</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
            <tr>
                <td><input type="checkbox" class="row-cb" value="{{ $blog->id }}"></td>
                <td>
                    <div class="post-title-cell">
                        <span class="post-title">{{ $blog->title }}</span>
                        @if($blog->excerpt)
                            <span class="post-excerpt">{{ Str::limit($blog->excerpt, 80) }}</span>
                        @endif
                    </div>
                </td>
                <td><span class="cat-badge">{{ $blog->category ?? 'General' }}</span></td>
                <td>
                    <div class="author-cell">
                        <div class="author-av">{{ strtoupper(substr($blog->author ?? 'S', 0, 1)) }}</div>
                        <span style="color:var(--txt)">{{ $blog->author ?? '—' }}</span>
                    </div>
                </td>
                <td>
                    <span class="badge {{ $blog->status }}">
                        <span class="badge-dot"></span>
                        {{ ucfirst($blog->status) }}
                    </span>
                </td>
                <td style="white-space:nowrap;color:var(--muted);font-style:italic">
                    {{ $blog->published_at ? $blog->published_at->format('M d, Y') : '—' }}
                </td>
                <td>
                    <div class="actions-cell">
                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn-sm btn-edit">Edit</a>
                        @if($blog->status === 'published')
                        <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn-sm btn-view">View</a>
                        @endif
                        <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" onsubmit="return confirm('Delete this post? Cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm btn-delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    @if($blogs->hasPages())
    <div class="pagination-wrap">
        {{ $blogs->withQueryString()->links() }}
    </div>
    @endif
    @endif
</div>
@endsection

@push('scripts')
<script>
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.row-cb').forEach(cb => cb.checked = this.checked);
});
</script>
@endpush
