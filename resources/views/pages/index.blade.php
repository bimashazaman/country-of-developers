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
                <div class="col-md-7 mx-auto mt-5 px-4"
                    style=" background-color: #1B2235; border-radius: 10px; padding: 20px; color: #FFFFFF; min-height: 100vh;">
                    <h1 style="color: #3ABEFE; text-align: center; font-size: 30px;  font-family: 'Russo One', sans-serif;">
                        Pages
                    </h1>

                    <div>
                        <div class=" align-items-center mt-5">
                            <div class="row">
                                <div class="col">
                                    {{-- create page button --}}
                                    <a href="{{ url('/pages/create') }}"
                                        style="
                                    background-color: #3ABEFE; border-radius: 50px; padding: 10px 30px; color: #FFFFFF; font-size: 1.1rem; font-family: 'Russo One', sans-serif; text-decoration: none;
                                    ">
                                        Create </a>
                                </div>
                                {{-- <div class="col">
                                    <a href="{{ url('/pages/create') }}"
                                        style="
                                    background-color: #3ABEFE; border-radius: 50px; padding: 10px 30px; color: #FFFFFF; font-size: 1.1rem; font-family: 'Russo One', sans-serif; text-decoration: none;
                                    ">
                                        Discover
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ url('/pages/create') }}"
                                        style="
                                    background-color: #3ABEFE; border-radius: 50px; padding: 10px 30px; color: #FFFFFF; font-size: 1.1rem; font-family: 'Russo One', sans-serif; text-decoration: none;
                                    ">
                                        Invites
                                    </a>
                                </div> --}}
                            </div>
                            @if (count($pages) === 0)
                                <div>
                                </div>
                            @else
                                <br>
                                <div class="d-flex justify-content-between align-items- w-100 mt-3"
                                    style="color: #3ABEFE; font-size: 1.1rem; font-family: 'Russo One', sans-serif; ">
                                    Your Pages
                                </div>
                                @foreach ($pages as $item)
                                    <div>
                                        <div class="d-flex justify-content-between align-items- w-100 mt-3">
                                            <div class="d-flex align-items-center">
                                                <img src=@if ($item->avatar) {{ asset('/avatars/' . $item->avatar) }}
                                        @else "https://ui-avatars.com/api/?name={{ $item->name }}&&background=0D8ABC&color=fff" @endif
                                                    style="width: 50px; height: 50px; border-radius: 50%;">
                                                <div class="pl-3">
                                                    <a href="{{ url('/pages', $item->username) }}"
                                                        class="text-decoration-none"
                                                        style="font-size: 1.1rem; color: #ffffff; margin-left: 10px;">
                                                        {{ $item->name }}</a>
                                                </div>
                                                {{-- admin icon --}}

                                                <div class="pl-3">
                                                    <a href="{{ url('/pages', $item->username) }}"
                                                        class="text-decoration-none"
                                                        style="font-size: 0.9rem; color: #3ABEFE;; margin-left: 20px;">
                                                        <i class="fas fa-user-shield"></i> Admin
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class=" align-items-center mt-5">
                        @if (count($allPages) === 0)
                            <div>
                            </div>
                        @else
                            <div class="d-flex justify-content-between align-items- w-100 mt-3"
                                style="color: #3ABEFE; font-size: 1.1rem; font-family: 'Russo One', sans-serif; ">
                                Other Pages
                            </div>
                            @foreach ($allPages as $item)
                                <div class="d-flex justify-content-between align-items- w-100 mt-3">
                                    <div class="d-flex align-items-center">
                                        <img src=@if ($item->avatar) {{ asset('/avatars/' . $item->avatar) }}
                                        @else "https://ui-avatars.com/api/?name={{ $item->name }}&&background=0D8ABC&color=fff" @endif
                                            style="width: 50px; height: 50px; border-radius: 50%;">
                                        <div class="pl-3">
                                            <a href="{{ url('/pages', $item->username) }}" class="text-decoration-none"
                                                style="font-size: 1.1rem; color: #ffffff; margin-left: 10px; font-weight: 700;">
                                                {{ $item->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </center>
            <div class="col-2" style="position: fixed; right: 0; top: 0; height: 100vh; overflow-y: scroll;">
                @include('partials.usersSidebar')
            </div>
        </div>
    </div>
@endsection
