<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //code...
            return Post::orderBy('id', 'desc')->with('user')->get();
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
                    'user_id' => ['required'],
                    'title' => ['required'],
                    'content' => ['required'],
                ]
            );

            return Post::create($validated);
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
            $post = Post::find($id);
            if ($post) {
                return $post;
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
                    'title' => ['required'],
                    'content' => ['required'],
                ]
            );

            $post = Post::find($id);
            if ($post) {
                $post->update($validated);
            }

            return $post;
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
            $post = Post::find($id);
            if ($post) {
                $post->delete();
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
