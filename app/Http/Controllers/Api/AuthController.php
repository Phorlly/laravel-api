<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            //code...
            if (!Auth::attempt($request->only('email', 'password'))) {
                return hasError('Email or Password is incorrect !!!');
            }

            return response(new UserResource(Auth::user()));
        } catch (\Throwable $th) {
            //throw $th;
            return hasError(
                message: "Invalid",
                errors: $th->getMessage(),
                code: 500
            );
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            //code...
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            //assign role to user
            $user_role = Role::where(['name' => 'guest'])->first();
            if ($user_role) {
                $user->assignRole($user_role);
            }

            return response(new UserResource($user));
        } catch (\Throwable $th) {
            //throw $th;
            return hasError(
                message: "Invalid",
                errors: $th->getMessage(),
                code: 500
            );
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.',
        ];
    }
}
