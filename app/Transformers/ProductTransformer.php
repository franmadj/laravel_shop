<?php

namespace App\Transformers;

use App\Models\Product;
use Flugg\Responder\Transformers\Transformer;

class ProductTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Product $product
     * @return array
     */
    public function transform(Product $product)
    {
        $categories = $product->categories;
        return [
            'id' => (int) $product->id,
            'title' => $product->title,
            'slug' => $product->slug,
            'content' => $product->content,
            'status' => $product->status,
            'type' => $product->type,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'stock_status' => $product->in_stock ? 'in_stock' : 'out_stock',
            'stock_quantity' => $product->stock_quantity,
            'feature_image' => $product->getFirstMediaUrl(),
            'gallery' => $product->gallery,
            'categories' => $categories->toArray(),
            'categories_text' => implode(' <br/> ', $categories->pluck('name')->toArray()),
            'variations' => $product->variations
        ];
    }
}
