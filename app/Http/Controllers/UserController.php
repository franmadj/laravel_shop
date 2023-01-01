<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserTransformer;

class UserController extends Controller
{

    function me(){
        return responder()->success(auth()->user(), UserTransformer::class)->respond(201);
    }



    
}
