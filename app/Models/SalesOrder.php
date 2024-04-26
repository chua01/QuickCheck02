<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'id',
        'quotation_id',
        'amount',
        'issued_by',
        'status',
        'date',
        'notes',
    ];

    public function items()
    {
        return $this->hasMany(CustomerOrderItem::class, 'quotation_id');
    }
}