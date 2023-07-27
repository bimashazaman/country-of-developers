  <li class="media mb-4 d-flex" style="margin-left: 80px;">
      <p>{{ $comment->comment }}</p>
      <div>
          <div class="">
              @if ($comment->media)
                  @if (Str::contains($comment->media, 'mp4'))
                      <video src="{{ asset('comments/' . $comment->media) }}" controls class="img-fluid"
                          alt="Responsive image"></video>
                  @else
                      <img src="{{ asset('comments/' . $comment->media) }}" style="width: 60%; margin-top: 5%"
                          class="img-fluid" alt="Responsive image">
                  @endif
              @endif
          </div>
      </div>
  </li>
  <div class="d-flex justify-content-between">
      <div class="d-flex">
          <div style="margin-left: 80px; margin-right: 10px;">
              @if ($comment->likes->contains('user_id', Auth::user()->id))
                  <form action="{{ route('comments.dislike', $comment->id) }}" method="POST"
                      class="text-decoration-none">
                      @csrf
                      <button type="submit" class="btn btn-link p-0 d-flex">
                          <div class="text-muted text-decoration-none">
                              {{ $comment->likes->count() }}
                          </div>
                          <i class="fas fa-thumbs-up" style="color: #3ABEFE; font-size: 20px; margin-left: 5px;">
                          </i>
                      </button>
                  </form>
              @else
                  <form action="{{ route('comments.like', $comment->id) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-link p-0">
                          <i class="far fa-thumbs-up" style="color: #3ABEFE; font-size: 20px;">
                          </i>
                      </button>
                  </form>
              @endif
          </div>
          <div style="margin-left: 10px;">
              {{ $comment->replies->count() }} <i class="far fa-comment" @click="open = ! open"
                  style="color: #3ABEFE; font-size: 20px;">
              </i>
          </div>


      </div>
  </div>


  <form action="{{ route('comments.reply', $comment->id) }}" method="POST" x-show="open"
      x-transition:enter="transition ease-out duration-300" class="px-lg-5">
      @csrf <div class="form-group d-flex justify-content-between">
          <br>
          <div style="width: 100%; margin-top: 10px;">
              <input type="hidden" name="post_id" value="{{ $post->id }}">
              <input name="reply" placeholder="Type your reply"
                  style="background-color: #141A29; color: #3ABEFE; width: 100%; height: 100%; outline: none; border-radius: 20px; border: 0.2px solid #999b9d; padding: 10px;"
                  required />
              @error('reply')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <button type="submit" style="background-color: transparent; border: none;">
              <i class="far fa-paper-plane" style="color: #3ABEFE; font-size: 20px; margin-left: 5px;">
              </i>
          </button>
      </div>
  </form>
