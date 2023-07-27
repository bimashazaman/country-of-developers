@auth
    <div style=" background-color: #192235; width: 250px; position: fixed; z-index: 1000; padding: 10px;"
        class="d-none d-lg-block min-vh-100">
        <br>
        <br>
        <br>
        <center>
            <a href="{{ route('profile.index', auth()->user()->id) }}" class=" text-center text-decoration-none"
                style="margin-left: 10px; vertical-align: middle; line-height: normal; font-size: 1.2rem; font-weight: semi-bold; font-family: 'Russo One', sans-serif; color: #28A4EF;">
                Friends
            </a>
        </center>
        @if (count($friends) > 0)
            @foreach ($friends as $friend)
                <div>
                    <div class="d-flex justify-content-between align-items- w-100 mt-4 mx-2">
                        <div class="d-flex align-items-center">
                            <img src=@if ($friend->avatar) {{ asset('avatars/' . $friend->avatar) }}
                                        @else "https://ui-avatars.com/api/?name={{ $friend->name }}&&background=0D8ABC&color=fff" @endif
                                style="width: 50px; height: 50px; border-radius: 50%;">
                            {{-- //active status --}}
                            <i class="fas fa-circle"
                                style="color: #1cfc33; font-size: 0.6rem; margin-left: -10px; margin-top: 30px;"></i>

                            <div class="pl-3">
                                <a href="{{ route('profile.index', $friend->id) }}" class="text-decoration-none"
                                    style="font-size: 1rem; color: #ffffff; margin-left: 10px;">
                                    {{ $friend->name }}</a>
                                <div style="font-size: 0.8rem; color: #28A4EF; margin-left: 10px;">
                                    {{ $friend->username }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center text-white">
                <br>
                <img src="{{ asset('images/empty.png') }}" alt="" style="width: 100px; height: 100px;">
                <p> No friends yet</p>
            </div>
        @endif

    </div>
@endauth
