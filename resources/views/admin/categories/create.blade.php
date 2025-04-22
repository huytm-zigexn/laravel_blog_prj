@extends('app')

@section('title', 'Create Category')

@section('content')
    <div class="container">
        @include('partials.arrowBack')
        <h1 style="font-weight: bold" class="text-center">Create Category</h1>
        @include('partials.adminCategory')
    </div>
@endsection