<?php

namespace App\Events;

use App\Models\LiveSessionEnrollment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EnrollmentApproved implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(public LiveSessionEnrollment $enrollment) {}

    public function broadcastOn(): array
    {
        return [new Channel('live-session.' . $this->enrollment->live_session_id)];
    }

    public function broadcastAs(): string
    {
        return 'EnrollmentApproved';
    }

    public function broadcastWith(): array
    {
        return [
            'enrollment_id' => $this->enrollment->id,
            'user_id'       => $this->enrollment->user_id,
            'session_id'    => $this->enrollment->live_session_id,
        ];
    }
}
