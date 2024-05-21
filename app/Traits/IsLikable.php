<?php

namespace App\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait IsLikable
{
    public function likes():MorphMany
    { 
        return $this->morphMany(Like::class, 'likable')->orderBy('created_at', 'desc');
    }

    public function scopeWithUserLike($query): void
    {
        $query->withCount([
            'likes as user_has_liked' => function (Builder $query) {
                $query->where('user_id', auth()->user()->id);
            },
        ]);
    }

    public function like(int $userOrId, ?bool $calculateSum = false): Model
    {
        $like = $this->likeExists($userOrId);
        $hasLiked = 0;

        if ($like) {
            $like->delete();
            if ($calculateSum) {
                $this->updateLikes(-1);
                $hasLiked = 0;
            }
        } else {
            $like = Like::make($userOrId);
            $this->likes()->save($like);

            if ($calculateSum) {
                $this->updateLikes(1);
                $hasLiked = 1;
            }
        }

        $this->user_has_liked = $hasLiked;
        //$this->load('likes');
        return $this;
    }

    private function updateLikes(int $value): void
    {
        $numberOfLikes = $this->likes()->count() + $value;
        if ($numberOfLikes < 0) {
            $numberOfLikes = 0;
        }

        if ($this->sociable) {
            $this->sociable->no_of_likes = $numberOfLikes;
            $this->sociable->save();
        } else {
            $this->no_of_likes = $numberOfLikes;
            $this->save();
        }
    }

    public function likeExists(int $userId): Model
    {
        $reflect = new ReflectionClass($this);

        return Like::where([
            'user_id' => $userId,
            'likable_id' => $this->id,
            'likable_type' => $reflect->getShortName(),
        ])->first();
    }

    // public function likes()
    // {
    //     $reflect = new ReflectionClass($this);
    //     $modelKey = strtolower($reflect->getShortName());

    //     return $this->belongsToMany(User::class, $modelKey.'_likes', $modelKey.'_id', 'user_id')
    //         ->withTimestamps()
    //         ->withPivot('created_at')
    //         ->orderBy('created_at', 'desc');
    // }

    // public function like($userOrId)
    // {
    //     $validator = Validator::make(['user_id' => $userOrId], [
    //         'user_id' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         throw new ValidationException($validator, $this);
    //     }

    //     $userId = get_object_id(User::class, $userOrId);
    //     $result = $this->likes()->toggle($userId);
    //     $this->no_of_likes = $result['attached'] ? $this->no_of_likes+1:$this->no_of_likes-1;
    //     $this->load('likes');
    //     $this->save();
    //     return $this;
    // }
}
