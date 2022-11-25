<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeItem extends Model
{
    use HasFactory;

    protected $fillable = ['name','attribute_id'];

    function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    function variations(){
        return $this->belongsToMany(Variations::class,'attribute_item_variations','attribute_item_id','variation_id')->withPivot('product_id');
    }
}
