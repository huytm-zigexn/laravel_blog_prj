@extends('app')

@section('title', 'Edit Tag')

@section('content')
    <div class="container">
        @include('partials.arrowBack')
        <h1 style="font-weight: bold" class="text-center">Edit Tag</h1>
        @include('partials.adminTag')
    </div>
@endsection