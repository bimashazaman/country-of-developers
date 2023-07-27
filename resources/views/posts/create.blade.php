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

            <div class="col-md-7 ">
                <div class="card min-vh-100" style="background-color: #141A29; color: #3ABEFE;">
                    <div class="card-header fs-5">{{ __('Create Post') }}</div>
                    <br>
                    <div class="card-body">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
                            x-data="{ media: '', video: '', location: '', friends: [] }">
                            @csrf
                            <div class="form-group">
                                <label for="caption">{{ __('Caption') }}</label>
                                <input id="caption" class="form-control @error('caption') is-invalid @enderror"
                                    name="caption"
                                    style="
                                    background-color: #0E121C;
                                    color: white;
                                    border: none;
                                    border-radius: 20px;
                                    padding: 10px;
                                    outline: none;"
                                    value="{{ old('caption') }}" placeholder="Write a caption..." autofocus />
                                @error('caption')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group" x-data="{ show: false }">

                                <!-- Add a label for the file input to simulate the button and style it using CSS -->
                                <label for="media"
                                    style="    display: inline-block;
                                            padding: 6px 12px;
                                            cursor: pointer;
                                            border: 3px solid #0D8ABC;
                                            color: white;
                                            text-align: center;
                                            text-decoration: none;
                                            display: inline-block;
                                            font-size: 16px;
                                            margin: 4px 2px;
                                            transition-duration: 0.4s;
                                            border-radius: 20px;
                                            outline: none;
                                            font-family: 'Poppins', sans-serif;
                                            margin-left: 10px;
                                            margin-top: 10px;">
                                    Image or Video
                                </label>
                                <input id="media" type="file" name="media[]" multiple="multiple"
                                    class="form-control-file @error('media') is-invalid @enderror"
                                    x-on:change="media = $event.target.files[0]" style="display: none;" />
                                <!-- Hide the original input field -->


                                @error('media')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="mt-2" x-show="media" x-cloak>
                                    <div x-show="media.type.includes('image')">
                                        <img :src="URL.createObjectURL(media)" class="img-fluid" alt="Responsive image">
                                    </div>
                                    <div x-show="media.type.includes('video')">
                                        <video :src="URL.createObjectURL(media)" controls class="img-fluid"
                                            alt="Responsive image"></video>
                                    </div>
                                    <div class="mt-2">
                                        <button type="button"
                                            style='
                                            background-color: #fff;
                                            border: 1px solid #ced4da;
                                            border-radius: .25rem;
                                            padding: .375rem .75rem;
                                            font-size: 1rem;
                                            line-height: 1.5;
                                            color: #495057;
                                            background-color: #fff;
                                            background-clip: padding-box;
                                            border: 1px solid #ced4da;
                                            border-radius: .25rem;
                                            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                                            '
                                            x-on:click="media = ''">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </div>
                                </div>
                            </div>


                            <center>
                                <div class="form-group" style="margin-top: 10px;">
                                    <button type="submit"
                                        style="background-color: #0D8ABC; border: none; color: white; padding: 10px; border-radius: 20px; outline: none; padding-left: 30px; padding-right: 30px;">
                                        Upload Post
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
@endsection
