@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 ">
                <div class="sidebar">
                    <!-- Place your sidebar content here -->
                    @include('partials.sidebar')
                </div>
            </div>
            <center>
                <div class="col-md-7 mx-auto mt-5" style="background-color: #1A2235; min-height: 100vh">
                    <div>
                        <div class="d-flex justify-content-around align-items-center">
                            <div
                                style="margin-top:15px; font-weight: 600; color: #3ABEFE; text-transform: uppercase; letter-spacing: 1px;">
                                <a href="{{ route('friends') }}" class="text-decoration-none" style="color: #3ABEFE;">
                                    <i class="fas fa-user-friends"></i>
                                    Friends
                                </a>
                            </div>

                            <div
                                style="margin-top:15px; font-weight: 600; color: #3ABEFE; text-transform: uppercase; letter-spacing: 1px;">
                                <a href="{{ route('friend-requests') }}" class="text-decoration-none"
                                    style="color: #3ABEFE;">
                                    <i class="fas fa-user-plus"></i>
                                    Friend Requests
                                </a>
                            </div>
                            <div
                                style="margin-top:15px; font-weight: 600; color: #3ABEFE; text-transform: uppercase; letter-spacing: 1px;">
                                <a href="{{ route('sent-friend-requests') }}" class="text-decoration-none"
                                    style="color: #3ABEFE;">
                                    <i class="fas fa-user-plus"></i>
                                    Sent Requests
                                </a>
                            </div>
                        </div>
                        <div>
                        </div>

                        <center>
                            <div class="row mt-2">
                                <div class="d-flex align-items-center mt-3 px-5">
                                    <p class="card-text" style="color: #48abe0; font-weight:600; font-size: 1.2rem;">
                                        Friend Requests
                                    </p>
                                    <span
                                        style="background-color: #f43e3e; border-radius: 50%; padding: 5px 10px; margin-left: 10px; font-size: 0.8rem; font-weight: 600;">
                                        {{ $friends->count() }}
                                    </span>
                                </div>
                                @foreach ($friends as $friend)
                                    <div class="col-md-4 col-sm-1 px-4 mt-5" style=" width: 220px">
                                        <div class=" justify-content-between align-items-center w-100 mt-3"
                                            style=" background-color: #0E121C; border-radius: 200px 200px 60px 60px; padding-left: 10px; padding-right:10px; padding-bottom: 10px; height: 280px;">
                                            <div class=" align-items-center">
                                                <img src=@if ($friend->avatar) {{ asset('avatars/' . $friend->avatar) }}
                        @else "https://ui-avatars.com/api/?name={{ $friend->name }}&&background=0D8ABC&color=fff" @endif
                                                    style="width: 150px; height: 150px; border-radius: 50%; margin-top: -15px;">
                                                <div class="pl-3">
                                                    <a href="{{ route('profile.index', $friend->id) }}"
                                                        class="text-decoration-none"
                                                        style="font-size: 1.1rem; color: #3ABEFE; margin-left: 10px;">
                                                        {{ $friend->name }}</a>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="">
                                                <form action="{{ route('accept-friend', $friend->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        style=" background-color: #48BAF0; border-radius: 50px; color: white;
                                                    width: 80%; outline: none; border: none; padding: 5px
                                                    ">
                                                        Accept
                                                    </button>
                                                </form>
                                                <form action="{{ route('reject-friend-request', $friend->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="mt-2"
                                                        style=" background-color: #1B2235; border-radius: 50px; color: white;  width: 80%; outline: none; border: none; padding: 5px; color:#3ABEFE">
                                                        Reject </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </center>

                    </div>
                </div>
            </center>
            <div class="col-2" style="position: fixed; right: 0; top: 0; height: 100vh; overflow-y: scroll;">
                @include('partials.usersSidebar')
            </div>
        </div>
    </div>
@endsection
