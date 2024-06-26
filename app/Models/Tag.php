<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'item_tag'
    ];

    public function items()
{
    return $this->belongsToMany(Item::class, 'tag_items');
}

}
