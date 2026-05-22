<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveSessionMessage extends Model
{
    protected $fillable = [
        'live_session_id',
        'student_name',
        'message',
    ];

    public function liveSession()
    {
        return $this->belongsTo(LiveSession::class);
    }
}
