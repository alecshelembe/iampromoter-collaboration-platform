<?php

namespace App\Models;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    use HasFactory;

    protected $table = 'social_posts';

    // Allow mass assignment for these fields
    protected $fillable = ['description', 'images', 'email','status','comments'];

    // Cast the 'images' field to an array
    protected $casts = [
        'images' => 'array',
        'comments' => 'array'
    ];
}
