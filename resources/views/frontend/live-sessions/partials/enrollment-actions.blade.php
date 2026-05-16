@php
    $enrollment = $enrollment ?? null;
@endphp

<div class="ls-card-actions" data-ls-actions>
    @if($session->isEnded())
        <span class="ls-pill ls-pill-muted">Session Ended</span>
    @elseif(!$enrollment)
        <form method="POST" action="{{ route('live-sessions.enroll', $session->id) }}">
            @csrf
            <button type="submit" class="btn ls-btn-primary">Enroll Now</button>
        </form>
    @elseif($enrollment->isPending())
        <span class="ls-pill ls-pill-pending">Pending Approval</span>
    @elseif($enrollment->isRejected())
        <span class="ls-pill ls-pill-rejected">Enrollment Rejected</span>
    @elseif($enrollment->isApproved() && $session->isScheduled())
        <span class="ls-pill ls-pill-approved">Approved — Waiting for session to start</span>
    @elseif($enrollment->isApproved() && $session->isLive())
        <a href="{{ route('live-sessions.join', $session->id) }}" class="btn ls-btn-live" data-ls-join-btn>
            <span class="ls-live-dot"></span> Join Live Now
        </a>
    @elseif($enrollment->isApproved())
        <span class="ls-pill ls-pill-approved">Approved</span>
    @endif
</div>
