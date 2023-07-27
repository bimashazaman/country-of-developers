<?php



namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostOfPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostOfPageController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->with(['page', 'user'])->get();
        return view('pages.index', compact('posts'));
    }

    // page
    public function indexPage(
        Request $request
    ) {
        $posts = Post::where('page_id', $request->page_id)->latest()->with(['page', 'user'])->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        // Show the form to create a new post
        return view('posts.create');
    }

    public function store(Request $request, $id)
    {
        // Validate and store the post
        $validatedData = $request->validate([
            'caption' => 'required',
            'media' => 'nullable|file',
            'status' => 'nullable',
        ]);

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
        }

        $post = new Post();
        $post->caption = $validatedData['caption'];
        $post->media = isset($filename) ? $filename : null;
        $post->status = 'active';
        $post->page_id = $id;
        $post->user_id = Auth::id();
        $post->save();

        return redirect()->back()->with('success', 'Post created successfully');
    }



    public function show($id)
    {
        // Show a single resource
        $post = Post::latest()->with(['page', 'user'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        // Show a view to edit an existing resource
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        // Validate and update the resource
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

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }


    public function destroy($id)
    {
        // Delete the resource
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
