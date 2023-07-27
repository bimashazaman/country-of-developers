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
                                    <p class="card-text"
                                        style="color: #48abe0; font-weight:600; margin-left: 25px; font-size: 1.2rem; font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        Change Password
                                    </p>

                                    <form method="POST" action="{{ url('/user/password/' . $user->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

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


                                        <div class="form-group row mt-4">
                                            <label for="current_password"
                                                class="col-md-4 col-form-label text-md-right fw-bold px-5"
                                                style="color:#48abe0; font-weight:600">{{ __('Current Password') }}</label>
                                            <div class="col-md-12 d-flex">

                                                <i class="fas fa-lock"
                                                    style="color: #48abe0 ; margin-right: 10px; margin-top: 10px; font-size: 1.2rem"></i>

                                                <input
                                                    style="background-color: #0E121C; color: white ;border:none; border-radius: 20px; padding: 10px"
                                                    id="current_password" type="password"
                                                    class="form-control @error('current_password') is-invalid @enderror"
                                                    name="current_password" required autocomplete="current-password">
                                                @error('current_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row mt-4">
                                            <label for="new_password"
                                                class="col-md-4 col-form-label text-md-right fw-bold px-5"
                                                style="color:#48abe0; font-weight:600">{{ __('New Password') }}</label>
                                            <div class="col-md-12 d-flex">

                                                <i class="fas fa-lock"
                                                    style="color: #48abe0 ; margin-right: 10px; margin-top: 10px; font-size: 1.2rem"></i>

                                                <input
                                                    style="background-color: #0E121C; color: white ;border:none; border-radius: 20px; padding: 10px"
                                                    id="new_password" type="password"
                                                    class="form-control @error('new_password') is-invalid @enderror"
                                                    name="new_password" required autocomplete="new-password">
                                                @error('new_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <center>
                                            <br>
                                            <button type="submit" class="btn btn-primary"
                                                style="background-color: #3ABEFE; color: white ;border:none; border-radius: 20px; padding: 10px; margin:20px; padding: 10px; width: 40%; font-weight: 600">
                                                {{ __('Save Changes') }}
                                            </button>
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
