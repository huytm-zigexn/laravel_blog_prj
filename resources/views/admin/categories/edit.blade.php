@extends('app')

@section('title', 'Edit Category')

@section('content')
    <div class="container">
        @include('partials.arrowBack')
        <h1 style="font-weight: bold" class="text-center">Edit Category</h1>
        @include('partials.adminCategory')
    </div>
@endsection