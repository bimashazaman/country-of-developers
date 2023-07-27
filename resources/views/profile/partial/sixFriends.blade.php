<div class="row px-5" style="color: #66B0DB; font-size: 1.2rem; font-weight: 600;">
    Friends {{ $friends->count() }}
</div>
<br>
<div class="row px-4">
    @foreach ($firstSixFriends as $friend)
        <div class="col-md-4 col-lg-2 col-sm-3 col-4 mb-3">
            <div style=" border-radius: 10px; color: #FFFFFF;">
                <div class="">
                    <div class="row">
                        <div class="col-4 text-center">
                            <img src=@if ($friend->avatar) {{ asset('avatars/' . $friend->avatar) }}
                                        @else "https://ui-avatars.com/api/?name={{ $friend->name }}&&background=0D8ABC&color=fff" @endif
                                width="100" height="100" class="rounded" alt="">
                            <center> <a href="{{ url('/profile/' . $friend->id) }}" style="color: #f9f9f9;"
                                    class="mt-2 text-center
                                d-block">
                                    {{ $friend->name }}
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
