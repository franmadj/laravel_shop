<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderNote extends Model
{
    use HasFactory;

    protected $fillable = ['note', 'order_id', 'user_id'];

    /**
     * Get the author of the Model
     *
     * @return BelongsTo
     */
    public function Author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the Order of the Model
     *
     * @return BelongsTo
     */
    public function Order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
