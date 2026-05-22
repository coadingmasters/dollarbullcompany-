@extends('layouts.admin')

@section('title', 'Hero Slider — Admin')
@section('breadcrumb', 'Hero Slider')
@section('page_eyebrow', 'Content')
@section('page_title', 'Hero Slider')
@section('page_actions')
    <a href="{{ route('admin.sliders.create') }}" class="btn-sm btn-gold">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add New Slide
    </a>
@endsection

@push('styles')
<style>
.slider-grid { display: flex; flex-direction: column; gap: 14px; }
.slide-card {
    display: grid;
    grid-template-columns: 160px 1fr auto;
    gap: 0;
    background: var(--bc);
    border: 1px solid var(--bb);
    border-radius: 3px;
    overflow: hidden;
    transition: border-color .25s;
}
.slide-card:hover { border-color: rgba(212,160,23,.3); }
.slide-thumb {
    width: 160px; height: 100px; object-fit: cover;
    display: block; flex-shrink: 0;
}
.slide-thumb-placeholder {
    width: 160px; height: 100px; background: #111;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.2); font-size: .7rem; font-family: Cinzel, serif;
    letter-spacing: .1em; flex-shrink: 0;
}
.slide-body {
    padding: 14px 18px; flex: 1; display: flex; flex-direction: column; justify-content: center; gap: 4px;
}
.slide-badge-text {
    font-family: Cinzel, serif; font-size: .55rem; letter-spacing: .2em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 4px;
}
.slide-headline-text {
    font-family: Cinzel, serif; font-size: .9rem; color: #fff; font-weight: 600;
}
.slide-headline-text em { color: var(--gold-light); font-style: normal; }
.slide-sub-text { font-size: .8rem; color: var(--wf); line-height: 1.4; margin-top: 2px; }
.slide-meta { display: flex; gap: 8px; margin-top: 8px; align-items: center; flex-wrap: wrap; }
.slide-order-badge {
    font-family: Cinzel, serif; font-size: .52rem; letter-spacing: .1em; text-transform: uppercase;
    padding: 2px 8px; border: 1px solid var(--bb); color: var(--wf);
}
.slide-actions {
    padding: 14px 16px; display: flex; flex-direction: column; justify-content: center;
    gap: 8px; border-left: 1px solid var(--bb); flex-shrink: 0;
}
.slide-actions .btn-sm { min-width: 80px; justify-content: center; }
.btn-danger { background: rgba(239,68,68,.12); border: 1px solid rgba(239,68,68,.35); color: #fca5a5; }
.btn-danger:hover { background: rgba(239,68,68,.22); }
.empty-state {
    text-align: center; padding: 60px 20px;
    background: var(--bc); border: 1px dashed var(--bb); border-radius: 3px;
}
.empty-state p { color: var(--wf); font-size: .9rem; margin-bottom: 20px; }
.status-pill {
    display: inline-flex; align-items: center; gap: 5px;
    font-family: Cinzel, serif; font-size: .5rem; letter-spacing: .1em; text-transform: uppercase;
    padding: 2px 8px; border-radius: 10px;
}
.status-pill.active   { background: rgba(34,197,94,.1); border: 1px solid rgba(34,197,94,.3); color: #4ade80; }
.status-pill.inactive { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); color: #f87171; }
.status-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
</style>
@endpush

@section('content')

@if($sliders->isEmpty())
    <div class="empty-state">
        <p>No slides yet. Add your first hero slide.</p>
        <a href="{{ route('admin.sliders.create') }}" class="btn-sm btn-gold">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add First Slide
        </a>
    </div>
@else
    <div style="margin-bottom:12px;font-size:.82rem;color:var(--wf)">
        {{ $sliders->count() }} slide(s) — sorted by <strong style="color:var(--gold)">Sort Order</strong> on the frontend.
        Active slides appear on the homepage.
    </div>

    <div class="slider-grid">
        @foreach($sliders as $slide)
        <div class="slide-card">
            {{-- Thumbnail --}}
            @if($slide->image_url)
                <img class="slide-thumb" src="{{ $slide->image_url }}" alt="{{ $slide->badge }}" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="slide-thumb-placeholder" style="display:none">No Image</div>
            @else
                <div class="slide-thumb-placeholder">No Image</div>
            @endif

            {{-- Details --}}
            <div class="slide-body">
                <div class="slide-badge-text">{{ $slide->badge ?: '—' }}</div>
                <div class="slide-headline-text">
                    {{ $slide->headline }}
                    @if($slide->highlight)
                        <em>{{ $slide->highlight }}</em>
                    @endif
                </div>
                <div class="slide-sub-text">{{ Str::limit($slide->sub, 100) }}</div>
                <div class="slide-meta">
                    <span class="slide-order-badge">Order: {{ $slide->sort_order }}</span>
                    <span class="status-pill {{ $slide->is_active ? 'active' : 'inactive' }}">
                        <span class="status-dot"></span>
                        {{ $slide->is_active ? 'Active' : 'Hidden' }}
                    </span>
                    @if($slide->btn1_label)
                        <span style="font-size:.72rem;color:var(--wf)">
                            <span style="color:var(--gold)">{{ $slide->btn1_label }}</span>
                            → {{ $slide->btn1_url }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="slide-actions">
                <a href="{{ route('admin.sliders.edit', $slide) }}" class="btn-sm btn-outline-gold">Edit</a>
                <form method="POST" action="{{ route('admin.sliders.destroy', $slide) }}"
                      onsubmit="return confirm('Delete this slide?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger" style="width:100%;border-radius:2px">Delete</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
