<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
   use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'whatsapp_number',
        'country', 'experience', 'enrollment_type',
        'course', 'payment_screenshot', 'status',
    ];
}
