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
                <div>
                    <div>
                        <div class="col-md-7 mx-auto mt-5 px-lg-4 p-md-2"
                            style=" background-color: #192235; min-height: 100vh">
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
                                <div class=" align-items-center mt-5">
                                    <div class="d-flex align-items-center mt-3">
                                        <p class="card-text" style="color: #48abe0; font-weight:600; font-size: 1.2rem;">
                                            All Friends
                                        </p>
                                        <span
                                            style="background-color: #f43e3e; border-radius: 50%; padding: 5px 10px; margin-left: 10px; font-size: 0.8rem; font-weight: 600;">
                                            {{ $friends->count() }}
                                        </span>
                                    </div>
                                    @foreach ($friends as $friend)
                                        <div style=" background-color: #0F121D; border-radius: 50px;"
                                            class="d-flex justify-content-between w-100 mt-3 " style="border-radius: 50px;">
                                            <div class="d-flex justify-content-between w-100 ">
                                                <div class="d-flex align-items-center">
                                                    <img src=@if ($friend->avatar) {{ asset('avatars/' . $friend->avatar) }}
                                        @else "https://ui-avatars.com/api/?name={{ $friend->name }}&&background=0D8ABC&color=fff" @endif
                                                        style="width: 80px; height: 80px; border-radius: 50%;">
                                                    <div class="pl-3">
                                                        <a href="{{ route('profile.index', $friend->id) }}"
                                                            class="text-decoration-none"
                                                            style="font-size: 1.1rem; color: #3ABEFE; margin-left: 10px;">
                                                            {{ $friend->name }}</a>
                                                    </div>
                                                </div>
                                                <form action="{{ route('remove-friend', $friend->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        style=" background-color: #1B2235; border-radius: 50px; color: white;  outline: none; border: none; padding: 5px; color:#3ABEFE; font-weight: 600; font-size: 1rem; margin-right: 30px; margin-top: 20px; padding: 5px 10px 5px 10px; ">
                                                        Unfriend</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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
