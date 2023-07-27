@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto mt-5">
                <div>
                    <h1 class="mb-4">Search Results</h1>
                    <div>
                    </div>
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
                            </div>
                        @endforeach
                    </div>
                </div>
            @endsection
