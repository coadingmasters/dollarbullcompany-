<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveSessionEnrollment extends Model
{
    protected $fillable = [
        'live_session_id',
        'user_id',
        'status',
        'enrolled_at',
        'approved_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function liveSession()
    {
        return $this->belongsTo(LiveSession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}