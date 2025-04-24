@extends('app')

@section('title', 'Posts Management')

@section('content')
<div class="container">
    @include('partials.arrowBack')
    <div class="mt-5 card d-flex justify-content-center align-items-center shadow-lg border-0 rounded-4" style="max-width: 1200px; width: 100%;">
        @if ($post->thumbnail)
            <img src="{{ asset($post->thumbnail) }}" class="card-img-top rounded-top-4" alt="{{ $post->title }}">
        @endif
        <div class="card-body p-4">
            <h1 class="card-title text-center fw-bold mb-4" style="font-size: 2rem;">{{ $post->title }}</h1>
            <p class="text-muted text-center mb-3">Published at: {{ $post->published_at }}</p>
            <div class="d-flex">
                <p>Author: <a href="{{ route('user.show', $post->user_id) }}"> {{$post->user->name}}</a>
                </p>
            </div>
            <hr>
            <div class="card-text" style="font-size: 1.1rem;">
                {!! $post->content !!}
            </div>
            @if ($post->source_url)
                <a href="{{ $post->source_url }}">Source: {{$post->source_url}}</a>
            @endif
        </div>
    </div>
    <div class="mt-5">
        <h3 class="text-center mb-4">💬 Bình luận</h3>

        {{-- Form gửi bình luận --}}
        <form action="{{ route('comments.store', $post->slug) }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>

        {{-- Danh sách bình luận --}}
        @forelse($post->comments as $comment)
            @if ($comment->is_allowed == 1)
                <div class="border rounded p-3 mb-3 bg-light">
                    <strong>{{ $comment->user->name ?? 'Ẩn danh' }}</strong> 
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    <p class="mt-2 mb-0">{{ $comment->content }}</p>
                </div>
            @endif
        @empty
            <h1>Chưa có bình luận nào.</h1>
        @endforelse
    </div>
</div>
@endsection