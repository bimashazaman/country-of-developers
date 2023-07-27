
<?php


namespace App\Listeners;

use App\Events\StreamStarted;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BroadcastStreamStarted implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  StreamStarted  $event
     * @return void
     */
    public function handle(StreamStarted $event)
    {
        // Broadcast the new stream event using Laravel WebSockets
        broadcast(new StreamStarted($event->streamId, $event->postId, $event->userId));

        // Update the post with the stream ID
        $post = Post::find($event->postId);

        if ($post) {
            $post->media = $event->streamId;
            $post->save();
        }
    }
}
