@extends('layouts.admin')

@section('title', $session->title . ' — Live Session')
@section('breadcrumb', $session->title)
@section('page_eyebrow', 'Live Sessions')
@section('page_title', $session->title)

@section('page_actions')
    @if($session->isScheduled())
        <form method="POST" action="{{ route('admin.live-sessions.go-live', $session->id) }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-sm btn-gold">Go Live</button>
        </form>
    @endif
    @if($session->isLive())
        <a href="{{ route('admin.live-sessions.broadcast', $session->id) }}" class="btn-sm btn-gold" style="background:rgba(34,197,94,.15);border-color:rgba(34,197,94,.5);color:#86efac">
            ● Enter Broadcast Studio
        </a>
        <form method="POST" action="{{ route('admin.live-sessions.end', $session->id) }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-sm btn-outline-gold" style="color:#fca5a5;border-color:rgba(239,68,68,.4)">End Session</button>
        </form>
    @endif
    <a href="{{ route('admin.live-sessions.edit', $session->id) }}" class="btn-sm btn-outline-gold">Edit</a>
@endsection

@push('styles')
<style>
    .ls-badge{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;font-family:'Cinzel',serif;font-size:.55rem;letter-spacing:.12em;text-transform:uppercase;border-radius:2px;border:1px solid transparent}
    .ls-badge-scheduled{background:rgba(234,179,8,.12);color:#fde047;border-color:rgba(234,179,8,.35)}
    .ls-badge-live{background:rgba(34,197,94,.12);color:#86efac;border-color:rgba(34,197,94,.35)}
    .ls-badge-ended{background:rgba(239,68,68,.12);color:#fca5a5;border-color:rgba(239,68,68,.35)}
    .ls-badge-pending{background:rgba(234,179,8,.12);color:#fde047;border-color:rgba(234,179,8,.35)}
    .ls-badge-approved{background:rgba(34,197,94,.12);color:#86efac;border-color:rgba(34,197,94,.35)}
    .ls-badge-rejected{background:rgba(239,68,68,.12);color:#fca5a5;border-color:rgba(239,68,68,.35)}
    .ls-live-dot{width:7px;height:7px;border-radius:50%;background:#22c55e;animation:lsPulse 1.2s ease-in-out infinite}
    @keyframes lsPulse{0%,100%{opacity:1}50%{opacity:.4}}
    .ls-details{background:var(--bc);border:1px solid var(--bb);padding:24px;margin-bottom:24px}
    .ls-details dl{display:grid;grid-template-columns:160px 1fr;gap:12px 20px;font-size:.92rem}
    .ls-details dt{font-family:'Cinzel',serif;font-size:.58rem;letter-spacing:.14em;text-transform:uppercase;color:var(--gold)}
    .ls-details dd{color:var(--wd);margin:0}
    .ls-empty{text-align:center;padding:40px;color:var(--wf)}
    .ls-actions{display:flex;flex-wrap:wrap;gap:6px}
    .ls-actions form{display:inline}
</style>
@endpush

@section('content')
    <div class="ls-details">
        <dl>
            <dt>Title</dt><dd>{{ $session->title }}</dd>
            <dt>Description</dt><dd>{{ $session->description ?: '—' }}</dd>
            <dt>Status</dt>
            <dd>
                @if($session->status === 'scheduled')
                    <span class="ls-badge ls-badge-scheduled">Scheduled</span>
                @elseif($session->status === 'live')
                    <span class="ls-badge ls-badge-live"><span class="ls-live-dot"></span> Live</span>
                @else
                    <span class="ls-badge ls-badge-ended">Ended</span>
                @endif
            </dd>
            <dt>Scheduled</dt><dd>{{ $session->scheduled_at?->format('M j, Y g:i A') ?? '—' }}</dd>
            <dt>Started at</dt><dd>{{ $session->started_at?->format('M j, Y g:i A') ?? '—' }}</dd>
            <dt>Ended at</dt><dd>{{ $session->ended_at?->format('M j, Y g:i A') ?? '—' }}</dd>
            <dt>Agora channel</dt><dd><code style="color:var(--gold-light)">{{ $session->agora_channel_name }}</code></dd>
        </dl>
    </div>

    <div class="table-card">
        <div class="card-header">
            <h2 class="card-title">Enrolled Users</h2>
        </div>

        @if($session->enrollments->isEmpty())
            <div class="ls-empty">No enrollments yet.</div>
        @else
            <div style="overflow-x:auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Enrolled Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($session->enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->user?->name ?? '—' }}</td>
                                <td>{{ $enrollment->user?->email ?? '—' }}</td>
                                <td>{{ $enrollment->enrolled_at?->format('M j, Y g:i A') ?? '—' }}</td>
                                <td>
                                    @if($enrollment->status === 'pending')
                                        <span class="ls-badge ls-badge-pending">Pending</span>
                                    @elseif($enrollment->status === 'approved')
                                        <span class="ls-badge ls-badge-approved">Approved</span>
                                    @else
                                        <span class="ls-badge ls-badge-rejected">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if($enrollment->isPending())
                                        <div class="ls-actions">
                                            <form method="POST" action="{{ route('admin.live-sessions.enrollments.approve', [$session->id, $enrollment->id]) }}">
                                                @csrf
                                                <button type="submit" class="btn-sm btn-gold">Approve</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.live-sessions.enrollments.reject', [$session->id, $enrollment->id]) }}">
                                                @csrf
                                                <button type="submit" class="btn-sm btn-outline-gold" style="color:#fca5a5">Reject</button>
                                            </form>
                                        </div>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
