@extends('app')

@section('title', 'All Posts')

@section('content')
<div style="margin: 40px">
    <h1 class="text-center mb-5" style="font-weight: bold; font-size: 35px; margin-top: 80px">All Posts</h1>
    <form action="{{ route('user.posts.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by title"
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="categoryId" class="form-select form-control">
                <option value="">-- Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('categoryId') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="tagIds[]" class="form-control" multiple>
                <option value="">-- Tag --</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}"
                        {{ collect(request('tagIds'))->contains($tag->id) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>        
        </div>

        <div class="gap-2">
            <button class="btn btn-primary" type="submit">Submit</button>
            <a class="btn btn-primary" href="{{ route('user.posts.index') }}">Clear filter</a>
        </div>
    </form>
    <div class="row row-cols-5">
        @if ($posts->count() <= 0)
            <h1>Can't find suitable blogs</h1>
        @else
            @foreach ($posts as $post)
                <div class="col" style="margin-bottom: 30px; max-width: 400px;">
                    <div class="card h-40 shadow-sm border-0 rounded-4 overflow-hidden" style="min-height: 400px;">
                        @include('partials.postCard', ['post' => $post])
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection
