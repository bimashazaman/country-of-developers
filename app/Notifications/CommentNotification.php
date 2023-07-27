<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;


    protected $commenter;
    protected $post;
    /**
     * Create a new notification instance.
     */
    public function __construct(User $commenter, Post $post)
    {
        $this->commenter = $commenter;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    public function toArray($notifiable)
    {
        return [
            'commenter_id' => $this->commenter->id,
            'commenter_name' => $this->commenter->name,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'user_id' => $this->post->user->id,
            'user_avatar' => $this->commenter->avatar,
            'user_name' =>  $this->commenter->name,
            'profile_url' => url('/profile' . $this->commenter->id),
            'message' => 'You have a new comment on ' .  $this->post->caption,
        ];
    }
}
