<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Like extends Model
{

    protected $rules = [
        'user_id' => 'required',
    ];

    protected $fillable = [
        'user_id',
    ];

    //protected $with = ['user'];

    protected $dates = ['created_at', 'updated_at'];

    protected $throwValidationExceptions = true;

    /**
     * Get the Models of the Model
     *
     * @return MorphTo
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user of the Model
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Validation
     *
     * @return Like
     */
    public static function make($userOrId): self
    {
        $validator = Validator::make(['user_id' => $userOrId], [
            'user_id' => 'required',
        ]);
        $like = new self();
        if ($validator->fails()) {
            throw ValidationException::withMessages(['user_id' => 'This value is required']);
        }

        $userId = get_object_id(User::class, $userOrId);
        $like->user_id = $userId;
        return $like;
    }
}
