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
        'delivery_address',
        'status',
        'amount',
        'date',
        'discount',
        'extra_fee',
        'delivery',
    ];

    public function customerItem()
    {
        return $this->hasMany(CustomerOrderItem::class, 'quotation_id');
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deliveryaddress()
    {
        return $this->hasOne(Address::class, 'id','delivery_address');
    }
}
