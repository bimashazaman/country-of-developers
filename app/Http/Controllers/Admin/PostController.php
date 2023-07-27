<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $posts = Post::latest()->paginate(60);

        return view('admin.posts.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('admin.posts.view', compact('post'));
    }


    public function destroy($id)
    {
        $post = Post::find($id);
        // Delete media files
        $media = explode(',', $post->media);
        foreach ($media as $file) {
            $filePath = public_path('uploads/' . $file);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }
        // Delete post
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        Post::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['success' => "Posts Deleted successfully."]);
    }

    //search
    public function search(Request $request)
    {
        $search = $request->get('search');
        $posts = Post::where('caption', 'like', '%' . $search . '%')->paginate(60);
        return view('admin.posts.index', compact('posts'));
    }
}
