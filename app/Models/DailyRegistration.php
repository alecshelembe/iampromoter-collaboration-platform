<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRegistration extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'daily_registration';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'email',
        'login_time',
        'merchant_id',
        'merchant_key',
        'return_url',
        'cancel_url',
        'notify_url',
        'name_first',
        'name_last',
        'email_address',
        'cell_number',
        'm_payment_id',
        'custom_int1',
        'custom_str1',
        'email_confirmation',
        'confirmation_address',
        'payment_method',
        'amount',
        'item_name',
        'item_description',
        'payment_status',
        
    ];

    // If you have created_at and updated_at fields and want them to be managed automatically
    public $timestamps = true;
}
