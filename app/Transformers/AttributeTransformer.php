<?php

namespace App\Transformers;

use App\Models\Attribute;
use Flugg\Responder\Transformers\Transformer;

class AttributeTransformer extends Transformer
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
     * @param  \App\Attribute $attribute
     * @return array
     */
    public function transform(Attribute $attribute)
    {
        return [
            'id' => (int) $attribute->id,
            'name' => $attribute->name,
            'items' => $attribute->attributeItems,

            
        ];
    }
}
