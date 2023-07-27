@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto mt-5">
                <div>
                    <div class=" align-items-center mt-5">
                        <div>
                            <h1 class="mb-4">Likes</h1>
                        </div>
                        @if ($likes->count() > 0)
                            @foreach ($likes as $like)
                                <div class="d-flex justify-content-between align-items- w-100 mt-3">
                                    <div class="d-flex align-items-center">
                                        <img src=@if ($like->user->avatar) {{ asset('avatars/' . $like->user->avatar) }}
                                            @else "https://ui-avatars.com/api/?name={{ $like->user->name }}&&background=0D8ABC&color=fff" @endif
                                            style="width: 50px; height: 50px; border-radius: 50%;">
                                        <div class="pl-3">
                                            <a href="{{ route('profile.index', $like->user->id) }}"
                                                class="text-decoration-none"
                                                style="font-size: 1.1rem; color: #3ABEFE; margin-left: 10px;">
                                                {{ $like->user->name }}</a>
                                        </div>
                                    </div>
                                    <div class="text-muted">
                                        {{ $like->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
