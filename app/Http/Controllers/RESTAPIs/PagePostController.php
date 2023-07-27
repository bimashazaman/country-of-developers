<?php

namespace App\Http\Controllers\RESTAPIs;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagePostController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }


    public function index($page_id)
    {
        $posts = Post::latest()
            ->where('page_id', $page_id)
            ->with('user')
            ->with('likes')
            ->with('comment')
            ->with('page')
            ->with(['sharedPost' => function ($query) {
                $query->with('user');
            }])
            ->paginate(60);
        return response()->json($posts, 200);
    }

    public function indexPage(Request $request)
    {
        $posts = Post::where('page_id', $request->page_id)->get();
        return response()->json($posts, 200);
    }

    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'caption' => 'required',
            'media' => 'nullable|file',
            'status' => 'nullable',
        ]);

        $post = new Post();
        $post->caption = $validatedData['caption'];
        $post->media = isset($filename) ? $filename : null;
        $post->status = 'active';
        $post->page_id = $id;
        $post->user_id = Auth::id();

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

        return response()->json($post, 201); // 201 Created
    }

    public function show($id)
    {
        $post = Post::latest()->with(['page', 'user'])->findOrFail($id);
        return response()->json($post, 200);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'caption' => 'required',
            'media' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $post = Post::findOrFail($id);
        $post->caption = $validatedData['caption'];
        $post->media = $validatedData['media'];
        $post->status = $validatedData['status'];
        $post->save();

        return response()->json($post, 200); // 200 OK
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
