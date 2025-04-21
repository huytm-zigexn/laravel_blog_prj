@extends('app')

@section('title', 'Posts Management')

@section('content')
<div class="container">
    @include('partials.arrowBack')
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="margin: 50px 0">
                <div class="card-header">Update post</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div style="color: red;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.posts.update', $post->slug) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" class="form-control form-select">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $post->category_id === $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control form-select">
                                <option value="">Select a status</option>
                                @foreach ($status as $statusItem)
                                    <option value="{{ $statusItem }}" {{ $post->status === $statusItem ? 'selected' : '' }}>
                                        {{ $statusItem }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_id">Author</label>
                            <select name="user_id" class="form-control form-select">
                                <option value="">Select an author</option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}" {{ $post->user_id === $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tags[]">Tag</label>
                            <select name="tags[]" class="form-select" multiple>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" class="myeditorinstance">{!! old('content', $post->content) !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail</label><br>
                            <input value="{{ $post->thumbnail }}" type="file" name="thumbnail"><br>
                            @if($post->thumbnail)
                                <img src="{{ asset($post->thumbnail) }}" alt="Thumbnail" style="max-width: 200px;"><br><br>
                            @endif
                        </div>
                        <input type="submit" class="btn btn-success" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection