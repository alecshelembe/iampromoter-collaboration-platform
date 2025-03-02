<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Correct base class
use Illuminate\Notifications\Notifiable;

class GoogleUser extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'google_id',
        'name',
        'email',
        'avatar',
    ];
}
