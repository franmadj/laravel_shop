<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderNote extends Model
{
    use HasFactory;

    protected $fillable = ['note', 'order_id', 'user_id'];

    function Author(){
        return $this->belongsTo(User::class,'user_id');
    }

    function Order(){
        return $this->belongsTo(Order::class);
    }
}
