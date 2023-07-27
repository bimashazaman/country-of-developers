<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Get the current user
        $user = Auth::user();
        $friends = $user->friends;
        $pages = $user->pages;

        // Get all of the user's unread notifications
        $notifications = $user->unreadNotifications;

        $pages = $user->pages;

        // Return a view with the notifications
        return view('notifications.index', compact('notifications', 'pages', 'friends', 'user', 'pages'));
    }

    public function markAsRead(Request $request)
    {
        // Mark a specific notification as read
        Auth::user()->notifications->where('id', $request->id)->markAsRead();

        // Redirect back to the notifications page
        return redirect()->back();
    }

    public function markAllAsRead()
    {
        // Mark all notifications as read
        Auth::user()->unreadNotifications->markAsRead();

        // Redirect back to the notifications page
        return redirect()->back();
    }
}
