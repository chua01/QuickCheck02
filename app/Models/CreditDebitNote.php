<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditDebitNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'quotation_id',
        'address_id',
        'total',
        'tax',
        'date',
        'type',
    ];
}
