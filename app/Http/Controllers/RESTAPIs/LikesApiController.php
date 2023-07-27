<?php

namespace App\Http\Controllers\RESTAPIs;

use App\Http\Controllers\Controller;
use App\Models\Likes;
use App\Models\Post;
use App\Notifications\LikeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class LikesApiController extends Controller
{
    use Notifiable;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function like(Request $request, $postId)
    {
        $userId = auth()->user()->id;

        $like = Likes::where('user_id', $userId)->where('post_id', $postId)->first();
        if ($like) {
            return response()->json(['message' => 'You have already liked this post'], 400);
        } else {
            $like = new Likes;
            $like->user_id = $userId;
            $like->post_id = $postId;
            $like->save();

            $post = Post::find($postId);
            $postOwner = $post->user;

            // send notification to the post owner
            $postOwner->notify(new LikeNotification(Auth::user(), $post));
        }

        return response()->json($like, 201);
    }

    public function unlike(Request $request, $postId)
    {
        $userId = auth()->user()->id;

        $like = Likes::where('user_id', $userId)->where('post_id', $postId)->first();
        if (!$like) {
            return response()->json(['message' => 'You have not liked this post yet'], 400);
        }

        $like->delete();

        return response()->json(['message' => 'Successfully unliked the post'], 200);
    }

    public function whoLiked($id)
    {
        $likes = Likes::where('post_id', $id)->with('user')->get();

        return Response::json([
            'data' => $likes,

        ], 200);
    }

    //already liked
    public function alreadyLiked($id)
    {
        $user = auth()->user();
        $like = Likes::where('user_id', $user->id)
            ->where('post_id', $id)
            ->first();
        if ($like) {
            return Response::json([
                'data' => $like
            ], 200);
        } else
            return Response::json([
                'error' => 'Post not found.'
            ], 400);
    }

    public function likeCount($id)
    {
        $likes = Likes::where('post_id', $id)->count();

        return Response::json([
            'data' => $likes
        ], 200);
    }
}
