<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LikeNotification extends Notification
{
    use Queueable;

    protected $liker;
    protected $post;

    public function __construct(User $liker, Post $post)
    {
        $this->liker = $liker;
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'liker_id' => $this->liker->id,
            'liker_name' => $this->liker->name,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'user_id' => $this->post->user->id,
            'user_avatar' => $this->liker->avatar,
            'user_name' => $this->liker->name,
            'profile_url' => url('/profile/' . $this->liker->id),
            'message' => 'You have a new like on ' .  $this->post->caption,
        ];
    }
}
