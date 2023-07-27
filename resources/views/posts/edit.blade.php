@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 ">
                <div class="card " style="background-color: #141A29; color: #3ABEFE;">
                    <div class="card-header fs-5">{{ __('Edit Posts') }}</div>
                    <div class="card-body">
                        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data"
                            x-data="{ media: '', video: '', location: '', friends: [] }">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="caption">{{ __('Caption') }}</label>
                                <textarea id="caption" class="form-control @error('caption') is-invalid @enderror" name="caption"
                                    style="height: 100px; background-color: #141A29; color: #3ABEFE;" placeholder="{{ __('What\'s on your mind?') }}"
                                    autofocus>{{ old('caption') ?? $post->caption }}</textarea>

                                @error('caption')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group" x-data="{ show: false }">
                                <label for="media">{{ __('Media') }}</label>
                                <input id="media" type="file" name="media[]" multiple="multiple"
                                    class="form-control-file @error('media') is-invalid @enderror"
                                    x-on:change="media = $event.target.files[0]" value="{{ old('media') ?? $post->media }}">
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

                            {{-- <div class="form-group">
                                <label for="location">{{ __('Location') }}</label>
                                <select id="location" class="form-control" name="location" x-model="location">
                                    <option value="">{{ __('Select location') }}</option>
                                    <option value="New York">{{ __('New York') }}</option>
                                    <option value="Los Angeles">{{ __('Los Angeles') }}</option>
                                    <option value="Chicago">{{ __('Chicago') }}</option>
                                    <option value="Houston">{{ __('Houston') }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="friends">{{ __('Friends') }}</label>

                                <select id="friends" class="form-control" name="friends[]" multiple x-model="friends">
                                    <option value="1">John</option>
                                    <option value="2">Mary</option>
                                    <option value="3"> Jane</option>
                                    <option value="4">Peter</option>
                                </select>
                            </div> --}}

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Post') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
