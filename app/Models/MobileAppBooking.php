<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileAppBooking extends Model
{
    use HasFactory;

    protected $table = 'mobile_app_bookings';

    protected $fillable = [
        'name',
        'email',
        'notes',
        'datetime',
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];
}
