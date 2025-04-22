<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLocation extends Model
{
    use HasFactory;

    protected $table = 'user_locations';

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'location_recorded_at',
        'device_id',
        'device_name',
        'platform',
        'app_version',
        'expo_push_token',
        'last_active_at',
        'address',
    ];

    protected $casts = [
        'location_recorded_at' => 'datetime',
        'last_active_at' => 'datetime',
    ];

    /**
     * Optional: Relationship to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
