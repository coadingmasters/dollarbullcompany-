<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P2pRegistration extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'whatsapp_number',
        'country', 'exchange', 'payment_screenshot', 'status', 'notes',
    ];
}
