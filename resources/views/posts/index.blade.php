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
                <div class="col-lg-7 col-md-12">

                    @include('posts.stories.stories')
                    @include('posts.partials.createPost')
                    @foreach ($posts as $post)
                        @include('posts.partials.Card', ['post' => $post])
                    @endforeach
                    {{ $posts->links() }}
                </div>
            </center>
            <div class="col-2" style="position: fixed; right: 0; top: 0; height: 100vh; overflow-y: scroll;">
                @include('partials.usersSidebar')
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
