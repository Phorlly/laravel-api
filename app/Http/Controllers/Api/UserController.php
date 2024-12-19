<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //code...
            return User::orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            //throw $th;
            return hasError(
                message: "Invalid",
                errors: $th->getMessage(),
                code: 500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //code...
            $validated = $request->validate(
                [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:6'],
                    'type' => ['required', 'string'],
                ]
            );

            return User::create($validated);
        } catch (\Throwable $th) {
            //throw $th;
            return hasError(
                message: "Invalid",
                errors: $th->getMessage(),
                code: 500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            //code...
            $user = User::find($id);
            if ($user) {
                return $user;
            }

            return [];
        } catch (\Throwable $th) {
            //throw $th;
            return hasError(
                message: "Invalid",
                errors: $th->getMessage(),
                code: 500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            //code...
            $validated = $request->validate(
                [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
                    'password' => ['nullable', 'string', 'min:6'],
                    'type' => ['required', 'string'],
                ]
            );
            $user = User::find($id);
            if ($user) {
                $user->update($validated);
            }

            return $user;
        } catch (\Throwable $th) {
            //throw $th;
            return hasError(
                message: "Invalid",
                errors: $th->getMessage(),
                code: 500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //code...
            $user = User::findOrfail($id);
            if ($user) {
                $user->delete();
            }

            return [];
        } catch (\Throwable $th) {
            //throw $th;
            return hasError(
                message: "Invalid",
                errors: $th->getMessage(),
                code: 500
            );
        }
    }
}
