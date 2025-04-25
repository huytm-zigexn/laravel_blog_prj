@extends('app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-4">
        <div class="row" style="margin-bottom: 100px">
            @livewire('posts-quantity-card')
            @livewire('categories-quantity-card')
            @livewire('tags-quantity-card')
            @livewire('most-popular-post-card')
            @livewire('most-popular-category-card')
        </div>
        <div class="row d-flex" style="margin-bottom: 100px">
            @livewire('users-quantity-chart')
        </div>
        <div class="row d-flex" style="margin-bottom: 100px">
            @livewire('posts-origin-crawl-chart')
        </div>
        <div class="row" style="margin-bottom: 100px">
            @livewire('post-views-chart')
        </div>
        <div class="row" style="margin-bottom: 100px">
            @livewire('crawled-post-views-by-source-name-chart')
        </div>
        <div class="row" style="margin-bottom: 100px">
            @livewire('posts-quantity-by-publish-chart')
        </div>
        <div class="row" style="margin-bottom: 100px">
            @livewire('top10-posts-by-likes-comments-chart')
        </div>
        <div class="row" style="margin-bottom: 100px">
            @livewire('users-quantity-filter-chart')
        </div>
    </div> 
@endsection