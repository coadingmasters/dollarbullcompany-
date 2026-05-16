@extends('layouts.admin')

@section('title', 'Live Sessions — Admin')
@section('breadcrumb', 'Live Sessions')
@section('page_eyebrow', 'Services')
@section('page_title', 'Live Sessions')

@section('page_actions')
    <a href="{{ route('admin.live-sessions.create') }}" class="btn-sm btn-gold">+ Create New Session</a>
@endsection

@push('styles')
<style>
    .ls-badge{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;font-family:'Cinzel',serif;font-size:.55rem;letter-spacing:.12em;text-transform:uppercase;border-radius:2px;border:1px solid transparent}
    .ls-badge-scheduled{background:rgba(234,179,8,.12);color:#fde047;border-color:rgba(234,179,8,.35)}
    .ls-badge-live{background:rgba(34,197,94,.12);color:#86efac;border-color:rgba(34,197,94,.35)}
    .ls-badge-ended{background:rgba(239,68,68,.12);color:#fca5a5;border-color:rgba(239,68,68,.35)}
    .ls-live-dot{width:7px;height:7px;border-radius:50%;background:#22c55e;animation:lsPulse 1.2s ease-in-out infinite}
    @keyframes lsPulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.85)}}
    .ls-actions{display:flex;flex-wrap:wrap;gap:6px}
    .ls-actions form{display:inline}
    .ls-empty{text-align:center;padding:48px 24px;color:var(--wf)}
    .btn-sm.btn-danger-outline{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.4);color:#fca5a5}
    .btn-sm.btn-live{background:rgba(34,197,94,.15);border:1px solid rgba(34,197,94,.45);color:#86efac}
    .btn-sm.btn-end{background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.4);color:#fca5a5}
</style>
@endpush

@section('content')
    <div class="table-card">
        @if($sessions->isEmpty())
            <div class="ls-empty">
                <p style="font-size:2rem;margin-bottom:12px">📡</p>
                <h2 style="font-family:'Cinzel',serif;color:var(--white);margin-bottom:8px">No live sessions yet</h2>
                <p>Create your first session to start enrolling students.</p>
            </div>
        @else
            <div style="overflow-x:auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Scheduled Date</th>
                            <th>Total Enrollments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                            <tr>
                                <td><strong style="color:var(--white)">{{ $session->title }}</strong></td>
                                <td>
                                    @if($session->status === 'scheduled')
                                        <span class="ls-badge ls-badge-scheduled">Scheduled</span>
                                    @elseif($session->status === 'live')
                                        <span class="ls-badge ls-badge-live"><span class="ls-live-dot"></span> Live</span>
                                    @else
                                        <span class="ls-badge ls-badge-ended">Ended</span>
                                    @endif
                                </td>
                                <td>{{ $session->scheduled_at?->format('M j, Y g:i A') ?? '—' }}</td>
                                <td>{{ $session->enrollments_count }}</td>
                                <td>
                                    <div class="ls-actions">
                                        <a href="{{ route('admin.live-sessions.show', $session->id) }}" class="btn-sm btn-outline-gold">View</a>
                                        <a href="{{ route('admin.live-sessions.edit', $session->id) }}" class="btn-sm btn-outline-gold">Edit</a>
                                        @if($session->isScheduled())
                                            <form method="POST" action="{{ route('admin.live-sessions.go-live', $session->id) }}">
                                                @csrf
                                                <button type="submit" class="btn-sm btn-live">Go Live</button>
                                            </form>
                                        @endif
                                        @if($session->isLive())
                                            <a href="{{ route('admin.live-sessions.broadcast', $session->id) }}" class="btn-sm btn-live">● Broadcast Studio</a>
                                            <form method="POST" action="{{ route('admin.live-sessions.end', $session->id) }}">
                                                @csrf
                                                <button type="submit" class="btn-sm btn-end">End Session</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.live-sessions.destroy', $session->id) }}" onsubmit="return confirm('Delete this live session?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-danger-outline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
