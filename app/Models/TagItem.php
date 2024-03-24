<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'tag_id',
        'item_id',
    ];
}
