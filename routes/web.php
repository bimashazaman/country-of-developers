<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostOfPageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StreamingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


// Auth::routes();

Auth::routes(['verify' => true]);

//loginPost
Route::post('/loginpost', [App\Http\Controllers\Auth\LoginController::class, 'loginPost'])->name('login.post');

Route::get('login/google', 'App\Http\Controllers\Auth\RegisterController@redirectToGoogle');
Route::get('login/google/callback', 'App\Http\Controllers\Auth\RegisterController@handleGoogleCallback');

Route::get('login/facebook', 'App\Http\Controllers\Auth\RegisterController@redirectToFacebook');
Route::get('login/facebook/callback', 'App\Http\Controllers\Auth\RegisterController@handleFacebookCallback');

Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);



Route::get('/cache-routes', function () {
    Artisan::call('optimize');
    return 'Routes cached successfully';
});


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache has been cleared';
});

//Clear route cache:
Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache has been cleared';
});

//Clear config cache:
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache has been cleared';
});

// Clear view cache:
Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});




//Google
Route::get('/login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);
//Facebook
Route::get('/login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);
//Github
Route::get('/login/github', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGithub'])->name('login.github');
Route::get('/login/github/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGithubCallback']);

// middleware
Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [PostController::class, 'index']);
    Route::get('/posts/all', [PostController::class, 'index'])->name('posts.all');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read/all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');


    //page controller
    Route::get('/pages', [PageController::class, 'index'])->name('page.index');
    Route::get('/pages/create', [PageController::class, 'create'])->name('page.create');
    Route::post('/pages', [PageController::class, 'store'])->name('page.store');
    Route::get('/pages/{id}', [PageController::class, 'show'])->name('page.show');
    Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('page.edit');
    Route::put('/pages/{id}', [PageController::class, 'update'])->name('page.update');
    Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('page.destroy');

    Route::post('/posts/{post}/report', [ReportController::class, 'report'])->name('posts.report');
    //create
    Route::get('/posts/report/create/{post}/', [ReportController::class, 'create'])->name('posts.report.create');


    //page posts

    Route::get('/pages/{id}/posts', [PostOfPageController::class, 'index'])->name('pagespost.index');
    Route::get('/pages/{id}/posts/create', [PostOfPageController::class, 'create'])->name('pagespost.create');
    Route::post('/pages/{id}/posts', [PostOfPageController::class, 'store'])->name('pagespost.store');
    Route::get('/pages/{id}/posts/{post_id}', [PostOfPageController::class, 'show'])->name('pagespost.show');
    Route::get('/pages/{id}/posts/{post_id}/edit', [PostOfPageController::class, 'edit'])->name('pagespost.edit');
    Route::put('/pages/{id}/posts/{post_id}', [PostOfPageController::class, 'update'])->name('pagespost.update');
    Route::delete('/pages/{id}/posts/{post_id}', [PostOfPageController::class, 'destroy'])->name('pagespost.destroy');
    Route::post('/pages/{id}/posts/{post_id}/like', [PostOfPageController::class, 'like'])->name('pagespost.like');
    Route::post('/pages/{id}/posts/{post_id}/unlike', [PostOfPageController::class, 'unlike'])->name('pagespost.unlike');
    Route::get('/pages/{id}/posts/{post_id}/liked', [PostOfPageController::class, 'whoLiked'])->name('pagespost.whoLiked');
    Route::post('/pages/{id}/posts/{post_id}/comments', [PostOfPageController::class, 'comment'])->name('pagespost.comment');
    Route::delete('/pages/{id}/posts/{post_id}/comments/{comment_id}', [PostOfPageController::class, 'deleteComment'])->name('pages.posts.deleteComment');


    //comments
    Route::get('/comments/{post_id}', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/comments/store/{post_id}', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    //update comment
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    //comments likes
    Route::post('/comment/like/{comment_id}', [App\Http\Controllers\CommentController::class, 'like'])->name('comments.like');
    Route::post('/comment/unlike/{comment_id}', [App\Http\Controllers\CommentController::class, 'unlike'])->name('comments.dislike');

    //likes
    Route::post('/like/{post_id}', [App\Http\Controllers\LikesController::class, 'like'])->name('posts.likes');
    Route::post('/unlike/{post_id}', [App\Http\Controllers\LikesController::class, 'unlike'])->name('posts.unlike');

    //profile
    Route::get('/profile/{id}', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/{id}/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profiles.edit');

    //update user
    Route::put('/user/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');



    Route::post('/add-friend/{id}', [FriendController::class, 'addFriend'])->name('add-friend');
    Route::post('/accept-friend/{id}', [FriendController::class, 'acceptFriend'])->name('accept-friend');
    Route::post('/remove-friend/{id}', [FriendController::class, 'removeFriend'])->name('remove-friend');


    Route::post('/cancel-friend-request/{id}', [FriendController::class, 'cancelFriendRequest'])->name('cancel-friend-request');
    Route::post('/reject-friend-request/{id}', [FriendController::class, 'rejectFriendRequest'])->name('reject-friend-request');
    Route::get('/friends', [FriendController::class, 'showFriends'])->name('friends');
    Route::get('/friend-requests', [FriendController::class, 'showFriendRequests'])->name('friend-requests');
    Route::get('/sent-friend-requests', [FriendController::class, 'showSentFriendRequests'])->name('sent-friend-requests');

    Route::get('/search-friends', [FriendController::class, 'searchFriends'])->name('search-friends');
    Route::get('/search-friend-requests', [FriendController::class, 'searchFriendRequests'])->name('search-friend-requests');
    Route::get('/search-sent-friend-requests', [FriendController::class, 'searchSentFriendRequests'])->name('search-sent-friend-requests');


    //who liked
    Route::get('/who-liked/{id}', [App\Http\Controllers\LikesController::class, 'whoLiked'])->name('who-liked');

    // Comments
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment_id}/reply', [CommentController::class, 'reply'])->name('comments.reply');
    Route::delete('/comments/reply/{id}', [CommentController::class, 'replyDestroy'])->name('comments.replyDestroy');
    Route::post('/comments/reply/{id}/like', [CommentController::class, 'replyLike'])->name('comments.replyLike');
    Route::delete('/comments/reply/{id}/unlike', [CommentController::class, 'replyUnlike'])->name('comments.replyUnlike');

    //Settings index/id and update
    Route::get('/settings/{id}', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/{id}', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');

    //deactivateAccount
    Route::post('/deactivateAccount/{id}', [SettingsController::class, 'deactivateAccount'])->name('settings.deactivate');
    //viewDeactivate
    Route::get('/deactivateView/{id}', [SettingsController::class, 'viewDeactivate'])->name('settings.viewDeactivate');


    //updateUserPassword
    Route::put('/user/password/{id}', [SettingsController::class, 'updateUserPassword'])->name('users.updatePassword');
    //viewPassword
    Route::get('/user/password/{id}', [SettingsController::class, 'viewPassword'])->name('users.viewPassword');

    //streaming index
    Route::get('streaming', [StreamingController::class, 'index'])->name('streaming.index');
    Route::get('streaming/create', [StreamingController::class, 'create'])->name('streaming.create');
});





Route::prefix('admin')->name('admin.')->group(function () {
    // Show the admin login form.
    Route::get('login', [AdminController::class, 'showLoginForm'])
        ->name('login');

    // Process the admin login request.
    Route::post('login', [AdminController::class, 'processLogin']);

    // Show the admin registration form.
    Route::get('register', [AdminController::class, 'showRegistrationForm'])
        ->name('register');

    // Process the admin registration request.
    Route::post('register', [AdminController::class, 'processRegistration']);

    // Log the admin out of the application.
    Route::post('logout', [AdminController::class, 'logout'])
        ->name('logout');


    //main dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    //posts
    Route::get('posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');


    //ussers
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});





Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
