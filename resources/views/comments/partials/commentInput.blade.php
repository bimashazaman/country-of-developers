  <div
      style="width: 100%; border: none; border-radius: 0; height: 10%; color: white; font-size: 18px; font-weight: 600; cursor: pointer;">
      <div class="row mt-4">
          <div class="col-md-12">
              <form action="{{ route('comments.store', $post) }}" method="POST" enctype="multipart/form-data"
                  style="" x-data="{ media: '', video: '', location: '', friends: [] }" class='w-100'>
                  @csrf
                  <div class=" w-100">
                      <div class="d-flex w-100">
                          <div class="mr-3">
                              <label for="media"
                                  style="cursor: pointer; color: #3ABEFE; font-size: 1rem; margin-left: 10px; border: 1px solid #757677; border-radius: 20px; padding: 5px 10px; background-color: #141A29;">
                                  <i class="fas fa-image"></i>
                              </label>
                              <input id="media" type="file" name="media[]" multiple="multiple"
                                  class="form-control-file @error('media') is-invalid @enderror"
                                  x-on:change="media = $event.target.files[0]" style="display: none;">
                              @error('media')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          <div class="w-100">
                              <div class="form-group px-3 w-100 d-flex">
                                  <textarea name="comment" id="comment"
                                      style="background-color: #141A29; color: #3ABEFE; border: 1px solid #757677; border-radius: 20px; width: 100%;"
                                      class="px-3 py-2" placeholder="Type your comment"></textarea>
                                  <button type="submit" class="btn btn-link p-0 fs-4"
                                      style="color: #3ABEFE; margin-left: 10px;">
                                      <i class="fas fa-paper-plane"></i>
                                  </button>
                              </div>
                              @error('comment')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                      <br>
                      <div class="form-group px-5" x-data="{ show: false }">

                          <div class="mt-2" x-show="media" x-cloak>
                              <div x-show="media.type.includes('image')">
                                  <img :src="URL.createObjectURL(media)" class="img-fluid" alt="Responsive image">
                              </div>
                              <div x-show="media.type.includes('video')">
                                  <video :src="URL.createObjectURL(media)" controls class="img-fluid"
                                      alt="Responsive image"></video>
                              </div>
                              <div class="mt-2">
                                  <button type="button"
                                      style='
                                            background-color: #fff;
                                            border: 1px solid #ced4da;
                                            border-radius: .25rem;
                                            padding: .375rem .75rem;
                                            font-size: 1rem;
                                            line-height: 1.5;
                                            color: #495057;
                                            background-color: #fff;
                                            background-clip: padding-box;
                                            border: 1px solid #ced4da;
                                            border-radius: .25rem;
                                            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                                            '
                                      x-on:click="media = ''">
                                      <i class="fas fa-trash"></i>
                                  </button>
                              </div>
                          </div>
                      </div>
                      <br>
                      <br>
              </form>
          </div>
      </div>
  </div>
