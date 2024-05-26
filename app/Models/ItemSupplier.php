<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSupplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'item_id',
        'supplier_id',
        'price',
    ];

  
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
   
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
