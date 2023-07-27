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
                <div class="col-md-7 mx-auto" style="min-height: 100vh; background-color: #0D121C; ">
                    <br>
                    <br>
                    <br>

                    @include('comments.partials.show', [
                        'comments' => $post->comments,
                        'post_id' => $post->id,
                    ])
                    @include('comments.partials.commentInput')
                </div>
            </center>
            <div class="col-2" style="position: fixed; right: 0; top: 0; height: 100vh; overflow-y: scroll;">
                @include('partials.usersSidebar')
            </div>
        </div>
    </div>
@endsection
