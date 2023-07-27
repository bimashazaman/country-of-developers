<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class StreamStarted implements ShouldBroadcast
{
    use SerializesModels;

    public $streamId;
    public $postId;
    public $userId;

    /**
     * Create a new event instance.
     *
     * @param string $streamId
     * @param int $postId
     * @param int $userId
     */
    public function __construct(string $streamId, int $postId, int $userId)
    {
        $this->streamId = $streamId;
        $this->postId = $postId;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['my-channel'];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
