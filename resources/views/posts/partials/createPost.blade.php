<div class="card mb-2 rounded-lg" style="background-color: #192235; padding: 10px;">
    <div class="d-flex w-100 px-3" style="border-radius: 50px;">
        <div class="pr-3 py-3">
            <img src=@if (auth()->user()->avatar) "{{ asset('avatars/' . auth()->user()->avatar) }}"
                                        @else "https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D8ABC&color=fff" @endif
                class="rounded-circle" width="50" height="50" alt="">
        </div>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="w-100">
            @csrf
            <div class="d-flex w-100 justify-content-between">
                <div class="w-100 px-2">
                    <div class="font-weight-bold d-flex align-items-center py-3">
                        <input type="text" class="form-control" placeholder="Write here something..."
                            style="background-color: transparent; color: #3ABEFE; border: 'white'; font-size: 1.1rem; border-radius: 50px; border: 2px solid rgb(174, 173, 173); width: 95%;"
                            name="caption">
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <button class="btn btn-sm btn-outline-secondary"
                                    style="color: #3ABEFE; font-size: 1.1rem; display: none;">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href={{ route('posts.create') }} class=" text-decoration-none"
                                style="color: #3ABEFE; font-size: 1.6rem; margin-left: 10px;">
                                <i class="far fa-images"></i>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
</div>
