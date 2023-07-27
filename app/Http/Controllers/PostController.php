<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::whereHas('user', function ($query) {
            $query->where('status', '!=', 'inactive');
        })
            ->latest()
            ->with('user')
            ->with('likes')
            ->with('comment')
            ->with(['sharedPost' => function ($query) {
                $query->with('user');
            }])
            ->paginate(60);

        $user = auth()->user();
        $friends = $user->friends;
        $pages = $user->pages;
        // if the user is logged in, we will pass the posts to the view
        if (
            auth()->check()
            && auth()->user()->role == 'user'
        ) {
            return view('posts.index', compact('posts', 'friends', 'pages', 'user'));
        } else {
            return view('auth.login');
        }
    }

    public function create()
    {
        $user = auth()->user();
        $friends = $user->friends;
        $pages = $user->pages;
        return view('posts.create', compact('friends', 'user', 'pages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'nullable|string',
            'media.*' => 'nullable|file|max:10000',
            'status' => 'nullable|string',
        ]);
        $post = new Post([
            'caption' => $request->get('caption'),
            'status' => $request->get('status', 'active'),
            'user_id' => auth()->user()->id,
        ]);
        $uploadsPath = public_path('uploads');
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
            $post->media = implode(',', $media);
        }
        $post->save();
        return redirect()->route('posts.all')->with('success', 'Post created successfully.');
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string',
            'media.*' => 'nullable|file',
            'status' => 'nullable|string',
        ]);
        $post = Post::find($id);
        $post->caption = $request->get('caption');
        $post->status = $request->get('status', 'active');
        $uploadsPath = public_path('uploads');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }

        if ($request->hasFile('media')) {
            // Delete old media files
            $media = explode(',', $post->media);
            foreach ($media as $file) {
                $filePath = public_path('uploads/' . $file);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
            // Upload new media files
            $media = [];
            foreach ($request->file('media') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($uploadsPath, $fileName);
                $media[] = $fileName;
            }
            $post->media = implode(',', $media);
        }
        $post->save();
        return redirect()->route('posts.all')->with('success', 'Post updated successfully.');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
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

        return redirect()->route('posts.all')->with('success', 'Post deleted successfully.');
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
        return view('posts.index', compact('posts'));
    }
}
