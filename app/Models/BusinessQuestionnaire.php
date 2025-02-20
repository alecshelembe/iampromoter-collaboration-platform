<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessQuestionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'industry',
        'website',
        'social_media',
        'contact_person',
        'email',
        'phone',
        'campaign_goals',
        'brand_story',
        'influencer_size',
        'budget',
        'campaign_type',
        'brand_guidelines',
        'success_metrics',
        'ref'
    ];

    protected $casts = [
        'campaign_goals' => 'array',
    ];
}
