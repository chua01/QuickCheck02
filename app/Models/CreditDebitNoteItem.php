<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditDebitNoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'creditdebitnote_id',
        'item_id',
        'quantity',
        'price',
        'amount',
        'unit',
    ];
}
