<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'cart_total', 'cart_items', 'buyer_details'];

    protected $casts = [
        'buyer_details' => 'array',
        'cart_items' => 'array',
    ];

    public function products()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function notes()
    {
        return $this->hasMany(OrderNote::class);
    }

    public function getBuyerNameAttribute()
    {
        $name = [];
        if (is_array($this->buyer_details)) {
            if (!empty($this->buyer_details['first_name'])) {
                $name[] = $this->buyer_details['first_name'];
            }
            if (!empty($this->buyer_details['last_name'])) {
                $name[] = $this->buyer_details['last_name'];
            }
        }
        return implode(' ',$name);
    }
}
