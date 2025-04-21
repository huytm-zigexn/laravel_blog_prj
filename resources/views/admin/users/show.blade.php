@extends('app')

@section('title', 'Thông tin cá nhân')

@section('content')
    <div class="container py-5">
        <a href="{{ route('users.index') }}">
            <i style="font-size: 24px; margin-bottom: 14px" class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="row">
            <div class="col-md-12">

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

                        <div class="ps-3">
                            <p><strong>Phone number:</strong> {{ $user->phone }}</p>
                            <p><strong>Role:</strong> <span class="badge bg-primary text-uppercase" style="color: #fff">{{ $user->role }}</span></p>
                            <p><strong>Joined from:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
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

