@extends('layouts.frontend')

@section('title', 'Live Sessions — ' . config('app.name', 'CryptoOnly'))

@push('styles')
<style>
    :root { --gold:#C9A84C; --gold-light:#E8C97A; --card:#161616; --border:rgba(201,168,76,.18); --text:#D8D0C0; --muted:#7a7060; }
    .ls-page { padding: 20px 20px 56px; max-width: 1200px; margin: 0 auto; }
    .ls-hd { text-align: center; margin-bottom: 28px; }
    .ls-tag { display: inline-block; font-family: Cinzel, serif; font-size: 9px; letter-spacing: .22em; color: var(--gold); border: 1px solid var(--border); padding: 4px 14px; margin-bottom: 10px; }
    .ls-hd h1 { font-family: Cinzel, serif; font-size: clamp(1.4rem, 4vw, 2.2rem); color: #fff; }
    .ls-hd h1 em { color: var(--gold); font-style: normal; }
    .flash { padding: 12px 16px; margin-bottom: 20px; border: 1px solid var(--border); background: rgba(201,168,76,.08); color: var(--gold-light); }
    .flash.err { border-color: rgba(192,57,43,.4); color: #e07b73; background: rgba(192,57,43,.1); }
    .ls-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; }
    .ls-card { background: var(--card); border: 1px solid var(--border); display: flex; flex-direction: column; transition: border-color .3s, transform .3s; }
    .ls-card:hover { border-color: rgba(201,168,76,.45); transform: translateY(-3px); }
    .ls-card-body { padding: 22px; flex: 1; display: flex; flex-direction: column; }
    .ls-card-title { font-family: Cinzel, serif; font-size: 1.05rem; color: #fff; margin-bottom: 10px; }
    .ls-card-desc { font-size: .85rem; color: var(--muted); line-height: 1.5; margin-bottom: 12px; flex: 1; }
    .ls-card-meta { font-size: .78rem; color: var(--muted); margin-bottom: 14px; }
    .ls-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; font-family: Cinzel, serif; font-size: 7px; letter-spacing: .14em; text-transform: uppercase; border: 1px solid transparent; margin-bottom: 12px; }
    .ls-badge-scheduled { background: rgba(255,193,7,.12); color: #ffd54f; border-color: rgba(255,193,7,.35); }
    .ls-badge-live { background: rgba(39,174,96,.15); color: #7dcea0; border-color: rgba(39,174,96,.4); }
    .ls-badge-ended { background: rgba(192,57,43,.15); color: #e07b73; border-color: rgba(192,57,43,.4); }
    .ls-live-dot { width: 6px; height: 6px; border-radius: 50%; background: #27ae60; animation: lsPulse 1.2s ease-in-out infinite; }
    @keyframes lsPulse { 0%, 100% { opacity: 1; } 50% { opacity: .35; } }
    .ls-card-actions { margin-top: auto; padding-top: 14px; border-top: 1px solid var(--border); }
    .ls-card-actions form { margin: 0; }
    .btn { display: block; width: 100%; text-align: center; padding: 10px; border: 1px solid var(--gold); color: var(--gold-light); font-family: Cinzel, serif; font-size: .68rem; letter-spacing: .14em; text-transform: uppercase; text-decoration: none; background: transparent; cursor: pointer; transition: background .25s, color .25s; }
    .btn:hover { background: var(--gold); color: #0d0d0d; }
    .ls-btn-primary { border-color: var(--gold); }
    .ls-btn-live { background: rgba(39,174,96,.12); border-color: rgba(39,174,96,.5); color: #7dcea0; display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
    .ls-btn-live:hover { background: rgba(39,174,96,.25); color: #fff; }
    .ls-pill { display: block; text-align: center; padding: 10px; font-family: Cinzel, serif; font-size: .65rem; letter-spacing: .12em; text-transform: uppercase; border: 1px solid var(--border); color: var(--muted); }
    .ls-pill-pending { color: #ffd54f; border-color: rgba(255,193,7,.35); background: rgba(255,193,7,.08); }
    .ls-pill-approved { color: #7dcea0; border-color: rgba(39,174,96,.35); background: rgba(39,174,96,.08); }
    .ls-pill-rejected { color: #e07b73; border-color: rgba(192,57,43,.35); background: rgba(192,57,43,.08); }
    .ls-pill-muted { opacity: .85; }
    .ls-empty { text-align: center; padding: 48px; color: var(--muted); grid-column: 1 / -1; }
    .ls-view-link { font-size: .75rem; color: var(--gold-light); text-decoration: none; margin-top: 8px; display: inline-block; }
    .ls-view-link:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<div class="ls-page">
    <header class="ls-hd">
        <div class="ls-tag">Live</div>
        <h1>Live <em>Sessions</em></h1>
    </header>

    @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="flash err">{{ session('error') }}</div>@endif

    <div class="ls-grid">
        @forelse($sessions as $session)
            @php $enrollment = $enrollments[$session->id] ?? null; @endphp
            <article class="ls-card">
                <div class="ls-card-body">
                    @if($session->status === 'scheduled')
                        <span class="ls-badge ls-badge-scheduled">Scheduled</span>
                    @elseif($session->status === 'live')
                        <span class="ls-badge ls-badge-live"><span class="ls-live-dot"></span> Live</span>
                    @else
                        <span class="ls-badge ls-badge-ended">Ended</span>
                    @endif
                    <h2 class="ls-card-title">{{ $session->title }}</h2>
                    <p class="ls-card-desc">{{ Str::limit($session->description ?? 'No description.', 120) }}</p>
                    <p class="ls-card-meta">
                        @if($session->scheduled_at)
                            {{ $session->scheduled_at->format('M j, Y · g:i A') }}
                        @else
                            Schedule TBA
                        @endif
                    </p>
                    @include('frontend.live-sessions.partials.enrollment-actions', ['session' => $session, 'enrollment' => $enrollment])
                    <a href="{{ route('live-sessions.show', $session->id) }}" class="ls-view-link">View details →</a>
                </div>
            </article>
        @empty
            <div class="ls-empty">
                <p style="font-size:2rem;margin-bottom:12px">📡</p>
                <p>No live sessions available right now.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
