<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    function products(){
        return $this->hasMany(ItemOrder::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }
}
