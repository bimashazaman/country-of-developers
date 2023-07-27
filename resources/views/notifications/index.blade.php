@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="sidebar">
                    <!-- Place your sidebar content here -->
                    @include('partials.sidebar')
                </div>
            </div>
            <div class="col mx-lg-5 mx-auto"
                style="max-width: 85%; background-color: #1B2235; border-radius: 10px; padding: 20px; color: #FFFFFF;">
                <br>
                <br>

                <h1 style="color: #3ABEFE; text-align: center; font-size: 30px;  font-family: 'Russo One', sans-serif;">
                    <i class="fas fa-bell"></i> Notifications
                </h1>
                <br>
                @foreach ($notifications as $notification)
                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}"
                        style="margin-bottom: 20px;">
                        @csrf
                        <div class="notification"
                            style="padding: 10px; background-color: #2D3748; border-radius: 30px; align-items: center; display: flex; justify-content: space-between; color: #FFFFFF;">
                            <p style="display: flex; align-items: center;">
                                <img src=@if ($notification->data['user_avatar']) {{ asset('avatars/' . $notification->data['user_avatar']) }}
                                            @else "https://ui-avatars.com/api/?name={{ $notification->data['user_name'] }}&&background=0D8ABC&color=fff" @endif
                                    class="rounded-circle" width="50" height="50" alt="" alt="">
                                <span style="margin-left: 10px;">
                                    @if ($notification->type === 'App\Notifications\LikeNotification')
                                        <a href="{{ url('/posts/' . $notification->data['post_id']) }}"
                                            style="color: #9F7AEA;">
                                            <i class="fas fa-heart" style="color: #F56565;"></i>
                                            {{ $notification->data['message'] }}
                                        </a> by <a href="{{ $notification->data['profile_url'] }}" style="color: #48BB78;">
                                            {{ $notification->data['user_name'] }}
                                        </a>
                                    @elseif ($notification->type === 'App\Notifications\FriendRequestNotification')
                                        <a href="{{ $notification->data['action_url'] }}" style="color: #9F7AEA;">
                                            <i class="fas fa-user-plus"></i> {{ $notification->data['message'] }}
                                        </a>
                                        by <a href="{{ $notification->data['profile_url'] }}" style="color: #48BB78;">
                                            {{ $notification->data['user_name'] }}
                                        </a>
                                    @elseif ($notification->type === 'App\Notifications\CommentNotification')
                                        <a href="{{ url('/posts/' . $notification->data['post_id']) }}"
                                            style="color: #9F7AEA;">
                                            <i class="fas fa-comment"></i> {{ $notification->data['message'] }}
                                        </a> by <a href="{{ $notification->data['profile_url'] }}" style="color: #48BB78;">
                                            {{ $notification->data['user_name'] }}
                                        </a>
                                    @else
                                        <i class="fas fa-info-circle"></i> {{ $notification->data['message'] }} by <a
                                            href="{{ $notification->data['profile_url'] }}" style="color: #48BB78;">
                                            {{ $notification->data['user_name'] }}
                                        </a>
                                    @endif
                                </span>
                            </p>
                            <button type="submit" style="background-color: transparent; border: none;">
                                <i class="fas fa-check" style="color: #48BB78;"></i>
                            </button>
                        </div>
                    </form>
                @endforeach

                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit"
                        style="background-color: #48BB78; color: #FFFFFF; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-check-circle"></i> Mark All as Read
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection
