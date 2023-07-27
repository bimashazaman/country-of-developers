<?php

namespace App\Http\Controllers\RESTAPIs;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use App\Notifications\FriendRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

class FriendsRestApiController extends Controller
{
    use Notifiable;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function addFriend($id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);

        // Check if friend request is already sent
        if ($user->sentFriendRequests->contains($friend)) {
            return response()->json(['error' => 'Friend request already sent.'], 400);
        }

        // Check if friend request is already received
        if ($user->receivedFriendRequests->contains($friend)) {
            return response()->json(['error' => 'Friend request already received.'], 400);
        }

        // Create a new friend request
        $friendRequest = new FriendRequest();
        $friendRequest->user_id = $user->id;
        $friendRequest->friend_id = $friend->id;
        $friendRequest->save();

        $friend->notify(new FriendRequestNotification($friend));

        return response()->json(['message' => 'Friend request sent successfully.'], 200);
    }

    public function acceptFriend(Request $request, $id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);

        // Check if friend request is received
        if (!$user->receivedFriendRequests->contains($friend)) {
            return response()->json(['error' => 'No friend request received from this user.'], 404);
        }

        // Create a new friend
        $friendship1 = new Friend();
        $friendship1->user_id = $user->id;
        $friendship1->friend_id = $friend->id;
        $friendship1->save();

        $friendship2 = new Friend();
        $friendship2->user_id = $friend->id;
        $friendship2->friend_id = $user->id;
        $friendship2->save();

        // Delete the friend request
        FriendRequest::where('user_id', $friend->id)
            ->where('friend_id', $user->id)
            ->delete();

        return response()->json(['message' => 'Friend request accepted successfully.'], 200);
    }

    public function removeFriend(Request $request, $id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);

        // Check if they are already friends
        if (!$user->friends->contains($friend)) {
            return response()->json(['error' => 'They are not your friend.'], 400);
        }

        // Delete the friendship records
        Friend::where('user_id', $user->id)
            ->where('friend_id', $friend->id)
            ->delete();

        Friend::where('user_id', $friend->id)
            ->where('friend_id', $user->id)
            ->delete();

        return response()->json(['message' => 'Friend removed successfully.'], 200);
    }

    public function cancelFriendRequest(Request $request, $id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);

        // Check if friend request is already sent
        if (!$user->sentFriendRequests->contains($friend)) {
            return response()->json(['error' => 'No friend request sent to this user.'], 404);
        }

        // Delete the friend request
        FriendRequest::where('user_id', $user->id)
            ->where('friend_id', $friend->id)
            ->delete();

        return response()->json(['message'
        => 'You have successfully removed your friend request.'], 200);
    }


    public function rejectFriendRequest(Request $request, $id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);

        // Check if friend request is already received
        if (!$user->receivedFriendRequests->contains($friend)) {
            return response()->json([
                'error' => 'No friend request received from this user.'
            ], 400);
        }

        // Delete the friend request
        FriendRequest::where('user_id', $friend->id)
            ->where('friend_id', $user->id)
            ->delete();

        return response()->json([
            'message' => 'Friend request rejected successfully.'
        ], 200);
    }

    public function showFriendRequests()
    {
        $user = auth()->user();
        $friendRequests = $user->receivedFriendRequests;
        return response()->json([
            'data' => $friendRequests,
            'message' => 'Your friend requests.'
        ], 200);
    }

    public function showSentFriendRequests()
    {
        $user = Auth::user();
        $sentFriendRequests = $user->sentFriendRequests;
        return response()->json([
            'data' => $sentFriendRequests,
        ], 200);
    }


    public function showAllFriends()
    {
        $user = auth()->user();
        $friends = $user->friends;

        return response()->json([
            'data' => $friends,
            'message' => 'Your friends.'
        ], 200);
    }

    //already friends or not
    public function checkFriendship($id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);

        if ($user->friends->contains($friend)) {
            return response()->json([
                'data' => true,
                'message' => 'They are your friend.'
            ], 200);
        } else {
            return response()->json([
                'data' => false,
                'message' => 'They are not your friend.'
            ], 200);
        }
    }

    public function checkFriendRequest($id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);

        if ($user->sentFriendRequests->contains($friend)) {
            return response()->json([
                'data' => true,
                'message' => 'Friend request already sent.'
            ], 200);
        } else {
            return response()->json([
                'data' => false,
                'message' => 'Friend request not sent.'
            ], 200);
        }
    }

    public function checkFriendRequestReceived($id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);

        if ($user->receivedFriendRequests->contains($friend)) {
            return response()->json([
                'data' => true,
                'message' => 'Friend request already received.'
            ], 200);
        } else {
            return response()->json([
                'data' => false,
                'message' => 'Friend request not received.'
            ], 200);
        }
    }

    //search friends
    public function searchFriends($name)
    {
        $user = auth()->user();
        $friends = $user->friends()->where('name', 'LIKE', '%' . $name . '%')->get();

        return response()->json([
            'data' => $friends,
            'message' => 'Your friends.'
        ], 200);
    }
}
