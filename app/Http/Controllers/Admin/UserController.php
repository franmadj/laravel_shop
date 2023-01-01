<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{


    function index(){

        $users = new User;
        if ($search = request('search', '')) {
            $users = $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
            });
            //$users=$users->where('title', 'like', "%$search%")->orWhere('content', 'like', "%$search%");
        }
        if ($role = request('role', '')) {
            $users = $users->role($role);
        }
        if ($type = request('type', '')) {
            $users = $users->where('type', $type);
        }
        if ($category = request('category', '')) {
            $users = $users->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category);

            });
        }

        //dd($users->toSql());

        return responder()->success($users->get(), UserTransformer::class)->respond(200);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return responder()->success($user, UserTransformer::class)->respond(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        if ($user->update($validated)) {

            $files = request('files', []);
            if (!empty($files) && is_array($files)) {
                $user->clearMediaCollection();
                foreach ($files as $file) {
                    if (isset($file) && !empty($file) && $file->isValid()) {
                        $user
                            ->addMedia($file)
                            ->usingName('image')
                            ->toMediaCollection();
                    } 

                }
            }elseif (request('clearFiles')) {
                $user->clearMediaCollection();
            }


            $gallery = request('gallery', []);
            if (!empty($gallery) && is_array($gallery)) {
                $user->clearMediaCollection('gallery');
                foreach ($gallery as $image) {
                    if (isset($image) && !empty($image) && $image->isValid()) {
                        $user
                            ->addMedia($image)
                            ->usingName('gallery_image')
                            ->toMediaCollection('gallery');
                    } 

                }
            }elseif (request('clearGallery')) {
                $user->clearMediaCollection('gallery');
            }


            if ($request->has('categories') and is_array($request->categories)) {
                $user->categories()->detach();
                $user->categories()->attach(collect($request->categories));
            }
            return responder()->success()->respond(200);
        }
        return responder()->error()->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return responder()->success(User::all(), UserTransformer::class)->respond(200);
    }
}
