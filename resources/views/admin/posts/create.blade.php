<!-- resources/views/posts/create.blade.php -->
@extends('app')

@section('title', 'Create Post')

@section('content')
    <div class="container">
        @include('partials.arrowBack')
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="margin: 50px 0">
                    <div class="card-header">Create new post</div>
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
                        <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-select">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach 
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="user_id">Author</label>
                                <select name="user_id" class="form-select">
                                    <option value="">Select an author</option>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}">
                                            {{ $author->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <label for="tags[]">Tag</label>
                                <select name="tags[]" class="form-select" multiple>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea name="content" class="myeditorinstance"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="thumbnail">Thumbnail</label><br>
                                <input type="file" name="thumbnail" required>
                            </div>

                            <input type="submit" name="status" class="btn btn-primary" value="Save draft">
                            <input type="submit" name="status" class="btn btn-success" value="Publish">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection