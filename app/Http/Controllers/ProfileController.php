<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;


class ProfileController extends Controller
{
    public function index($user_id)
    {
        $user = User::find($user_id);
        $posts = Post::where('user_id', $user_id)->with('user')->latest()->paginate(70);
        $pages = $user->pages;


        $friends = $user->friends;

        $firstSixFriends = $friends->take(6);

        return view('profile.index', compact('user', 'posts', 'friends', 'pages', 'firstSixFriends'));
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);
        $pages = $user->pages;
        return view('profile.edit', compact('user', 'pages'));
    }
}
