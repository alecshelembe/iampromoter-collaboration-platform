<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayfastTransaction extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if it's the plural of the model name)
    protected $table = 'payfast_transactions';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'email',
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
}
