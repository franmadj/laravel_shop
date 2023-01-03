<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Traits\IsLikable;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, IsLikable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'type',
        'price',
        'sale_price',
        'in_stock',
        'stock_quantity',
    ];

    protected $with = ['productable.user'];

    public function productable()
    {
        return $this->morphTo('productable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function getGalleryAttribute()
    {
        $images = $this->getMedia('gallery');
        //dd($images);
        $imageUrls = [];
        foreach ($images as $image) {
            $imageUrls['original'][] = $image->getFullUrl();
            $imageUrls['medium'][] = $image->getFullUrl('medium');
            $imageUrls['thumb'][] = $image->getFullUrl('thumb');

        }
        return $imageUrls;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_MAX, 100, 100)
            ->performOnCollections('default','gallery');
        
        $this->addMediaConversion('medium')
            ->fit(Manipulations::FIT_MAX, 400, 400)
            ->performOnCollections('default','gallery');


    }
}
