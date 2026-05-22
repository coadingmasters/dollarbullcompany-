<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LiveSessionComment implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int    $sessionId,
        public string $name,
        public string $message,
        public string $time,
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel('live-session-admin.' . $this->sessionId)];
    }

    public function broadcastAs(): string
    {
        return 'new-comment';
    }

    public function broadcastWith(): array
    {
        return [
            'name'    => $this->name,
            'message' => $this->message,
            'time'    => $this->time,
        ];
    }
}
