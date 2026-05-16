<?php

namespace App\Events;

use App\Models\LiveSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class SessionEnded implements ShouldBroadcastNow
{
    use SerializesModels;

    public $session;

    public function __construct(LiveSession $session)
    {
        $this->session = $session;
    }

    public function broadcastOn()
    {
        return new Channel('live-session.' . $this->session->id);
    }

    public function broadcastAs()
    {
        return 'SessionEnded';
    }
}