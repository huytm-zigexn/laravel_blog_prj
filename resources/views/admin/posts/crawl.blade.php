<!-- resources/views/posts/create.blade.php -->
@extends('app')

@section('title', 'Create Post')

@section('content')
    <div class="container">
        @include('partials.arrowBack')
        @livewire('post-crawler-form')
    </div>
@endsection