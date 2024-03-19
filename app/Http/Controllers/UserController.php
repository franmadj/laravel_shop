<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;

class UserController extends Controller
{

    public function me()
    {
        try {
            return responder()->success(auth()->user(), UserTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

}
