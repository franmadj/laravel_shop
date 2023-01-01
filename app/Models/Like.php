<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreLikeRequest;
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

    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public static function make($userOrId)
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
