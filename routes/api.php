<?php

use App\Http\Controllers\RESTAPIs\NotificationController;
use App\Http\Controllers\RESTAPIs\AuthRestApiController;
use App\Http\Controllers\RESTAPIs\CommentsRestApiController;
use App\Http\Controllers\RESTAPIs\FriendsRestApiController;
use App\Http\Controllers\RESTAPIs\LikesApiController;
use App\Http\Controllers\RESTAPIs\PageController;
use App\Http\Controllers\RESTAPIs\PagePostController;
use App\Http\Controllers\RESTAPIs\PostController;
use App\Http\Controllers\RESTAPIs\ProfileController;
use App\Http\Controllers\RESTAPIs\UpdateProfileController;
use App\Http\Controllers\StreamingController;
use Illuminate\Http\Request;
use Chatify\Http\Controllers\Api\MessagesController;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
});

// api version
Route::get('/version', function () {
    return response()->json(['version' => '1.0.0']);
});



Route::get('login/with/google', [AuthRestApiController::class, 'redirectToGoogle'])->name('login.with.google');
Route::get('login/with/google/callback', [AuthRestApiController::class, 'handleGoogleCallback']);

Route::get('login/with/facebook', [AuthRestApiController::class, 'redirectToFacebook'])->name('login.with.facebook');
Route::get('login/with/facebook/callback', [AuthRestApiController::class, 'handleFacebookCallback']);



//RESTAPIs with csrf token
Route::post('register', [AuthRestApiController::class, 'register'])->name('api.register');
Route::post('login', [AuthRestApiController::class, 'login'])->name('api.login');
Route::post('logout', [AuthRestApiController::class, 'logout'])->name('api.logout');



Route::middleware('auth:sanctum')->get('/protected', function (Request $request) {
    return response()->json(['message' => 'This route is protected.'], 200);
});

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);
Route::get('/posts/search/{query}', [PostController::class, 'search']);

//streaming


Route::post('/stream/start', [StreamingController::class, 'startStream']);
Route::post('/stream/stop', [StreamingController::class, 'stopStream']);

Route::get('/post/{id}/isLiked', [PostController::class, 'isLiked']);
Route::post('/post/{id}/like', [PostController::class, 'likePost']);
Route::delete('/post/{id}/unlike', [PostController::class, 'unlikePost']);


Route::get('/users/{id}', [ProfileController::class, 'show']);
Route::get('/postsByUserId/{id}', [ProfileController::class, 'postsByUserId']);
//userMedia
Route::get('/userMedia/{id}', [PostController::class, 'userMedia']);

//searchUsers
Route::get('/users/search', [AuthRestApiController::class, 'searchUsers']);



Route::get('/posts/{post_id}/comments', [CommentsRestApiController::class, 'index']);
Route::post('/posts/{post_id}/comments', [CommentsRestApiController::class, 'store']);
Route::delete('/comments/{id}', [CommentsRestApiController::class, 'destroy']);
Route::post('/comments/{id}/like', [CommentsRestApiController::class, 'like']);
Route::delete('/comments/{id}/unlike', [CommentsRestApiController::class, 'unlike']);
Route::post('/comments/{comment_id}/reply', [CommentsRestApiController::class, 'reply']);
Route::get('/comments/{id}/likesCount', [CommentsRestApiController::class, 'likesCount']);
Route::get('/comments/{id}/showReplies', [CommentsRestApiController::class, 'showReplies']);
//destroyReply
Route::delete('/replies/{id}', [CommentsRestApiController::class, 'destroyReply']);

Route::get('rest/notifications', [NotificationController::class, 'index']);
Route::post('rest/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
Route::post('rest/notifications/read', [NotificationController::class, 'markAllAsRead']);


Route::prefix('/likes')->group(function () {
    Route::post('/posts/{postId}/like', [LikesApiController::class, 'like']);
    Route::delete('/posts/{postId}/unlike', [LikesApiController::class, 'unlike']);
    Route::get('/whoLiked/{id}', [LikesApiController::class, 'whoLiked']);
    Route::get('/alreadyLiked/{id}', [LikesApiController::class, 'alreadyLiked']);
    Route::get('/likeCount/{id}', [LikesApiController::class, 'likeCount']);
});


//share
Route::post('/posts/{id}/share', [PostController::class, 'sharePost'])->name('posts.share');


Route::post('/friends/{id}/add', [FriendsRestApiController::class, 'addFriend']);
Route::post('/friends/{id}/accept', [FriendsRestApiController::class, 'acceptFriend']);
Route::post('/friends/{id}/remove', [FriendsRestApiController::class, 'removeFriend']);
Route::post('/friends/{id}/cancel', [FriendsRestApiController::class, 'cancelFriendRequest']);
Route::post('/friends/{id}/reject', [FriendsRestApiController::class, 'rejectFriendRequest']);
Route::get('/friend-requests', [FriendsRestApiController::class, 'showFriendRequests']);
Route::get('/sent-friend-requests', [FriendsRestApiController::class, 'showSentFriendRequests']);
Route::get('/friends', [FriendsRestApiController::class, 'showAllFriends']);
Route::get('/friends/{id}/checkFriendship', [FriendsRestApiController::class, 'checkFriendship']);
Route::get('/friends/{id}/checkFriendRequest', [FriendsRestApiController::class, 'checkFriendRequest']);
Route::get('/friends/{id}/checkFriendRequestReceived', [FriendsRestApiController::class, 'checkFriendRequestReceived']);
//searchFriends
Route::post('/friends/search/', [FriendsRestApiController::class, 'searchFriends']);


//new apis
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/update-profile', [UpdateProfileController::class, 'updateProfile']);
    Route::put('/update-email-and-mobile', [UpdateProfileController::class, 'updateEmailAndMobile']);
    Route::put('/update-password', [UpdateProfileController::class, 'updatePassword']);
    Route::put('/update-name-and-username', [UpdateProfileController::class, 'updateNameAndUsername']);
    Route::post('/update-avatar', [UpdateProfileController::class, 'updateAvatar']);
    Route::post('/update-cover', [UpdateProfileController::class, 'updateCover']);
    //search
    Route::post('/search-users', [UpdateProfileController::class, 'search']);

    //deactivate
    Route::post('/deactivate', [UpdateProfileController::class, 'deactivate']);
    Route::post('/reactivate', [UpdateProfileController::class, 'reactivate']);
});


Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
Route::get('/pages/{id}', [PageController::class, 'show'])->name('pages.show');
Route::put('/pages/{id}', [PageController::class, 'update'])->name('pages.update');
Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('pages.destroy');

//page posts

Route::get('/pages/{id}/posts', [PagePostController::class, 'index'])->name('pages.posts.index');
Route::post('/pages/{id}/posts', [PagePostController::class, 'store'])->name('pages.posts.store');
Route::get('/pages/{id}/posts/{post_id}', [PagePostController::class, 'show'])->name('pages.posts.show');
Route::put('/pages/{id}/posts/{post_id}', [PagePostController::class, 'update'])->name('pages.posts.update');
Route::delete('/pages/{id}/posts/{post_id}', [PagePostController::class, 'destroy'])->name('pages.posts.destroy');




Route::get('/unseenMessagesCount', [MessagesController::class, 'unseenCount']);
