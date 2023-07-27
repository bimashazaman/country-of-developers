<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Pusher\Pusher;

class StreamingController extends Controller
{



    public function index()
    {
        return view('streaming.index');
    }


    //create
    public function create()
    {
        return view('streaming.create');
    }
    public function startStream(Request $request)
    {
        $streamId = uniqid();

        // Create a new post
        $post = new Post();
        $post->caption = 'Live Stream';
        $post->media = $streamId; // Store the stream ID as the media for the post
        $post->user_id = $request->user()->id;
        $post->save();

        // Broadcast the new stream event using Pusher
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);

        $pusher->trigger('my-channel', 'my-event', [
            'streamId' => $streamId,
            'postId' => $post->id,
            'userId' => $request->user()->id,
        ]);

        return response()->json(['streamId' => $streamId, 'postId' => $post->id, 'streamStarted' => true]);
    }

    public function stopStream(Request $request)
    {
        $post = Post::find($request->postId);

        // Broadcast the stream ended event using Pusher
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);

        $pusher->trigger('my-channel', 'my-event', [
            'streamId' => $post->media,
            'postId' => $post->id,
            'userId' => $request->user()->id,
        ]);

        return response()->json(['streamEnded' => true]);
    }
}
