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
        'm_payment_id', 
        'pf_payment_id' ,  
        'payment_status' , 
        'item_name' ,
        'item_description',  
        'amount_gross' ,
        'amount_fee' ,
        'amount_net'  ,
        'custom_str1'  ,
        'custom_str2'  ,
        'custom_str3'  ,
        'custom_str4'  ,
        'custom_str5'  ,
        'custom_int1'  ,
        'custom_int2'  ,
        'custom_int3'  ,
        'custom_int4'  ,
        'custom_int5'  ,
        'name_first'    ,             
        'email_address'  ,
        'merchant_id'  ,
        'signature'  ,
    ];
}
