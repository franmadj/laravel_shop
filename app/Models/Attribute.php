<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the attributeItems of the Model
     *
     * @return HasMany
     */
    public function attributeItems(): HasMany
    {
        return $this->hasMany(AttributeItem::class);
    }
}
