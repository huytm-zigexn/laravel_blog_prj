@extends('app')

@section('title', 'Liked Posts List')

@section('content')
    <h1 class="text-center mb-5" style="font-weight: bold; font-size: 35px; margin-top: 80px">Favorite Posts</h1>
    <div class="row" style="margin: 20px">
        @foreach ($posts as $post)
            <div class="col" style="margin-bottom: 30px; max-width: 400px;">
                <div class="card h-40 shadow-sm border-0 rounded-4 overflow-hidden" style="min-height: 400px;">
                    @if ($post->medias()->first())
                        <img src="{{ asset($post->medias()->first()->file_path) }}" class="card-img-top" alt="{{ $post->title }}">
                    @endif
                    <form style="margin: auto" action="{{ route('likes.store', $post->slug) }}" method="POST">
                        @csrf
                        @php 
                            $hasLiked =  \App\Models\Like::where('post_id', $post->id) 
                                ->where('user_id', Auth::id())->exists();
                        @endphp
                        <button
                            class="{{ $hasLiked ? 'liked' : '' }}"
                            style="border-radius: 20px; padding: 8px 10px; margin-top: 10px;"
                        >
                            <i style="font-size: 30px" class="fa-solid fa-heart"></i>
                        </button>
                    </form>
                    <div class="card-body">
                        <p style="margin: 0">Published at: {{ $post->published_at }}</p>
                        <h5 class="card-title" style="font-weight: 500">{{ $post->title }}</h5>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center bg-white border-0">
                        <div class="social_icon d-flex gap-2" style="padding: 20px 0">
                            <a href="#"><img src="{{ asset('images/fb-icon.png') }}" width="28" height="28" /></a>
                            <a href="#"><img src="{{ asset('images/twitter-icon.png') }}" width="28" height="28" /></a>
                            <a href="#"><img src="{{ asset('images/instagram-icon.png') }}" width="28" height="28" /></a>
                        </div>
                        <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection