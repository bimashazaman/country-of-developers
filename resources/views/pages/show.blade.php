@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="">
                <div class="">
                    <center>
                        <img src=@if ($page->cover) {{ asset('covers/' . $page->cover) }}
                            @else "https://images.pexels.com/photos/1796794/pexels-photo-1796794.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" @endif
                            width="80%" height="400px">
                    </center>
                </div>
                <div style="margin-top: -100px; margin-left: 190px; display: flex;
                ">
                    <img class=" rounded-circle mb-4 border border-3 border-white"
                        src={{ $page->avatar
                            ? asset('avatars/' . $page->avatar)
                            : "https://ui-avatars.com/api/?name=$page->name&background=0D8ABC&color=fff" }}
                        width="200" height="200">
                    <h5 class="card-title"
                        style="color: #0D8ABC; font-weight: bold; margin-top: 10%; margin-left: 20px; font-size: 25px">
                        {{ $page->name }}
                    </h5>
                </div>

                {{-- create post button --}}
                @if (Auth::user()->id == $page->user_id)
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="card mt-5"
                                style="background-color: #131928; border-radius: 20px; border: 3px solid #0D8ABC; box-shadow: 0px 0px 10px #0D8ABC;">
                                <div class="card-body">
                                    <form action="{{ url("/pages/$page->id/posts") }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="caption" class="form-label">caption</label>
                                            <input type="text" class="form-control" id="caption" name="caption"
                                                value="{{ old('caption') }}" required autofocus
                                                style="background-color: #131928; border: 3px solid #293b42; color: white">
                                        </div>

                                        <div class="mb-3">
                                            <label for="media" class="form-label">
                                                Media
                                            </label>
                                            <input type="file" class="form-control" id="media" name="media"
                                                style="background-color: #131928; border: 3px solid #293b42; color: white">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- end create post button --}}

                <div class="col-8 mx-auto">
                    <br>
                    <br>
                    <br>


                    @foreach ($pagePost as $item)
                        @include('posts.partials.Card', ['post' => $item])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        function saveScrollPosition() {
            sessionStorage.setItem('scrollPosition', window.pageYOffset);
        }
        window.onload = function() {
            var scrollPosition = sessionStorage.getItem('scrollPosition');
            if (scrollPosition !== null) {
                window.scrollTo(0, scrollPosition);
                sessionStorage.removeItem('scrollPosition');
            }
        }
    </script>
@endsection
