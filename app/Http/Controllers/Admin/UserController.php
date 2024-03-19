<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Carbon\Carbon;
use Exception;

class UserController extends Controller
{

    public function adminStatistics()
    {
        try {
            $usersCount = User::with('roles')->get()->filter(
                fn($user) => $user->roles->where('name', 'user')->toArray()
            );

            $newUsersCount = $usersCount->filter(
                fn($user) => $user->whereId($user->id)->where('created_at', '>', Carbon::now()->subWeek())->count()
            );

            $data = [
                'usersCount' => $usersCount->count(),
                'newUsersCount' => $newUsersCount->count(),
            ];
            return responder()->success($data)->respond(200);
        } catch (Exception $e) {
            return responder()->error($e->getMessage())->respond();

        }

    }

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
        try {
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
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editAccount()
    {
        try {
            return responder()->success(Auth()->user(), UserTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAccount(UpdateUserRequest $request, User $user)
    {
        try {

            $currentUser = auth()->user();

            if ($currentUser == $user) {
                return new Exception('unauthorized', 403);
            }

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
            return responder()->error('Unable to update account')->respond();
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
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
        try {
            return responder()->success($user, UserTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
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
        try {
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
            return responder()->error('Unable to update user')->respond();
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return responder()->success(User::all(), UserTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }
}
