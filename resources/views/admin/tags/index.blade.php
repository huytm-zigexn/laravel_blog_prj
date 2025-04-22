@extends('app')

@section('title', 'Tag Management')

@section('content')
<div class="container mt-4">
    <h4 class="text-center mb-4 fw-bold">Tag Management</h4>
    
    <form method="GET" action="{{ route('tags.index') }}" class="d-flex gap-2 mb-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name...">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>

    {{-- Add New Tag Button --}}
    <div class="mb-3 text-end">
        <a href="{{ route('tags.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add New tag
        </a>
    </div>

    {{-- Tag Table --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>
                        <a href="{{ route('tags.index', queryAscDesc('name_sort')) }}">
                            Name
                            @if(request('name_sort') === 'asc')
                                <i class="fa fa-sort-alpha-down ms-1"></i>
                            @elseif(request('name_sort') === 'desc')
                                <i class="fa fa-sort-alpha-up ms-1"></i>
                            @else
                                <i class="fa fa-sort ms-1"></i>
                            @endif
                        </a>
                    </th>
                    <th>Description</th>
                    <th>
                        <a href="{{ route('tags.index', queryAscDesc('created_at_sort')) }}">
                            Created At
                            @if(request('created_at_sort') === 'asc')
                                <i class="fa-solid fa-down-long"></i>
                            @elseif(request('created_at_sort') === 'desc')
                                <i class="fa-solid fa-up-long"></i>
                            @else
                                <i class="fa fa-sort ms-1"></i>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $index => $tag)
                    <tr>
                        <td>{{ $tags->firstItem() + $loop->index }}</td>
                        <td>{{ $tag->name }}</td>
                        <td>{{ $tag->description ?? 'N/A' }}</td>
                        <td>{{ $tag->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('tags.edit', $tag->slug) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('tags.destroy', $tag->slug) }}" method="POST" class="d-inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this tag?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $tags->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection
