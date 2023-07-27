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
                <div class="col-lg-7 col-md-12 px-lg-4 px-0" style="background-color: #1A2235; min-height: 100vh">
                    <br>
                    <br>
                    <br>
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
                        <br>
                        <div>
                            @foreach ($friends as $friend)
                                <div class="d-flex justify-content-between align-items- w-100 mt-3">
                                    <div class="d-flex align-items-center">
                                        <img src=@if ($friend->avatar) {{ asset('avatars/' . $friend->avatar) }}
                                        @else "https://ui-avatars.com/api/?name={{ $friend->name }}&&background=0D8ABC&color=fff" @endif
                                            style="width: 50px; height: 50px; border-radius: 50%;">
                                        <div class="pl-3">
                                            <a href="{{ route('profile.index', $friend->id) }}" class="text-decoration-none"
                                                style="font-size: 1.1rem; color: #3ABEFE; margin-left: 10px;">
                                                {{ $friend->name }}</a>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">

                                        <form action="{{ route('cancel-friend-request', $friend->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-user-times"></i>
                                                Cancel Request
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </center>
            <div class="col-2" style="position: fixed; right: 0; top: 0; height: 100vh; overflow-y: scroll;">
                @include('partials.usersSidebar')
            </div>
        </div>
    </div>
@endsection
