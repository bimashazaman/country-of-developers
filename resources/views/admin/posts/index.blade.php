@extends('admin.layouts.auth')

@section('content')
    <div class="col py-3">
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>
                        Creator name
                    </th>
                    <th>
                        Post Caption
                    </th>
                    <th>
                        Media
                    </th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('profile.index', $post->user->id) }}">
                                    <img src=@if ($post->user->avatar) {{ asset('avatars/' . $post->user->avatar) }}
                                        @else "https://ui-avatars.com/api/?name={{ $post->user->name }}&&background=0D8ABC&color=fff" @endif
                                        class="rounded-circle" width="50" height="50" alt="">
                                </a>

                                <div class="ms-3">
                                    <p class="fw-bold mb-1"><a href="{{ route('profile.index', $post->user->id) }}"
                                            class="text-decoration-none"
                                            style='font-size: 1.1rem; margin-left: 10px; color: #3ABEFE;'>
                                            <span>{{ $post->user->name }}</span>
                                        </a>
                                    </p>
                                    <p class="text-muted mb-0">{{ $post->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="fw-normal mb-1">
                                {{ $post->caption }}
                            </p>
                        </td>

                        <td>
                            <center>
                                @if ($post->media)
                                    @if (Str::endsWith($post->media, '.mp4') ||
                                            Str::endsWith($post->media, '.mov') ||
                                            Str::endsWith($post->media, '.avi') ||
                                            Str::endsWith($post->media, '.wmv') ||
                                            Str::endsWith($post->media, '.flv') ||
                                            Str::endsWith($post->media, '.mkv'))
                                        <video controls class="card-img-top">
                                            <source src="{{ asset('uploads/' . $post->media) }}" type="video/mp4"
                                                style="width: 50%; height: 200px; object-fit: cover;" class="card-img-top">
                                        </video>
                                    @else
                                        <img src="{{ asset('uploads/' . $post->media) }}"
                                            style="width: 50%; height: 200px; object-fit: cover;" class="card-img-top"
                                            alt="...">
                                    @endif
                                @endif
                            </center>
                        </td>
                        <td>
                            <p>
                                {{ $post->created_at->diffForHumans() }}
                            </p>
                        </td>
                        <td>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-secondary  m-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
