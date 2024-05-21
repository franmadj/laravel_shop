<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'in_stock',
    ];

    /**
     * Get the attributes for the variation
     *
     * @return BelongsToMany
     */
    public function AttributeItems():BelongsToMany
    {
        return $this->belongsToMany(AttributeItem::class, 'attribute_item_variations', 'variation_id', 'attribute_item_id')->withPivot('product_id');
    }

    /**
     * Get the product for the variation
     *
     * @return BelongsTo
     */
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
