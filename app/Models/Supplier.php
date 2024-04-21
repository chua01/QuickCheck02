<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'email',
        'pinned',
        'address_id',
    ];

    public function contact()
    {
        return $this->hasMany(Contact::class, 'person_id')->where('type', 'supplier');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
