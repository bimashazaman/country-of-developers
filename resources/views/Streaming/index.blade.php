@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="sidebar">
                    <!-- Place your sidebar content here -->
                    @include('partials.sidebar')
                </div>
            </div>
            <div class="col mx-auto">
                <br>
                <br>
                <br>
                <br>
                <br>
                <button>
                    <a href="{{ route('streaming.create') }}" class="btn btn-primary">Create Streaming</a>
                </button>
            </div>
        </div>
    </div>
@endsection
