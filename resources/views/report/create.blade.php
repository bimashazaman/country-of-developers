@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <br>
        <br>
        <h1
            style="color: #3ABEFE; text-align: center; font-size: 30px;  font-family: 'Russo One', sans-serif; margin-top: 50px;">
            Report Post
        </h1>
        <div class="col-md-8 mx-auto">

            <form method="POST" action="{{ route('posts.report', ['post' => $post->id]) }}">
                @csrf

                <div class="form-group">


                    <label for="reason">Reason for Report</label>
                    <textarea id="reason" name="reason" class="form-control" rows="4" required
                        style="background-color: #1B2235; border-radius: 10px; padding: 20px; color: #FFFFFF;" autofocus>{{ old('reason') }}</textarea>
                    @error('reason')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <center>
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #3ABEFE; border-radius: 50px; padding: 10px 30px; color: #FFFFFF; font-size: 1.1rem; font-family: 'Russo One', sans-serif; text-decoration: none; margin-top: 20px;">Submit
                        Report</button>
                </center>
            </form>
        </div>
    </div>
@endsection
