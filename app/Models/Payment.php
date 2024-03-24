<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_id',
        'reference_id',
        'reference_type',
        'amount',
        'received_from',
        'status',
        'payment_date',
        'payment_method',
        'notes',
    ];
}
