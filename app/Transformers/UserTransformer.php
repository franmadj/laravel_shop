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
            'active' => $user->active,
            'isAdmin' => $user->hasRole(['admin']),
            'roles' => implode(' | ',$user->getRoleNames()->toArray()),

        ];
    }
}
