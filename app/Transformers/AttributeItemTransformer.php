<?php

namespace App\Transformers;

use App\Models\AttributeItem;
use Flugg\Responder\Transformers\Transformer;

class AttributeItemTransformer extends Transformer
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
     * @param  \App\AttributeItem $attribute
     * @return array
     */
    public function transform(AttributeItem $attributeItem)
    {
        return [
            'id' => (int) $attributeItem->id,
            'name' => $attributeItem->name,

            
        ];
    }
}
