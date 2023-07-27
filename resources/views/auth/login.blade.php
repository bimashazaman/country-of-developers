@extends('auth.partials.master')
@section('content')
    <div class="container-fluid"
        style="background-image: url('/bg/bg.png');
        background-size: cover; background-position: center;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.5) 0%, rgba(15, 18, 30, 0.5) 100%), url('/bg/bg.png');
        min-height: 100vh;">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div style="background-color: #0F121E; min-height: 100vh; width: 35rem">
                    <center>
                        <img src="{{ asset('logo/pokersocial.png') }}" class="d-inline-block align-top mt-5 mb-5"
                            style=" height: 75px;" alt="">
                    </center>
                    <div class="card-body justify-content-center align-items-center mt-5 mx-auto">
                        <div class=" justify-content-between d-flex"
                            style="
                            padding: 0 5rem;
                            ">
                            <div>
                                <h3 class="text-center mb-5"
                                    style="font-family: 'Russo One', sans-serif; font-size: 1.5rem; color: #fff; border-bottom: 5px solid #fff;">
                                    <a href="{{ route('login') }}" style="color: #fff; text-decoration: none;">
                                        SIGN IN
                                    </a>
                                </h3>
                            </div>
                            <div>
                                <h3 class="text-center mb-5"
                                    style="font-family: 'Russo One', sans-serif; font-size: 1.5rem; color: #1570AF;">
                                    <a href="{{ route('register') }}" style="color: #1570AF; text-decoration: none;">
                                        SIGN UP
                                    </a>
                                </h3>
                            </div>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}" class="w-100" style="color: #fff;">
                            @csrf
                            <div class="row mb-3 px-lg-5">
                                <div class="col-md-12 col-lg-6">

                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror w-100" name="email"
                                        style='background-color: #0C121E; border-top: none; border-bottom: #43A4D5 2px solid; border-left: none; border-right: none; color: #fff;'
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="col-md-12 col-lg-6">

                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        style='background-color: #0C121E; border-top: none; border-bottom: #43A4D5 2px solid; border-left: none; border-right: none; color: #fff;'
                                        required autocomplete="current-password" placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>


                            <div class="px-lg-5 ">
                                <div class="row mb-3">
                                    <div class=" justify-content-between d-flex">
                                        <div>
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}"
                                                    style="color: #fff; font-size: 0.8rem; font-weight: 600; text-decoration: none; font-family: 'Poppins', sans-serif;">
                                                    {{ __('Forgot Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row mb-0 px-lg-5">
                                <div class="col-md-12 px-lg-12">
                                    <center>
                                        <button type="submit" class="w-50"
                                            style="background: transparent linear-gradient(180deg, #01528B 0%, #0D2857 100%) 0% 0% no-repeat padding-box; border: none; border-radius: 5px; color: #fff; font-size: 1.2rem; font-weight: 600; padding: 0.5rem 1rem; box-shadow: 0px 3px 6px rgb(103, 103, 103); font-family: 'Russo One', sans-serif; width: 60%;">
                                            {{ __('SIGN IN') }}
                                        </button>
                                    </center>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                        </form>

                        {{-- OR --}}
                        <center>
                            <h4>
                                <div style="font-family: 'Russo One', sans-serif; color:#fff">
                                    OR
                                </div>
                            </h4>
                        </center>
                        <br>
                        <br>
                        <div>
                            <div class="row mb-0 px-lg-5 mx-lg-5 mt-3">
                                <div class="col-md-6">
                                    <a href="{{ url('/login/google') }}" class="w-100"
                                        style="display: inline-block; background: #db3236; color: #fff; border-radius: 5px; text-align: center; padding: 0.5rem 1rem; text-decoration: none; font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        {{ __('Google') }}
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('login.facebook') }}" class="w-100"
                                        style="display: inline-block; background: #3b5998; color: #fff; border-radius: 5px; text-align: center; padding: 0.5rem 1rem; text-decoration: none;font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        {{ __('Facebook') }}
                                    </a>
                                </div>
                            </div>


                        </div>

                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="row mb-0 px-lg-5 bottom-0">
                        <div class="col-md-12 px-lg-5 text-center">
                            <p
                                style="font-size: 0.8rem; font-weight: 600; font-family: 'Poppins', sans-serif; color: #fff;">
                                By signing up, you agree to our <a href="#"
                                    style="color: #3ABEFE; text-decoration: none;">Terms of Use</a> and <a href="#"
                                    style="color: #3ABEFE; text-decoration: none;">Privacy Policy</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
