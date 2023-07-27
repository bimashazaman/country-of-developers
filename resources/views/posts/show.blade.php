@extends('layouts.app')

@section('content')
    <div class="container" style=" min-height: 100vh;">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <br>
                <br>
                <br>
                <br>
                <br>
                <div class="px-1 py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <a href="{{ route('profile.index', $post->user->id) }}">
                                    <img src=@if ($post->user->avatar) {{ asset('avatars/' . $post->user->avatar) }}
                                        @else "https://ui-avatars.com/api/?name={{ $post->user->name }}&&background=0D8ABC&color=fff" @endif
                                        class="rounded-circle" width="50" height="50" alt="">
                                </a>
                            </div>
                            <div>
                                <div class="font-weight-bold">
                                    <a href="{{ route('profile.index', $post->user->id) }}" class="text-decoration-none"
                                        style='font-size: 1.1rem; margin-left: 10px; color: #ffffff;'>
                                        <span>{{ $post->user->name }}</span>
                                    </a>
                                    <a href="{{ route('profile.index', $post->user->id) }}" class="text-decoration-none"
                                        style='font-size: 0.9rem; color: #3ABEFE; font-weight: 500;'>
                                        <span>{{ $post->user->username ? '(' . $post->user->username . ')' : '' }}</span>
                                    </a>
                                </div>
                                <div class="text-start" style="font-size: 0.8rem; margin-left: 10px;  color: #9da1a2;">
                                    {{ $post->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        @if (!Auth::guest())
                            @if (auth()->user()->id == $post->user_id)
                                <div class="post-item" x-data="{ showOptions: false }">
                                    <!-- Post content here -->
                                    <div class="options" @click.away="showOptions = false">
                                        <button @click="showOptions = !showOptions" class="btn btn-sm btn-outline-secondary"
                                            style="color: #ffffff; border: none; background-color: #192235; font-size: 1.3rem;">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="options-menu  position-absolute  rounded   z-10 px-2 py-3"
                                            class="options-menu  position-absolute  rounded  text-start px-3 py-2"
                                            style="background-color: #182335; border: none; margin-left: -90px; border-radius: 10px; border : 2px solid #0B8ABB; box-shadow: 0px 0px 10px 0px #0B8ABB; width: 150px; color: #3ABEFE; min-height: 50px; z-index: 100;"
                                            x-show="showOptions" x-transition x-cloak>
                                            <center>
                                                <div
                                                    style="font-size: 1.2rem; margin-top: 5px; font-weight: 600; font-family: 'Russo One', sans-serif;">
                                                    More
                                                </div>
                                            </center>
                                            <a href="{{ route('posts.edit', $post) }}"
                                                class="btn btn-sm btn-outline-secondary m-2"
                                                style="color: #ffffff; border: none; background-color: #192235; font-size: 0.9rem;">
                                                <i class="fas fa-edit" style="margin-right: 5px">
                                                </i> Edit Post
                                            </a>

                                            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="color: #ffffff; border: none; background-color: #192235; font-size: 0.9rem;">
                                                    <i class="fas fa-trash"></i> Delete Post
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="post-item" x-data="{ showOptions1: false }">
                                    <!-- Post content here -->
                                    <div class="options" @click.away="showOptions1 = false">
                                        <button @click="showOptions1 = !showOptions1"
                                            class="btn btn-sm btn-outline-secondary"
                                            style="color: #ffffff; border: none; background-color: #192235; font-size: 1.3rem;">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="options-menu  position-absolute  rounded  text-start px-3 py-2"
                                            style="background-color: #182335; border: none; margin-left: -90px; border-radius: 10px; border : 2px solid #0B8ABB; box-shadow: 0px 0px 10px 0px #0B8ABB; width: 150px; color: #3ABEFE; min-height: 50px; z-index: 100;"
                                            x-show="showOptions1" x-transition x-cloak>
                                            <center>
                                                <div
                                                    style="font-size: 1.2rem; margin-top: 5px; margin-bottom: 10px; font-weight: 600; font-family: 'Russo One', sans-serif;">
                                                    More
                                                </div>
                                            </center>
                                            <div>
                                                <a href="#" class=" text-decoration-none text-white ">
                                                    <i style="color:#0B8ABB; margin-right: 5px" class="fas fa-share"></i>
                                                    Share
                                                </a>
                                                <hr>
                                            </div>

                                            <div class="">
                                                <a href="#" class=" text-decoration-none text-white ">
                                                    <i style="color:#0B8ABB; margin-right: 5px" class="fas fa-flag"></i>
                                                    Report
                                                </a>
                                            </div>
                                            <hr>

                                            <div>
                                                <a href="#" class=" text-decoration-none text-white ">
                                                    <i style="color:#0B8ABB; margin-right: 5px"
                                                        class="fas fa-user-slash"></i> Block
                                                </a>
                                            </div>
                                            <hr>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class=" text-decoration-none text-white py-3">
                                                <i style="color:#0B8ABB; margin-right: 5px" class="fas fa-save"></i>
                                                Save Post
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="m-2">
                    {{ $post->caption }}
                </div>
                <div class="card mb-4">
                    @if ($post->media)
                        @if (Str::endsWith($post->media, '.mp4') ||
                                Str::endsWith($post->media, '.mov') ||
                                Str::endsWith($post->media, '.avi') ||
                                Str::endsWith($post->media, '.wmv') ||
                                Str::endsWith($post->media, '.flv') ||
                                Str::endsWith($post->media, '.mkv'))
                            <video controls class="card-img-top">
                                <source src="{{ asset('uploads/' . $post->media) }}" type="video/mp4">
                            </video>
                        @else
                            <img src="{{ asset('uploads/' . $post->media) }}" class="card-img-top" alt="">
                        @endif
                    @endif
                </div>
                @include('posts.partials.postActions', ['post' => $post])
                @include('comments.partials.show', [
                    'comments' => $post->comments,
                    'post_id' => $post->id,
                ])
            </div>
        </div>
    </div>
@endsection
