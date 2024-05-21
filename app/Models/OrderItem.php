<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'order_id', 'product_id', 'variation_id', 'title', 'price'];

    public $timestamps = false;

    /**
     * Get the product of the Model
     *
     * @return BelongsTo
     */
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the order of the Model
     *
     * @return BelongsTo
     */
    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

}
