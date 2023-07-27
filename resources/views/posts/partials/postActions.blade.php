 {{-- <div>
     @if ($post->likes->contains('user_id', auth()->user()->id))
         <a href="{{ route('who-liked', $post->id) }}" class="text-decoration-none"
             style="font-size: 0.8rem; color: #939494; margin-left: 10px;">
             <i class="fas fa-thumbs-up" style="color: #0D8ABC; margin-right: 10px"></i>
             @if ($post->likes->count() > 1)
                 You and {{ $post->likes->count() - 1 }} other people
             @else
                 {{ $post->likes->count() }} person
             @endif
         </a>
     @else
         @if ($post->likes->count() > 0)
             <a href="{{ route('who-liked', $post->id) }}" class="text-decoration-none"
                 style="font-size: 0.8rem; color: #939494; margin-left: 10px;">
                 {{ $post->likes->count() }} people likes
             </a>
         @else
             <div></div>
         @endif
     @endif
 </div> --}}

 <div class="d-flex  w-100 mb-2 mt-3" x-data="{ showPopup: false }">
     <div class="d-flex w-100 px-4">

         <div class="pr-3" style=" margin-right: 30px">
             <form
                 action=@if ($post->likes->contains('user_id', auth()->user()->id)) "{{ route('posts.unlike', $post) }}"
                                        @else
                                             "{{ route('posts.likes', $post) }}" @endif
                 method="POST" class="d-inline">

                 @csrf
                 @method('POST')
                 <button type="submit" class="btn btn-link text-decoration-none p-0 m-0"
                     style="font-size: 1.3rem; margin-left: 10px; color: #3ABEFE;" onclick="saveScrollPosition()">
                     @if ($post->likes->contains('user_id', auth()->user()->id))
                         <i class="fas fa-thumbs-up" style="color: #0D8ABC;"></i>
                     @else
                         <i class="far fa-thumbs-up"></i>
                     @endif
                 </button>
                 <p class="d-inline text-white text-decoration-none">
                     {{ $post->likes->count() }}</p>
             </form>
         </div>
         <div class="pr-3" style=" margin-right: 30px">
             <a href="{{ route('comments.index', $post) }}" class="text-decoration-none"
                 style="font-size: 1.2rem; margin-left: 10px; color: #3ABEFE;">
                 <i class="far fa-comment"></i>
                 <p class="d-inline text-white text-decoration-none" style="font-size: 1rem">
                     {{ $post->comments->count() }}
                 </p>
             </a>
         </div>

         <div class="pr-3">
             <div class="text-decoration-none" style="font-size: 1.2rem; margin-left: 5px; color: #3ABEFE;">
                 <i class="far fa-paper-plane" @click="showPopup = !showPopup" @click.away="showPopup = false"></i>
                 <span class="text-white text-decoration-none" style=" font-size: 1rem">Share</span>
             </div>

         </div>

     </div>
     <div x-show="showPopup"
         style="position: absolute; z-index: 10; border-radius: 10px; width: 200px; height: 200px; margin-left: 50px; margin-top: 10px; display: flex; align-items: center; justify-content: center;">
         <div class="card"
             style="background-color: #192235; border: 1px solid white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0,0,0,0.1);"
             x-cloak>
             {!! Share::page(route('posts.show', $post), $post->title, [
                 'style' => 'font-size: 1.3rem; margin: 10px; color: #3ABEFE; padding: 5px 10px;',
                 'class' => 'btn btn-link text-decoration-none text-white',
             ])->facebook() !!}
             {!! Share::page(route('posts.show', $post), $post->title, [
                 'style' => 'font-size: 1.3rem; margin: 10px; color: #3ABEFE; padding: 5px 10px;',
                 'class' => 'btn btn-link text-decoration-none text-white',
             ])->linkedin() !!}
             {!! Share::page(route('posts.show', $post), $post->title, [
                 'style' => 'font-size: 1.3rem; margin: 10px; color: #3ABEFE; padding: 5px 10px;',
                 'class' => 'btn btn-link text-decoration-none text-white',
             ])->twitter() !!}
             {!! Share::page(route('posts.show', $post), $post->title, [
                 'style' => 'font-size: 1.3rem; margin: 10px; color: #3ABEFE; padding: 5px 10px;',
                 'class' => 'btn btn-link text-decoration-none text-white',
             ])->whatsapp() !!}
         </div>
     </div>



 </div>

 {{-- <div class="d-flex align-items-center px-2">
     @if ($post->comments->count() > 0)
         <div class="d-flex align-items-center">
             <div class="pr-3">
                 <a href="{{ route('profile.index', $post->comments->first()->user->id) }}">
                     <img src=@if ($post->comments->first()->user->avatar) {{ asset('avatars/' . $post->comments->first()->user->avatar) }}
                                    @else "https://ui-avatars.com/api/?name={{ $post->comments->first()->user->name }}&&background=0D8ABC&color=fff" @endif
                         class="rounded-circle" width="30" height="30" alt="">
                 </a>
             </div>
             <div>
                 <div class="font-weight-bold">
                     <a href="{{ route('profile.index', $post->comments->first()->user->id) }}"
                         class="text-decoration-none" style='font-size: 0.8rem; margin-left: 10px; color: #3ABEFE;'>
                         <span>{{ $post->comments->first()->user->username }}</span>
                     </a>
                 </div>
                 <div style="font-size: 0.8rem; margin-left: 10px;  color: #9da1a2;">
                     {{ $post->comments->first()->comment }}
                 </div>
             </div>
         </div>
     @endif
 </div> --}}
