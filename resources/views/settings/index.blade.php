@extends('layouts.app')

@if (Auth::user()->id == $user->id)
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
                        <div class="row">
                            <div class="col-md-12 mx-auto px-5" style="background-color: #1A2235;">
                                @include('profile.partial.profileEditForm')
                                {{-- Logout --}}
                                <center>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            style="background-color: #3ABEFE; color: white ;border:none; border-radius: 20px; padding: 10px; margin:20px; padding: 10px; width: 40%; font-weight: 600">
                                            Logout</button>
                                    </form>
                                </center>
                            </div>
                        </div>
                    </div>
                </center>
                <div class="col-2" style="position: fixed; right: 0; top: 0; height: 100vh; overflow-y: scroll;">
                    @include('partials.usersSidebar')
                </div>
            </div>
        </div>
    @else
        <p>
            You are not authorized to view this page.
        </p>
    @endif
@endsection
