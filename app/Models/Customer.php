<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'gender',
        'email',
        'pinned',
        'address_id',
    ];

    public function contact()
    {
        return $this->hasMany(Contact::class, 'person_id')->where('type', 'customer');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function customerorder(){
        return $this->hasMany(Quotation::class, 'customer_id');
    }
}
