@auth
    <div class='p-4 position-absolute start-0 d-none d-lg-block overflow-auto'
        style='z-index: 1000; top: 70px; background-color: #192235; width: 280px; min-height: 100%'>

        <a href="{{ route('profile.index', auth()->user()->id) }}" class="text-white text-decoration-none">
            <img src=@if (auth()->user()->avatar) "{{ asset('avatars/' . auth()->user()->avatar) }}"
                                        @else "https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D8ABC&color=fff" @endif
                class="rounded-circle text-decoration-none border-1 border-light border" width="50" height="50">
        </a>
        <a href="{{ route('profile.index', auth()->user()->id) }}" class="text-white text-decoration-none">
            <div class="d-inline-block" style=" margin-left: 10px; vertical-align: middle; line-height: normal;">
                {{ auth()->user()->name }}
                <div>
                    <a href="{{ route('profile.index', auth()->user()->id) }}" class="text-decoration-none"
                        style='font-size: 0.9rem; color: #3ABEFE; font-weight: 600;'>
                        <span>{{ auth()->user()->username ? '(' . auth()->user()->username . ')' : '' }}</span>
                    </a>
                </div>
            </div>

        </a>


        <hr class=" text-black">

        <div> <a href="#" class="text-white text-decoration-none">
                <img src={{ asset('ImageIcons/watch.jpeg') }} class="rounded-circle text-decoration-none" width="50"
                    height="50">
            </a>
            <a href="#" class="text-white text-decoration-none">
                <div class="d-inline-block fw-bold"
                    style=" margin-left: 10px; vertical-align: middle; line-height: normal;">
                    Watch
                </div>
            </a>
        </div>
        <br>

        <div> <a href="{{ url('/pages') }}" class="text-white text-decoration-none">
                <img src={{ asset('ImageIcons/channel.jpeg') }} class="rounded-circle text-decoration-none" width="50"
                    height="50">
            </a>
            <a href="{{ url('/pages') }}" class="text-white text-decoration-none">
                <div class="d-inline-block fw-bold"
                    style=" margin-left: 10px; vertical-align: middle; line-height: normal;">
                    Channels
                </div>
            </a>
        </div>
        <br>

        <div> <a href="#" class="text-white text-decoration-none">
                <img src={{ asset('ImageIcons/groups.jpeg') }} class="rounded-circle text-decoration-none" width="50"
                    height="50">
            </a>
            <a href="#" class="text-white text-decoration-none">
                <div class="d-inline-block fw-bold"
                    style=" margin-left: 10px; vertical-align: middle; line-height: normal;">
                    Groups
                </div>
            </a>
        </div>

        <br>

        <div> <a href="{{ url('/pages') }}" class="text-white text-decoration-none">
                <img src={{ asset('ImageIcons/pages.jpeg') }} class="rounded-circle text-decoration-none" width="50"
                    height="50">
            </a>
            <a href="{{ url('/pages') }}" class="text-white text-decoration-none">
                <div class="d-inline-block fw-bold"
                    style=" margin-left: 10px; vertical-align: middle; line-height: normal;">
                    Pages
                </div>
            </a>
        </div>

        <br>

        <div> <a href="#" class="text-white text-decoration-none">
                <img src={{ asset('ImageIcons/live.jpeg') }} class="rounded-circle text-decoration-none" width="50"
                    height="50">
            </a>
            <a href="{{ url('/streaming/create') }}" class="text-white text-decoration-none">
                <div class="d-inline-block fw-bold"
                    style=" margin-left: 10px; vertical-align: middle; line-height: normal;">
                    Live
                </div>
            </a>
        </div>

        <br>
        <div> <a href="#" class="text-white text-decoration-none">
                <img src={{ asset('ImageIcons/community.jpeg') }} class="rounded-circle text-decoration-none"
                    width="50" height="50">
            </a>
            <a href="#" class="text-white text-decoration-none">
                <div class="d-inline-block fw-bold"
                    style=" margin-left: 10px; vertical-align: middle; line-height: normal;">
                    Community
                </div>
            </a>
        </div>


        <hr>
        <br>


        <div class=" text-decoration-none"
            style="margin-left: 10px; line-height: normal; font-size: 0.9rem; font-weight: semi-bold; font-family: 'Russo One', sans-serif; color: #28A4EF;">
            Your Shortcuts
        </div>


        @foreach ($pages as $item)
            <div>
                <div class="d-flex justify-content-between w-100 mt-3">
                    <div class="d-flex align-items-center">
                        <img src=@if ($item->avatar) {{ asset('/avatars/' . $item->avatar) }}
                                        @else "https://ui-avatars.com/api/?name={{ $item->name }}&&background=0D8ABC&color=fff" @endif
                            style="width: 45px; height: 45px; border-radius: 50%;">
                        <div class="pl-3">
                            <a href="{{ url('/pages', $item->username) }}" class="text-decoration-none"
                                style="font-size: 1.1rem; color: #3ABEFE; margin-left: 10px;">
                                {{ $item->name }}</a>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

        {{-- <a href="{{ url('/pages/create') }}" class="d-block text-white mt-3">
            <i class="fas fa-plus"></i>
            <span class="ms-2">
                Create your Page
            </span>
        </a>

        <a href="{{ url('/pages') }}" class="d-block text-white mt-3">
            <i class="fas fa-user"></i>
            <span class="ms-2">
                Your Pages
            </span>
        </a>

        <a href="{{ url('/streaming') }}" class="d-block text-white mt-3">
            <i class="fas fa-video"></i>
            Live Streaming
        </a> --}}
    </div>
@endauth
