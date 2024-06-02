<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'supplier_id',
        'date',
        'status',
        'amount',
        'date',
        'discount',
        'extra_fee',
    ];

    
    public function orderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchaseorder_id');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
