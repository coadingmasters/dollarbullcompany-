<?php

namespace App\Events;

use App\Models\LiveSessionEnrollment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewLiveSessionEnrollment implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(public LiveSessionEnrollment $enrollment) {}

    public function broadcastOn(): array
    {
        return [new Channel('live-session-admin.' . $this->enrollment->live_session_id)];
    }

    public function broadcastAs(): string
    {
        return 'new-enrollment';
    }

    public function broadcastWith(): array
    {
        $name = trim(($this->enrollment->first_name ?? '') . ' ' . ($this->enrollment->last_name ?? ''));
        return [
            'enrollment_id' => $this->enrollment->id,
            'name'          => $name ?: 'New Student',
            'email'         => $this->enrollment->email ?? '',
            'country'       => $this->enrollment->country ?? '',
            'whatsapp'      => $this->enrollment->whatsapp_number ?? '',
            'session_id'    => $this->enrollment->live_session_id,
        ];
    }
}
