<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Post;
use App\Notifications\LikeNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class LikesController extends Controller
{

    use Notifiable;

    public function like($id)
    {
        $like = new Likes();
        $like->user_id = Auth::user()->id;
        $like->post_id = $id;
        $like->save();

        // get the owner of the post
        $post = Post::find($id);
        $postOwner = $post->user;

        // send notification to the post owner
        $postOwner->notify(new LikeNotification(Auth::user(), $post));


        return redirect()->back();
    }


    public function unlike($id)
    {
        $like = Likes::where('post_id', $id)->where('user_id', Auth::user()->id)->first();
        $like->delete();
        return redirect()->back();
    }

    public function whoLiked($id)
    {
        $likes = Likes::where('post_id', $id)->get();
        return view('likes.whoLiked', compact('likes'));
    }
}
