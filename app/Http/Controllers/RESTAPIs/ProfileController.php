<?php

namespace App\Http\Controllers\RESTAPIs;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProfileController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $posts = $user->posts()
            ->with(['sharedPost' => function ($query) {
                $query->with('user');
            }])
            ->latest()
            ->paginate(90);

        // Get the user's first 6 friends
        $friends = $user->friends()->get();

        return response()->json(['user' => $user, 'posts' => $posts, 'friends' => $friends]);
    }




    public function postsByUserId($id)
    {
        $user = User::find($id);
        $posts = $user->posts()->with('likes')->with('comment')
            ->with('user')
            ->with(['sharedPost' => function ($query) {
                $query->with('user');
            }])->get();

        return response()->json(['posts' => $posts], 200);
    }
}
