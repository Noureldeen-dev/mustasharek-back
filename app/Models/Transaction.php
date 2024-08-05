<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'result',
        'amount',
        'store_id',
        'our_ref',
        'payment_method',
        'customer_phone',
        'custom_ref',
    ];
    protected $attributes = [
        'result' => 'success',
    ];

}
