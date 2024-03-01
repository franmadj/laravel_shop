<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        try {
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

        } catch (Exception $e) {
            return responder()->error($e->getMessage())->respond();

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        if ($user = User::create($validated)) {
            $user->assignRole($validated['role']);
            $photo = request()->file('photo');
            if (isset($photo) && !empty($photo) && $photo->isValid()) {
                $user->addMedia($photo)
                    ->toMediaCollection('user-photos');
            }
            return responder()->success(['id' => $user->id])->respond(201);

        }

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
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        if ($user->update($validated)) {
            $user->syncRoles([$validated['role']]);
            $photo = request()->file('photo');
            if (isset($photo) && !empty($photo) && $photo->isValid()) {
                $user->addMedia($photo)
                    ->toMediaCollection('user-photos');
            } elseif (request('clearFiles')) {
                $user->clearMediaCollection('user-photos');
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
