@extends('app')

@section('title', 'Thông tin cá nhân')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4">

                @if(session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center">

                        {{-- Avatar --}}
                        @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="Avatar" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=150" 
                                class="rounded-circle mb-3" alt="Avatar">
                        @endif

                        <h3 class="">{{ $user->name }}</h3>
                        <p style="margin: 0" class="text-muted">{{ $user->email }}</p>

                        <div style="margin-bottom: 20px; display: flex; justify-content: center">
                            <p style="color: #808080; font-weight: 500">{{ $user->posts->count() }} <br> posts</p>
                            <button style="background-color: transparent; color: #808080; font-weight: 500" class="btn" onclick="toggleFollowersModal()">
                                {{ $user->followers->count() }} <br>
                                Followers
                            </button>
                            
                            <button style="background-color: transparent; color: #808080; font-weight: 500" class="btn" onclick="toggleFollowingsModal()">
                                {{ $user->followings->count() }} <br>
                                Following
                            </button>
                        </div>

                        @if (Auth::user()->id !== $user->id)
                            <form action="{{ route('user.follow', $user->id) }}" method="post">
                                @csrf
                                <button 
                                    onclick="toggleFollow({{ $user->id }})" 
                                    id="follow-button-{{ $user->id }}" 
                                    class="btn {{ auth()->user()->isFollowing($user->id) ? 'btn-danger' : 'btn-primary' }}"
                                >
                                    {{ Auth::user()->isFollowing($user->id) ? 'Unfollow' : 'Follow' }}
                                </button>
                            </form>
                        @endif

                        <hr class="my-4">

                        <div class="text-start ps-3">
                            <p><strong>Phone number:</strong> {{ $user->phone }}</p>
                            <p><strong>Role:</strong> <span class="badge bg-primary text-uppercase" style="color: #fff">{{ $user->role }}</span></p>
                            <p><strong>Joined from:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                        </div>

                        @if ($user->id === Auth::id())
                            <div>
                                <a href="{{ route('user.edit', Auth::id()) }}" class="btn btn-outline-primary mt-3">Edit profile</a>
                                <a href="{{ route('user.editPassword', Auth::id()) }}" class="btn btn-outline-primary mt-3">Change password</a>
                            </div>
                            <form action={{ route('logout') }} method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger" style="margin-top: 20px">Logout</button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-md-8">
                <div class="d-flex align-items-center mb-4" style="justify-content: space-between">
                    <h3>{{ $user->name }}'s posts</h3>
                    @if (notReader(Auth::user()) && Auth::id() === $user->id)
                        <a style="" class="btn btn-primary" href="{{ route(Auth::user()->role . '.posts.create') }}">Create post</a>
                    @endif
                </div>
                <div style="max-height: 600px; overflow-y: auto;">
                    @if ($user->posts->count() > 0)
                        @foreach ($user->posts as $post)
                            <div class="card mb-3 shadow-sm border-0 rounded-3">
                                <div class="card-body">
                                    <h3 class="card-title">{{ $post->title }}</h3>
                                    <div class="d-flex align-items-center" style="justify-content: space-between">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-outline-primary">Read more</a>
                                        <div class="d-flex">
                                            @if (notReader(Auth::user()) && Auth::id() === $user->id)
                                                @if ($post->status === 'draft')
                                                    <form style="margin-right: 10px" action="{{ route(Auth::user()->role . '.posts.publish', $post->slug) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input class="btn btn-outline-primary" type="submit" value="Publish post">
                                                    </form>
                                                @endif
                                                <form style="margin-right: 10px" action="{{ route(Auth::user()->role . '.posts.edit', $post->slug) }}" method="GET">
                                                    @csrf
                                                    <input class="btn btn-outline-success" type="submit" value="Update post">
                                                </form>
                                                <form action="{{ route(Auth::user()->role . '.posts.delete', $post->slug) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input class="btn btn-outline-danger" type="submit" value="Delete post">
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Người dùng này chưa đăng bài viết nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials/followersModal')
    @include('partials/followingsModal')
@endsection

<script>
    function toggleFollowersModal() {
        const modal = new bootstrap.Modal(document.getElementById('followersModal'));
        modal.toggle();
    }

    // Followings Modal
    function toggleFollowingsModal() {
        const modal = new bootstrap.Modal(document.getElementById('followingsModal'));
        modal.toggle();
    }
</script>

