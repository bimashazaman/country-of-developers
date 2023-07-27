@foreach ($comment->replies as $reply)
    <div class=" d-flex align-items-right" style="margin-left: 2%">
        <div class="comment-avatar">
            <img src="https://ui-avatars.com/api/?name={{ $reply->user->name }}&background=0D8ABC&color=fff"
                alt="avatar" class="rounded-circle mx-2 mt-3" width="50">
        </div>
        <div style='background-color: #161c2d;  width: 100%' class="card p-3 m-3 rounded-lg">

            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex flex-row align-items-center">

                    <div class="comment-details ml-2">
                        <h6 class="m-0">{{ $reply->user->name }}</h6>
                        <span class="text-muted">{{ $reply->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                {{-- @include('comments.partials.replyActions') --}}
            </div>
            <div class="comment-body mt-3 text-start">
                <p>{{ $reply->reply }}</p>
            </div>
        </div>
    </div>
@endforeach
