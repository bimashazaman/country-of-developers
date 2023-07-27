<?php

namespace App\Http\Controllers\RESTAPIs;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CommentsRestApiController extends Controller
{

    use Notifiable;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // Fetch comments for a post
    public function index($post_id)
    {
        $comments = Comment::with('user')->with('replies')->latest()->where('post_id', $post_id)->get();

        return response()->json($comments);
    }


    // Store a comment
    public function store(Request $request, $post_id)
    {
        $request->validate([
            'comment' => 'required',
            'media.*' => 'nullable|file|max:10000|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->post_id = $post_id;
        $comment->user_id = Auth::user()->id;

        if ($request->hasFile('media')) {
            $media = [];
            foreach ($request->file('media') as $file) {
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/comments', $file, $fileName);
                $media[] = $fileName;
            }
            $comment->media = implode(',', $media);
        }

        $comment->save();

        //notify the post owner
        $postOwner = $comment->post->user;
        $postOwner->notify(new CommentNotification(Auth::user(), $comment->post));



        return response()->json([
            'message' => 'Comment created successfully',
            'comment' => $comment
        ]);
    }

    // Delete a comment
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ]);
    }

    // Like a comment
    public function like($id)
    {
        $comment = Comment::find($id);
        $comment->likes()->create([
            'user_id' => Auth::user()->id,
        ]);

        return response()->json([
            'message' => 'Comment liked successfully'
        ]);
    }

    //likes count
    public function likesCount($id)
    {
        $comment = Comment::find($id);
        $likes = $comment->likes()->count();

        return response()->json([
            'likes' => $likes
        ]);
    }

    // show replies
    public function showReplies($comment_id)
    {
        $comment = Comment::find($comment_id);
        $replies = $comment->replies()->with('user')->latest()->get();

        return response()->json($replies);
    }



    // Unlike a comment
    public function unlike($id)
    {
        $comment = Comment::find($id);
        $comment->likes()->where('user_id', Auth::user()->id)->delete();

        return response()->json([
            'message' => 'Comment unliked successfully'
        ]);
    }

    // Reply to a comment
    public function reply(Request $request, $comment_id)
    {
        $request->validate([
            'reply' => 'required',
        ]);

        $comment = Comment::find($comment_id);
        $reply = $comment->replies()->create([
            'reply' => $request->reply,
            'user_id' => Auth::user()->id,
            'post_id' => $comment->post_id,
        ]);

        return response()->json([
            'message' => 'Reply created successfully',
            'reply' => $reply
        ]);
    }



    public function destroyReply($id)
    {
        $reply = CommentReply::find($id);

        // Check if reply exists
        if (!$reply) {
            return response()->json([
                'message' => 'Reply not found',
            ], 404);
        }

        // Check if the authenticated user is the owner of the reply
        if (Auth::user()->id !== $reply->user_id) {
            return response()->json([
                'message' => 'Unauthorized action',
            ], 403);
        }

        // Delete the reply
        $reply->delete();

        return response()->json([
            'message' => 'Reply deleted successfully'
        ]);
    }
}
