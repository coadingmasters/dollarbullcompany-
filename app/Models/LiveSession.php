<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveSession extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'agora_channel_name',
        'admin_id',
        'scheduled_at',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function enrollments()
    {
        return $this->hasMany(LiveSessionEnrollment::class);
    }

    public function isLive()
    {
        return $this->status === 'live';
    }

    public function isEnded()
    {
        return $this->status === 'ended';
    }

    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }
}