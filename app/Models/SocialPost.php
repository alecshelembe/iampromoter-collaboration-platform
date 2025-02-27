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
    protected $fillable = ['created_at','id','fee','description', 'images', 'email','status','comments','extras','place_name','floating_sectors_value','address','note','video_link'];

    // Cast the 'images' field to an array
    protected $casts = [
        'images' => 'array',
        'comments' => 'array',
        'extras' => 'array'
    ];
}
