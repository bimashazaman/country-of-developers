 <div class="d-flex justify-content-between">
     <div class="d-flex">
         <img src=@if ($comment->user->avatar) {{ asset('avatars/' . $comment->user->avatar) }} @else
                                https://ui-avatars.com/api/?name={{ $comment->user->name }}&background=0D8ABC&color=fff @endif
             class="mr-3 rounded-circle" alt="{{ $comment->user->name }}" width="64" height="64">
         <div>
             <h5 class="mt-0 mb-1 align-self-center" style="margin-left: 10px;">
                 {{ $comment->user->name }}</h5>
             <p class="text-muted" style="margin-left: 10px;">
                 {{ $comment->created_at->diffForHumans() }}</p>
         </div>
     </div>
     @if ($comment->user_id == Auth::user()->id)
         <div class="d-flex">
             <div class="mr-3">
                 <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-link p-0">
                         <i class="far fa-trash-alt" style="color: #3ABEFE; font-size: 20px;">
                         </i>
                     </button>
                 </form>
             </div>
             <div style='margin-left: 10px;'>
                 <i class="far fa-edit" style="color: #3ABEFE; font-size: 20px;">
                 </i>
             </div>
         </div>
     @endif
 </div>
