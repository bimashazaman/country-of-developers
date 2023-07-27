@extends('admin.layouts.auth')

@section('content')
    <div class="col py-3">
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Name</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('profile.index', $item->id) }}">
                                    <img src=@if ($item->avatar) {{ asset('avatars/' . $item->avatar) }}
                                        @else "https://ui-avatars.com/api/?name={{ $item->name }}&&background=0D8ABC&color=fff" @endif
                                        class="rounded-circle" width="50" height="50" alt="">
                                </a>

                                <div class="ms-3">
                                    <p class="fw-bold mb-1"><a href="{{ route('profile.index', $item->id) }}"
                                            class="text-decoration-none"
                                            style='font-size: 1.1rem; margin-left: 10px; color: #3ABEFE;'>
                                            <span>{{ $item->username }}</span>
                                        </a></p>
                                    <p class="text-muted mb-0">{{ $item->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p>
                                {{ $item->created_at->diffForHumans() }}
                            </p>
                        </td>
                        <td>
                            <form action="{{ route('admin.users.destroy', $item) }}" method="POST">
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
