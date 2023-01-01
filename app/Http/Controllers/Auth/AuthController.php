<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class
AuthController extends Controller
{


    public function password_email(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status === Password::RESET_LINK_SENT){
            return responder()->success(['status' => __($status)])->respond(201);
        }
        return responder()->error()->respond(400, ['email' => __($status)]);

        // return $status === Password::RESET_LINK_SENT
        // ? back()->with(['status' => __($status)])
        // : back()->withErrors(['email' => __($status)]);
    }

    public function password_update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );


        if($status === Password::PASSWORD_RESET){
            return responder()->success(['status' => __($status)])->respond(201);
        }
        return responder()->error()->data(['message' => __($status),'code' => 1001])->respond();



        // return $status === Password::PASSWORD_RESET
        // ? redirect()->route('login')->with('status', __($status))
        // : back()->withErrors(['email' => [__($status)]]);
    }

    public function register(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Unauthorised']);
        }

        $requestData['password'] = Hash::make($requestData['password']);

        if ($user = User::create($requestData)) {
            $user->assignRole('user');

        }

        return response([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => auth()->user(),
        ]);
    }

    public function login(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Invalid Data']);
        }

        if (!auth()->attempt($requestData)) {
            $response = [
                'success' => false,
                'message' => 'Credentials are incorrect',
            ];
        } else {
            $response = [
                'success' => true,
                'message' => 'User login successfully',
                'user' => auth()->user(),
            ];
        }

        return response($response);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user], 200);
    }

    public function logout(Request $request)
    {

        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
        } catch (\Illuminate\Database\QueryException$ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        return response($response, 200);
    }
}
