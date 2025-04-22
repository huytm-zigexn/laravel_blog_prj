@extends('app')

@section('title', 'Posts Management')

@section('content')
<div class="container mt-4">
    <h4 style="font-size: 20px; font-weight: bold" class="text-center mb-4">Posts Management</h4>

    <form method="GET" action="{{ route('admin.posts.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by title"
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Status --</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="filterUserId" class="form-select">
                <option value="">-- Author --</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ request('filterUserId') == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="categoryId" class="form-select">
                <option value="">-- Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('categoryId') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <select name="tagIds[]" class="form-select" multiple>
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}"
                    {{ collect(request('tagIds'))->contains($tag->id) ? 'selected' : '' }}>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>        

        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    </form>

    <a style="margin-bottom: 20px" class="btn btn-primary" href="{{ route('admin.posts.create') }}">Create post</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No. </th>
                    <th class="w-25">
                        <a href="{{ route('admin.posts.index', queryAscDesc('title_sort')) }}">
                            Title
                            @if(request('title_sort') === 'asc')
                                <i class="fa fa-sort-alpha-down ms-1"></i>
                            @elseif(request('title_sort') === 'desc')
                                <i class="fa fa-sort-alpha-up ms-1"></i>
                            @else
                                <i class="fa fa-sort ms-1"></i>
                            @endif
                        </a>
                    </th>
                    <th>Status</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Tag</th>
                    <th>
                        <a href="{{ route('admin.posts.index', queryAscDesc('publish_date_sort')) }}">
                            Published date
                            @if(request('publish_date_sort') === 'asc')
                                <i class="fa-solid fa-down-long"></i>
                            @elseif(request('publish_date_sort') === 'desc')
                                <i class="fa-solid fa-up-long"></i>
                            @else
                                <i class="fa fa-sort ms-1"></i>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $index => $post)
                    <tr>
                        <td>{{ $posts->firstItem() + $loop->index }}</td>
                        <td class="w-25">{{ $post->title }}</td>
                        <td>
                            <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'secondary' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->category?->name ?? 'N/A' }}</td>
                        <td>
                            @foreach ($post->tags as $tag)
                                <span class="badge bg-info text-dark">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $post->published_at ? $post->published_at->format('d/m/Y') : 'Not yet published' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.posts.show', $post->slug) }}" class="btn btn-sm btn-success">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.posts.edit', $post->slug) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.posts.delete', $post->slug) }}" method="POST" class="d-inline-block"
                                  onsubmit="return confirm('Are you sure to delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection
