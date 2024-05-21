<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'attribute_id'];

    /**
     * Get the attribute of the Model
     *
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Get the variations of the Model
     *
     * @return BelongsToMany
     */
    public function variations(): BelongsToMany
    {
        return $this
            ->belongsToMany(Variation::class, 'attribute_item_variations', 'attribute_item_id', 'variation_id')
            ->withPivot('product_id', 'attribute_id');
    }
}
