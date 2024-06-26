<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'inout',
        'description',
        'quantity',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
