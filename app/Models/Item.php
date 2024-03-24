<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'price1',
        'price2',
        'price3',
        'pic',
        'quantity',
        'minlevel',
        'unit',
    ];

}
