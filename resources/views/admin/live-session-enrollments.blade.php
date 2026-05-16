@extends('layouts.admin')

@section('title', 'Live Session Students — Admin')
@section('breadcrumb', 'Live Session Students')
@section('page_eyebrow', 'Services')
@section('page_title', 'Live Session Enrollments')

@push('styles')
<style>
    .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 16px; margin-bottom: 28px; }
    .stat-card { background: var(--bc); border: 1px solid var(--bb); padding: 20px; text-align: center; }
    .stat-value { font-size: 2rem; color: var(--gold-light); font-weight: 700; margin-bottom: 4px; font-family: 'Cinzel', serif; }
    .stat-label { font-size: .72rem; color: var(--wf); text-transform: uppercase; letter-spacing: .1em; }
    .status-badge { display: inline-block; padding: 3px 9px; font-size: .65rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; border-radius: 2px; }
    .status-pending  { background: rgba(234,179,8,.15); color: #fde047; }
    .status-approved { background: rgba(34,197,94,.15); color: #86efac; }
    .status-rejected { background: rgba(239,68,68,.15); color: #fca5a5; }
    .thumb { width: 40px; height: 40px; object-fit: cover; border: 1px solid var(--bb); border-radius: 2px; cursor: pointer; }
    .thumb-link { color: var(--gold-light); font-size: .75rem; text-decoration: underline; }
    .session-tag { font-size: .72rem; color: var(--gold); font-family: 'Cinzel', serif; letter-spacing: .06em; }

    /* Modal */
    .img-modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.88); z-index: 9999; align-items: center; justify-content: center; }
    .img-modal.on { display: flex; }
    .img-modal img { max-width: 90vw; max-height: 88vh; border: 1px solid var(--bb); }
    .img-modal-close { position: absolute; top: 18px; right: 22px; font-size: 1.6rem; color: var(--wd); cursor: pointer; background: none; border: none; line-height: 1; }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert-success" style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#86efac;padding:12px 16px;margin-bottom:20px;font-size:.85rem">
        {{ session('success') }}
    </div>
@endif

<div class="stats">
    <div class="stat-card"><div class="stat-value">{{ $total }}</div><div class="stat-label">Total</div></div>
    <div class="stat-card"><div class="stat-value" style="color:#fde047">{{ $pending }}</div><div class="stat-label">Pending</div></div>
    <div class="stat-card"><div class="stat-value" style="color:#86efac">{{ $approved }}</div><div class="stat-label">Approved</div></div>
    <div class="stat-card"><div class="stat-value" style="color:#fca5a5">{{ $rejected }}</div><div class="stat-label">Rejected</div></div>
</div>

<div class="table-card">
    <div class="card-header">
        <h2 class="card-title">All Registrations</h2>
    </div>

    @if($enrollments->isEmpty())
        <div style="text-align:center;padding:60px 20px;color:var(--wf)">
            <p style="font-size:2rem;margin-bottom:12px">📋</p>
            <p>No live session registrations yet.</p>
        </div>
    @else
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Session</th>
                        <th>WhatsApp</th>
                        <th>Country</th>
                        <th>CICNI</th>
                        <th>Face</th>
                        <th>Payment</th>
                        <th>Enrolled</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                        <tr>
                            <td>
                                <div style="font-weight:600;color:var(--wd)">
                                    {{ trim(($enrollment->first_name ?? '') . ' ' . ($enrollment->last_name ?? '')) ?: ($enrollment->user?->name ?? '—') }}
                                </div>
                                <div style="font-size:.78rem;color:var(--wf)">
                                    {{ $enrollment->email ?? $enrollment->user?->email ?? '—' }}
                                </div>
                            </td>
                            <td>
                                <span class="session-tag">
                                    <a href="{{ route('admin.live-sessions.show', $enrollment->live_session_id) }}" style="color:var(--gold-light);text-decoration:none">
                                        {{ $enrollment->liveSession?->title ?? '—' }}
                                    </a>
                                </span>
                            </td>
                            <td style="font-size:.82rem;color:var(--wd)">{{ $enrollment->whatsapp_number ?? '—' }}</td>
                            <td style="font-size:.82rem;color:var(--wd)">{{ $enrollment->country ?? '—' }}</td>
                            <td style="font-size:.82rem;color:var(--wd)">{{ $enrollment->cicni ?? '—' }}</td>
                            <td>
                                @if($enrollment->face_photo)
                                    <img src="{{ asset('storage/' . $enrollment->face_photo) }}"
                                         class="thumb"
                                         alt="Face photo"
                                         onclick="openModal(this.src)">
                                @else
                                    <span style="color:var(--wf);font-size:.75rem">—</span>
                                @endif
                            </td>
                            <td>
                                @if($enrollment->payment_screenshot)
                                    <a href="{{ asset('storage/' . $enrollment->payment_screenshot) }}"
                                       target="_blank"
                                       class="thumb-link">View</a>
                                @else
                                    <span style="color:var(--wf);font-size:.75rem">—</span>
                                @endif
                            </td>
                            <td style="font-size:.8rem;color:var(--wf);white-space:nowrap">
                                {{ $enrollment->enrolled_at?->format('M j, Y') ?? $enrollment->created_at->format('M j, Y') }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ $enrollment->status }}">{{ ucfirst($enrollment->status) }}</span>
                            </td>
                            <td>
                                @if($enrollment->isPending())
                                    <div style="display:flex;gap:6px;flex-wrap:wrap">
                                        <form method="POST" action="{{ route('admin.live-session-enrollments.approve', $enrollment->id) }}">
                                            @csrf
                                            <button type="submit" class="btn-sm btn-gold">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.live-session-enrollments.reject', $enrollment->id) }}">
                                            @csrf
                                            <button type="submit" class="btn-sm btn-outline-gold" style="color:#fca5a5;border-color:rgba(239,68,68,.4)">Reject</button>
                                        </form>
                                    </div>
                                @elseif($enrollment->isApproved())
                                    <form method="POST" action="{{ route('admin.live-session-enrollments.reject', $enrollment->id) }}">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-outline-gold" style="color:#fca5a5;border-color:rgba(239,68,68,.4)">Revoke</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.live-session-enrollments.approve', $enrollment->id) }}">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-gold">Re-approve</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- Image modal --}}
<div class="img-modal" id="imgModal">
    <button class="img-modal-close" onclick="closeModal()">×</button>
    <img id="modalImg" src="" alt="Preview">
</div>
@endsection

@push('scripts')
<script>
    function openModal(src) {
        document.getElementById('modalImg').src = src;
        document.getElementById('imgModal').classList.add('on');
    }
    function closeModal() {
        document.getElementById('imgModal').classList.remove('on');
    }
    document.getElementById('imgModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endpush
