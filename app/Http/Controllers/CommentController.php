<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index($post_id)
    {

        $comments = Comment::latest()->where('post_id', $post_id)->latest()->paginate(60);
        $user = auth()->user();
        $friends = $user->friends;
        $pages = $user->pages;

        $post = Post::find($post_id);
        return view('comments.index', compact('comments', 'post', 'user', 'pages', 'friends'));
    }

    public function create($post_id)
    {
        $comments = Comment::latest()->where('post_id', $post_id)->latest()->paginate(60);

        $post = Post::find($post_id);

        return view('comments.index', compact('comments', 'post'));
    }

    public function store(Request $request, $post_id)
    {
        $request->validate([
            'comment' => 'required',
            'media.*' => 'nullable|file|max:10000|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->post_id = $post_id;
        $comment->user_id = auth()->user()->id;

        $uploadsPath = public_path('comments');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }

        if ($request->hasFile('media')) {
            $media = [];
            foreach ($request->file('media') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($uploadsPath, $fileName);
                $media[] = $fileName;
            }
            $comment->media = implode(',', $media);
        }

        $comment->save();


        //notify the post owner
        $postOwner = $comment->post->user;
        $postOwner->notify(new CommentNotification(Auth::user(), $comment->post));

        return redirect()->back();
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect()->back();
    }

    //update comment
    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = Comment::find($id);
        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->back();
    }

    public function like($id)
    {
        $comment = Comment::find($id);
        $comment->likes()->create([
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }

    public function unlike($id)
    {
        $comment = Comment::find($id);
        $comment->likes()->where('user_id', auth()->user()->id)->delete();

        return redirect()->back();
    }

    public function reply(Request $request, $comment_id)
    {
        $request->validate([
            'reply' => 'required',
        ]);

        $comment = Comment::find($comment_id);
        $comment->replies()->create([
            'reply' => $request->reply,
            'user_id' => auth()->user()->id,
            'post_id' => $comment->post_id,
        ]);

        return redirect()->back();
    }

    public function replyDestroy($id)
    {
        $reply = Comment::find($id);
        $reply->delete();

        return redirect()->back();
    }

    public function replyLike($id)
    {
        $reply = Comment::find($id);
        $reply->likes()->create([
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }

    public function replyUnlike($id)
    {
        $reply = Comment::find($id);
        $reply->likes()->where('user_id', auth()->user()->id)->delete();

        return redirect()->back();
    }
}
