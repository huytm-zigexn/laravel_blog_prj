@extends('app')

@section('content')
<div class="container">
    <form method="GET" action="{{ route('admin.comments.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="postId" class="form-select">
                <option value="">-- Post --</option>
                @foreach ($posts as $post)
                    <option value="{{ $post->id }}" {{ request('postId') == $post->id ? 'selected' : '' }}>
                        {{ $post->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="userId" class="form-select">
                <option value="">-- Author --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ request('userId') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="isAllowed" class="form-select">
                <option value="">-- Status --</option>
                <option value=0 {{ request('isAllowed') == 0 ? 'selected' : '' }}>Pending</option>
                <option value=1 {{ request('isAllowed') == 1 ? 'selected' : '' }}>Approved</option>
            </select>
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    </form>
    <h2 class="my-4 text-center" style="font-weight: bold">Comment Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>No.</th>
                <th>Post</th>
                <th>User</th>
                <th>Content</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
                <tr class="text-center">
                    <td>{{ $comments->firstItem() + $loop->index }}</td>
                    <td class="w-25"><a href="{{ route('admin.posts.show', $comment->post->slug) }}" target="_blank">{{ $comment->post->title }}</a></td>
                    <td>{{ $comment->user->name ?? 'Guest' }}</td>
                    <td class="w-25">{{ $comment->content }}</td>
                    <td>
                        @if($comment->is_allowed)
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if(!$comment->is_allowed)
                        <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-sm btn-success">Approve</button>
                        </form>
                        @endif
                        <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this comment?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $comments->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection
