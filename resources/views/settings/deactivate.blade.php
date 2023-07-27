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
                <div class="col-lg-7 col-md-12">
                    <div class="row">
                        <div class="col-md-12 mx-auto px-5" style="background-color: #1A2235; min-height: 100vh">
                            <br>
                            <br>
                            <br>

                            <div class="mx-auto">
                                <div class="card-body">
                                    <div class="card-text"
                                        style="color: #48abe0; font-weight:600; margin-left: 25px; font-size: 1.2rem; font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        Deactivate Account
                                    </div>

                                    <form method="POST" action="{{ url('/deactivateAccount/' . $user->id) }}">
                                        @csrf

                                        <p class="card-text px-4"> By deactivating your account, you will no longer be able
                                            to
                                            use
                                            it. You can reactivate your account at any time by logging in again. </p>

                                        {{-- Display session messages --}}
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <center>
                                            <div>
                                                <button type="submit" class="btn btn-danger">
                                                    {{ __('Deactivate Account') }}
                                                </button>
                                            </div>
                                        </center>
                                    </form>


                                </div>
                            </div>
                        </div>
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
