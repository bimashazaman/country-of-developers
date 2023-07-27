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
            <div class="col-lg-7 col-md-1 mx-4">
                <div class="card" style="background-color: #131928; border-radius: 20px;">
                    <br>
                    <br>
                    <br>
                    <h1 style="color: #3ABEFE; text-align: center; font-size: 30px;  font-family: 'Russo One', sans-serif;">
                        Pages
                    </h1>


                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                <div class="container">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/pages') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="px-4 my-4">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input style="background-color: #131928; border: 3px solid #293b42; color: white"
                                        id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="px-4 my-4">
                                <label for="username"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                <div class="col-md-12">
                                    <input style="background-color: #131928; border: 3px solid #293b42; color: white"
                                        id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="px-4 my-4">
                                <label for="avatar"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>

                                <div class="col-md-12">
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input @error('avatar') is-invalid @enderror" id="avatar"
                                            name="avatar">
                                        <label class="custom-file-label" for="avatar">{{ __('Choose file') }}</label>
                                    </div>

                                    @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="px-4 my-4">
                                <label for="cover"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cover') }}</label>

                                <div class="col-md-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('cover') is-invalid @enderror"
                                            id="cover" name="cover">
                                        <label class="custom-file-label" for="cover">{{ __('Choose file') }}</label>
                                    </div>

                                    @error('cover')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="px-4 my-4">
                                <label for="phone"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-12">
                                    <input style="background-color: #131928; border: 3px solid #293b42; color: white"
                                        id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone') }}">

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="px-4 my-4">
                                <label for="address"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                <div class="col-md-12">
                                    <input style="background-color: #131928; border: 3px solid #293b42; color: white"
                                        id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address') }}">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="px-4 my-4">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-12">
                                    <textarea style="background-color: #131928; border: 3px solid #293b42; color: white" id="description"
                                        class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description') }}</textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="px-4 my-4 mb-0">
                                <button type="submit"
                                    style="background-color: #0D8ABC; border: 3px solid #0D8ABC; color: white; width:100%; padding: 10px">{{ __('Create') }}</button>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-2" style="position: fixed; right: 0; top: 0; height: 100vh; overflow-y: scroll;">
                @include('partials.usersSidebar')
            </div>
        </div>
    </div>
@endsection
