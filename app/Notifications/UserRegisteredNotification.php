<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserRegisteredNotification extends Notification
{
    use Queueable;


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toArray($notifiable)
    {
        return [
            'message' => 'Welcome to Poker Social!',
            'user_id' => $notifiable->id,
            'user_name' => $notifiable->name,
            'user_email' => $notifiable->email,
            'user_avatar' => $notifiable->avatar,
            'profile_url' => url('/profile/' . $notifiable->id),
            'user_username' => $notifiable->username,
        ];
    }
}
