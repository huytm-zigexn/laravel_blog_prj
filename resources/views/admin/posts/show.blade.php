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
        </div>
    </div>
</div>
@endsection