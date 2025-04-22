@extends('app')

@section('title', 'Create Tag')

@section('content')
    <div class="container">
        @include('partials.arrowBack')
        <h1 style="font-weight: bold" class="text-center">Create Tag</h1>
        @include('partials.adminTag')
    </div>
@endsection