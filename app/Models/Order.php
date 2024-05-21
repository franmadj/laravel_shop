<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'cart_total', 'cart_items', 'buyer_details'];

    protected $casts = [
        'buyer_details' => 'array',
        'cart_items' => 'array',
    ];

    /**
     * Get the products of the Model
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user of the Model
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the orderItems of the Model
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the notes of the Model
     *
     * @return HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(OrderNote::class);
    }

    /**
     * Get the buyer name of the Model
     *
     * @return string
     */
    public function getBuyerNameAttribute(): string
    {
        $name = [];
        if (is_array($this->buyer_details)) {
            if (!empty($this->buyer_details['first_name'])) {
                $name[] = $this->buyer_details['first_name'];
            }
            if (!empty($this->buyer_details['last_name'])) {
                $name[] = $this->buyer_details['last_name'];
            }
        }
        return implode(' ', $name);
    }
}
