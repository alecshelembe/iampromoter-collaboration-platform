<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'start_date', 
        'end_date', 
        'status', 
        'link', 
        'activity',  // Add activity to the fillable array
        'audience',  // Add activity to the fillable array
        'image_url' // Add image_url here
    ];
}
