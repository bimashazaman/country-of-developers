<br>
<br>
<br>

<div class="mx-auto align-content-lg-start text-start">
    <div class="card-body">
        <p class="card-text"
            style="color: #48abe0; font-weight:600; margin-left: 25px; font-size: 1.2rem; font-family: 'Poppins', sans-serif; font-weight: 600;">
            Account Information
        </p>
        <form method="POST" action="{{ url('user/' . $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group row mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-right fw-bold px-5"
                    style="color:#48abe0; font-weight:600;">
                    {{ __('Name') }}</label>
                <div class="col-md-12 d-flex">

                    <i class="fas fa-user"
                        style="color: #48abe0 ; margin-right: 10px; margin-top: 10px; font-size: 1.2rem"></i>

                    <input
                        style="background-color: #0E121C; color: white ;border:none; border-radius: 20px; padding: 10px"
                        id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name', $user->name) }}" autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mt-4">
                <label for="email" class="col-md-4 col-form-label text-md-right fw-bold px-5"
                    style="color:#48abe0; font-weight:600; ">{{ __('Email') }}</label>
                <div class="col-md-12 d-flex">
                    <i class="fas fa-envelope"
                        style="color: #48abe0 ; margin-right: 10px; margin-top: 10px; font-size: 1.2rem"></i>
                    <input
                        style="background-color: #0E121C; color: white; border:none; border-radius: 20px; padding: 10px"
                        id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email', $user->email) }}" autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mt-4">
                <label for="username" class="col-md-4 col-form-label text-md-right fw-bold px-5"
                    style="color:#48abe0; font-weight:600;">{{ __('Username') }}</label>

                <div class="col-md-12 d-flex">
                    <i class="fas fa-user"
                        style="color: #48abe0 ; margin-right: 10px; margin-top: 10px; font-size: 1.2rem"></i>
                    <input
                        style="background-color: #0E121C; color: white ;border:none; border-radius: 20px; padding: 10px"
                        id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username', $user->username) }}" autocomplete="username">

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>



            <div class="form-group row mt-4">

                <label for="phone" class="col-md-4 col-form-label text-md-right fw-bold px-5"
                    style="color:#48abe0; font-weight:600; ">{{ __('Phone') }}</label>
                <div class="col-md-12 d-flex">
                    <i class="fas fa-phone"
                        style="color: #48abe0 ; margin-right: 10px; margin-top: 10px; font-size: 1.2rem"></i>
                    <input
                        style="background-color: #0E121C; color: white ;border:none; border-radius: 20px; padding: 10px"
                        id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                        name="phone" value="{{ old('phone', $user->phone) }}" autocomplete="phone">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="form-group row mt-4">
                    <label for="age" class="col-md-4 col-form-label text-md-right fw-bold px-5"
                        style="color:#48abe0; font-weight:600; ">{{ __('Age') }}</label>
                    <div class="col-md-12 d-flex">
                        <i class="fas fa-birthday-cake"
                            style="color: #48abe0 ; margin-right: 10px; margin-top: 10px; font-size: 1.2rem"></i>
                        <input
                            style="background-color: #0E121C; color: white ;border:none; border-radius: 20px; padding: 10px"
                            id="age" type="date" class="form-control @error('age') is-invalid @enderror"
                            name="age" value="{{ old('age', $user->age) }}" autocomplete="age">

                        @error('age')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
                <div class="form-group row mt-4">
                    <label for="avatar" class="col-md-4 col-form-label text-md-right fw-bold px-5"
                        style="color:#48abe0; font-weight:600; ">{{ __('Avatar') }}</label>
                    <div class="col-md-12 d-flex">
                        <i class="fas fa-image"
                            style="color: #48abe0 ; margin-right: 10px; margin-top: 10px; font-size: 1.2rem"></i>
                        <input
                            style="background-color: #0E121C; color: white ;border:none; border-radius: 20px; padding: 10px"
                            id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror"
                            name="avatar" value="{{ old('avatar', $user->avatar) }}" autocomplete="avatar">
                        @error('avatar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="cover" class="col-md-4 col-form-label text-md-right fw-bold px-5"
                        style="color:#48abe0; font-weight:600; ">{{ __('Cover') }}</label>
                    <div class="col-md-12 mt-2 d-flex">
                        <i class="fas fa-image"
                            style="color: #48abe0 ; margin-right: 10px; margin-top: 10px; font-size: 1.2rem"></i>
                        <input
                            style="background-color: #0E121C; color: white ;border:none; border-radius: 20px; padding: 10px"
                            id="cover" type="file" class="form-control @error('cover') is-invalid @enderror"
                            name="cover" value="{{ old('cover', $user->cover) }}" autocomplete="cover">

                        @error('cover')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="form-group row mt-4">
                    <label for="bio" class="col-md-4 col-form-label text-md-right fw-bold px-5"
                        style="color:#48abe0; font-weight:600; ">{{ __('Bio') }}</label>
                    <div class="col-md-12 d-flex">
                        <i class="fas fa-info-circle"
                            style="color: #48abe0 ; margin-right: 10px; margin-top: 10px; font-size: 1.2rem"></i>
                        <input
                            style="background-color: #0E121C; color: white ;border:none; border-radius: 20px; padding: 10px"
                            id="bio" type="text" class="form-control @error('bio') is-invalid @enderror"
                            name="bio" value="{{ old('bio', $user->bio) }}" autocomplete="bio">

                        @error('bio')
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
        <br> <br>
        <br>
        <br>
        <br>
        <br>
        <div>
            <a href={{ url('/user/password/' . $user->id) }} class="card-link" style="text-decoration: none">
                <div class="d-flex justify-content-between"
                    style="color: #48abe0; font-weight:600; margin-left: 25px; font-size: 1rem; font-family: 'Poppins', sans-serif; font-weight: 600; padding-right: 8%; margin-top: 10px">
                    Password & Security
                    <i class="fas fa-chevron-right" style="color: #48abe0 ;  margin-top: 10px; font-size: 1.2rem"></i>
                </div>
            </a>
        </div>

        <div>


            <div class="d-flex"
                style="color: #e5edf1; font-weight:600; margin-left: 25px; font-size: 1rem; font-family: 'Poppins', sans-serif; font-weight: 600; padding-right: 8%; align-items: center">
                <i class="fas fa-user-shield" style="color: #48abe0 ; margin-right: 10px; font-size: 1.2rem"></i>
                <p style=" margin-top: 10px">
                    Help Center
                </p>
            </div>

            <div class="d-flex"
                style="color: #e5edf1; font-weight:600; margin-left: 25px; font-size: 1rem; font-family: 'Poppins', sans-serif; font-weight: 600; padding-right: 8%; align-items: center">
                {{-- terms and conditions icon --}}
                <i class="fas fa-file-contract" style="color: #48abe0 ; margin-right: 10px; font-size: 1.2rem"></i>
                <p style=" margin-top: 10px">
                    Terms of Service
                </p>
            </div>

            <div class="d-flex"
                style="color: #e5edf1; font-weight:600; margin-left: 25px; font-size: 1rem; font-family: 'Poppins', sans-serif; font-weight: 600; padding-right: 8%; align-items: center">
                {{-- privacy policy icon --}}
                <i class="fas fa-user-secret" style="color: #48abe0 ; margin-right: 10px; font-size: 1.2rem"></i>
                <p style=" margin-top: 10px">
                    Privacy Policy
                </p>
            </div>

            <div class="d-flex"
                style="color: #e5edf1; font-weight:600; margin-left: 25px; font-size: 1rem; font-family: 'Poppins', sans-serif; font-weight: 600; padding-right: 8%; align-items: center">
                {{-- cookies policy icon --}}
                <i class="fas fa-cookie-bite" style="color: #48abe0 ; margin-right: 10px; font-size: 1.2rem"></i>
                <p style=" margin-top: 10px">
                    Cookies Policy
                </p>
            </div>

            <div class="d-flex"
                style="color: #e5edf1; font-weight:600; margin-left: 25px; font-size: 1rem; font-family: 'Poppins', sans-serif; font-weight: 600; padding-right: 8%; align-items: center">
                {{-- intellectual property policy icon --}}
                <i class="fas fa-gavel" style="color: #48abe0 ; margin-right: 10px; font-size: 1.2rem"></i>
                <p style=" margin-top: 10px">
                    About
                </p>
            </div>

            <div class="d-flex"
                style="color: #e5edf1; font-weight:600; margin-left: 25px; font-size: 1rem; font-family: 'Poppins', sans-serif; font-weight: 600; padding-right: 8%; align-items: center">
                {{-- ads choices icon --}}
                <i class="fas fa-ad" style="color: #48abe0 ; margin-right: 10px; font-size: 1.2rem"></i>
                <p style=" margin-top: 10px">
                    Ads choices
                </p>
            </div>

        </div>


        <div>
            <br>
            <br>
            <div class="d-flex justify-content-between"
                style="color: #48abe0; font-weight:600; margin-left: 25px; font-size: 1rem; font-family: 'Poppins', sans-serif; font-weight: 600; padding-right: 8%; margin-top: 10px">
                Account Deactivation
            </div>
            <br>

            <a href={{ url('/deactivateView/' . $user->id) }} class="card-link" style="text-decoration: none">
                <div class="d-flex justify-content-between"
                    style="color: #e5edf1; font-weight:600; margin-left: 25px; font-size: 1rem; font-family: 'Poppins', sans-serif; font-weight: 600; padding-right: 8%">
                    <p style=" margin-top: 10px">
                        Deactivate Account
                    </p>
                    <i class="fas fa-chevron-right" style="color: #48abe0 ;  margin-top: 10px; font-size: 1.2rem"></i>
                </div>
            </a>
        </div>
    </div>
