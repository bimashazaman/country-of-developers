<?php

namespace App\Http\Controllers\RESTAPIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Get the current user
        $user = Auth::user();

        // Get all of the user's unread notifications
        $notifications = $user->unreadNotifications;

        // Return notifications as JSON
        return response()->json(['notifications' => $notifications]);
    }

    public function markAsRead(Request $request)
    {
        // Mark a specific notification as read
        $notification = Auth::user()->notifications->where('id', $request->id)->first();
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marked as read']);
        }
        return response()->json(['message' => 'Notification not found'], 404);
    }

    public function markAllAsRead()
    {
        // Mark all notifications as read
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(['message' => 'All notifications marked as read']);
    }
}
