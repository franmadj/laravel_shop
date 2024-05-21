<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    /**
     * Returns user data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me():JsonResponse
    {
        try {
            return responder()->success(auth()->user(), UserTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

}
