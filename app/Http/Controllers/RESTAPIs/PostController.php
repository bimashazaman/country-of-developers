<?php


namespace App\Http\Controllers\RESTAPIs;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Likes;
use App\Models\Post;
use App\Models\User;


class PostController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }

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

        return response()->json(
            [
                'success' => true,
                'message' => 'Posts fetched successfully.',
                'data' => $posts
            ],
            200
        );
    }

    public function create()
    {
        // return a JSON response with 405 status code to indicate method not allowed
        return response()->json([
            'success' => false,
            'message' => 'Method not allowed'
        ], 405);
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
        return response()->json([
            'success' => true,
            'message' => 'Post created successfully.',
            'data' => $post
        ], 201);
    }

    public function show($id)
    {
        $post = Post::find($id);
        if ($post) {
            return response()->json([
                'success' => true,
                'data' => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string',
            'media' => 'nullable|file',
            'status' => 'nullable|string',
        ]);
        $post = Post::find($id);
        if ($post) {
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


            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully.',
                'data' => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post) {
            // Delete media files
            $media = explode(',', $post->media);
            foreach ($media as $file) {
                $filePath = public_path('uploads/' . $file);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
            $post->delete();
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully.'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $posts = Post::where('caption', 'like', '%' . $search . '%')->paginate(60);
        return response()->json($posts);
    }



    public function sharePost(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string',
        ]);

        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $sharedPost = new Post([
            'caption' => $request->get('caption', $post->caption),
            'status' => $post->status,
            'user_id' => auth()->user()->id,
            // 'shared_post_id' => $post->id,
        ]);

        $uploadsPath = public_path('uploads');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }

        if ($post->media) {
            $media = [];
            foreach (explode(',', $post->media) as $file) {
                $fileName = time() . '_' . $file;
                $filePath = public_path('uploads/' . $file);
                if (file_exists($filePath)) {
                    copy($filePath, $uploadsPath . '/' . $fileName);
                }
                $media[] = $fileName;
            }
            $sharedPost->media = implode(',', $media);
        }


        $sharedPost->save();


        return response()->json([
            'success' => true,
            'message' => 'Post shared successfully.',
            'data' => $sharedPost
        ], 201);
    }


    public function likePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $like = Likes::where([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
        ])->first();

        if ($like) {
            return response()->json([
                'success' => false,
                'message' => 'You have already liked this post.',
            ], 409);
        } else {
            $like = Likes::create([
                'user_id' => auth()->user()->id,
                'post_id' => $post->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post liked successfully.',
                'data' => $like
            ], 201);
        }
    }


    public function unlikePost(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $like = Likes::where([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
        ])->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post unliked successfully.'
        ], 200);
    }


    //isliked
    public function isLiked($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $like = Likes::where([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
        ])->first();

        if ($like) {
            return response()->json([
                'success' => true,
                'message' => 'Post is liked.',
                'data' => $like
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post is not liked.'
            ], 404);
        }
    }

    //only media of a user
    public function userMedia($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $posts = Post::where('user_id', $user->id)->where('media', '!=', null)->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ], 200);
    }
}
