<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'customer_id',
        'billing_address',
        'delivery_address',
        'status',
        'amount',
        'issued_by',
        'date',
        'payment_id',
        'notes',
        'discount',
        'tax',
        'extra_fee',
        'delivery_fee',
    ];

}
