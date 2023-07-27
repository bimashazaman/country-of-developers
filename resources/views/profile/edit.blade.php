@extends('layouts.app')

@if (Auth::user()->id == $user->id)
    @section('content')
        <div class="container">
            <div class="row">
                @include('profile.partial.profileHeader')
            </div>
            <div>
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        @include('profile.partial.profileEditForm')
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>
            You are not authorized to view this page.
        </p>
    @endif
@endsection
