<?php

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class StreamStopped implements ShouldBroadcast
{
    use SerializesModels;

    public $streamId;
    public $userId;

    /**
     * Create a new event instance.
     *
     * @param string $streamId
     * @param int $userId
     */
    public function __construct(string $streamId, int $userId)
    {
        $this->streamId = $streamId;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('stream-channel');
    }
}
