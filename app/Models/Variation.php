<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'price',
        'sale_price',
        'stock_quantity',
        'in_stock'
    ];

    function AttributeItems(){
        return $this->belongsToMany(AttributeItem::class,'attribute_item_variations','variation_id','attribute_item_id')->withPivot('product_id');
    }

    function product(){
        return $this->belongsTo(Product::class);
    }
    
}
