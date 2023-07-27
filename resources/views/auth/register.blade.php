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
                                    style="font-family: 'Russo One', sans-serif; font-size: 1.5rem; color: #1570AF;">
                                    <a href="{{ route('login') }}" style="color: #1570AF; text-decoration: none;">
                                        SIGN IN
                                    </a>
                                </h3>
                            </div>
                            <div>
                                <h3 class="text-center mb-5"
                                    style="font-family: 'Russo One', sans-serif; font-size: 1.5rem; color: #fff; border-bottom: 5px solid #fff">
                                    <a href="{{ route('register') }}" style="color: #fff; text-decoration: none;">
                                        SIGN UP
                                    </a>
                                </h3>
                            </div>

                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger mx-lg-5 px-lg-5" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <center>
                                <div class="row mx-4 w-75 mb-4">
                                    <div class="col ">
                                        <div>
                                            <input
                                                style='background-color: #0C121E; border-top: none; border-bottom:#43A4D5 2px solid; border-left: none; border-right: none; color: #fff; width: 100%'
                                                id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus
                                                placeholder="Name">

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>
                                            <input
                                                style='background-color: #0C121E; border-top: none; border-bottom:#43A4D5 2px solid; border-left: none; border-right: none; color: #fff;'
                                                id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                value="{{ old('username') }}" required autocomplete="username"
                                                placeholder="Username">

                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </center>


                            <!-- Date of birth input -->
                            <div class="form-group row px-lg-5 mb-4">
                                <label for="dob" style="color:#575C75"
                                    class="col-form-label text-md-right fw-bold px-lg-5 mx-2">{{ __('Date of Birth') }}</label>
                                <div class="d-flex justify-content-between w-100 px-lg-5">
                                    <!-- Day -->
                                    <select id="day" class="form-control @error('day') is-invalid @enderror"
                                        name="day" required
                                        style="background-color: #0C121E; border-top: none; border-bottom:#43A4D5 2px solid; border-left: none; border-right: none; color: #fff; margin-right: 1rem;">
                                        <option value="">Day</option>
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>

                                    <!-- Month -->
                                    <select id="month" class="form-control @error('month') is-invalid @enderror"
                                        name="month" required
                                        style="background-color: #0C121E; border-top: none; border-bottom:#43A4D5 2px solid; border-left: none; border-right: none; color: #fff; margin-right: 1rem;">
                                        <option value="">Month</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>

                                    <!-- Year -->
                                    <select id="year" class="form-control @error('year') is-invalid @enderror"
                                        name="year" required
                                        style="background-color: #0C121E; border-top: none; border-bottom:#43A4D5 2px solid; border-left: none; border-right: none; color: #fff; margin-right: 1rem;">
                                        <option value="">Year</option>
                                        @for ($i = date('Y'); $i >= 1900; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>

                                    @error('day')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    @error('month')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    @error('year')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <!-- Gender input -->
                            <div class="form-group row px-lg-5 mb-4">
                                <label for="gender" style="color:#575C75"
                                    class="col-form-label text-md-right fw-bold px-lg-5 mx-2">{{ __('Gender') }}</label>
                                <div class="px-lg-5 m-2 d-flex justify-content-around">


                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male"
                                            value="male" required>
                                        <label class="form-check-label" style="color:#fff" for="male">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female"
                                            value="female" required>
                                        <label class="form-check-label" style="color:#fff" for="female">
                                            Female
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="other"
                                            value="other" required>
                                        <label class="form-check-label" style="color:#fff" for="other">
                                            Other
                                        </label>
                                    </div>

                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <center>
                                <div class="row mx-4 w-75">
                                    <div class="col ">
                                        <div>
                                            <input
                                                style='background-color: #0C121E; border-top: none; border-bottom:#43A4D5 2px solid; border-left: none; border-right: none; color: #fff; width: 100%'
                                                id="email" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="email"
                                                value="{{ old('name') }}" required autocomplete="email" autofocus
                                                placeholder="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>
                                            <input
                                                style='background-color: #0C121E; border-top: none; border-bottom:#43A4D5 2px solid; border-left: none; border-right: none; color: #fff;'
                                                id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" value="{{ old('password') }}" required
                                                autocomplete="password" placeholder="password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </center>


                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="row mb-0 px-lg-5">
                                <div class="col-md-12 px-lg-12">
                                    <center>
                                        <button type="submit" class="w-50"
                                            style="background: transparent linear-gradient(180deg, #01528B 0%, #0D2857 100%) 0% 0% no-repeat padding-box; border: none; border-radius: 5px; color: #fff; font-size: 1.2rem; font-weight: 600; padding: 0.5rem 1rem; box-shadow: 0px 3px 6px rgb(103, 103, 103); font-family: 'Russo One', sans-serif; width: 60%;">
                                            {{ __('SIGN UP') }}
                                        </button>
                                    </center>
                                </div>
                            </div>
                        </form>
                        {{-- OR --}}
                        <br>
                        <br>
                        <center>
                            <h4>
                                <div style="font-family: 'Russo One', sans-serif; color:#fff">
                                    OR
                                </div>
                            </h4>
                        </center>
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
