<?php

namespace App\Models;

use App\Traits\IsLikable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Mix;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    /**
     * Get likes for the product
     *
     * @return MorphTo
     */
    public function productable(): MorphTo
    {
        return $this->morphTo('productable');
    }

    /**
     * Get categories for the product
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get variations for the product
     *
     * @return HasMany
     */
    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }

    /**
     * Get the gallery key for the model.
     *
     * @return array
     */
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
        return $imageUrls ?: false;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_MAX, 100, 100)
            ->performOnCollections('default', 'gallery');

        $this->addMediaConversion('medium')
            ->fit(Manipulations::FIT_MAX, 400, 400)
            ->performOnCollections('default', 'gallery');

    }
}
