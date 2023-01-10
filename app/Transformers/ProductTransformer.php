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
            'is_variable' => (bool) 'variable' == $product->type,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'stock_status' => $product->in_stock ? 'in_stock' : 'out_stock',
            'stock_quantity' => $product->stock_quantity,
            'feature_image' => $product->getFirstMediaUrl(),
            'feature_thumb' => $product->getFirstMediaUrl('default', 'thumb'),
            'feature_medium' => $product->getFirstMediaUrl('default', 'medium'),
            'gallery' => $product->gallery,
            'categories' => $categories->toArray(),
            'categories_text' => implode(' <br/> ', $categories->pluck('name')->toArray()),
            'variations' => json_decode($product->variations),
            'selected_variations' => $this->selectedVariations($product->variations),
            'liked' => auth()->user() ? $product->likes()->where('user_id', auth()->user()->id)->first() : false,
        ];
    }

    public function selectedVariations($variations)
    {
        //dd($variations);
        $variations=json_decode($variations,true);
        $selectedVariations = [];

        if (!empty($variations['possibilities']) && is_array($variations['possibilities'])) {
            foreach ($variations['possibilities'] as $item) {
                if ($item['added']) {
                    $selectedVariations[$item['id']] = [
                        'id' => $item['id'],
                        'name' => implode(' | ',collect($item['items'])->pluck('name')->toArray()),
                        'price' => $item['data']['price']
                    ];
                }

            }

        }

        return $selectedVariations;

    }
}
