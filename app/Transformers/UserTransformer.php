<?php

namespace App\Transformers;

use App\Models\User;
use Flugg\Responder\Transformers\Transformer;

class UserTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\User $product
     * @return array
     */
    public function transform(User $user)
    {

        return [
            'id' => (int) $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'bio' => $user->bio,
            'active' => $user->active,
            'isAdmin' => $user->hasRole(['admin']),
            'role' => $user->getRoleNames()->toArray()[0],
            'photo'=>$user->getFirstMediaUrl('user-photos'),

        ];
    }
}
