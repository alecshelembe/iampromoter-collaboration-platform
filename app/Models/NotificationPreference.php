<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    protected $fillable = [
        'device_id',
        'expo_push_token',
        'preferences',
    ];

    protected $casts = [
        'preferences' => 'array',
    ];
}
