@extends('app')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="container-fluid">
    <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2 mb-3">
        <select name="role" class="form-select w-auto">
            <option value="">-- All role --</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="author" {{ request('role') === 'author' ? 'selected' : '' }}>Author</option>
            <option value="reader" {{ request('role') === 'reader' ? 'selected' : '' }}>Reader</option>
        </select>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Tìm tên hoặc email...">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>
    <h3 style="font-weight: bold" class="text-center mb-4">Users Management</h3>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>
                    <a class="text-white" href="{{ route('users.index', queryAscDesc('name_sort')) }}">
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
                <th>Email</th>
                <th>Role</th>
                <th>
                    <a class="text-white" href="{{ route('users.index', queryAscDesc('join_date_sort')) }}">
                        Joined at
                        @if(request('join_date_sort') === 'asc')
                            <i class="fa-solid fa-down-long"></i>
                        @elseif(request('join_date_sort') === 'desc')
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
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $users->firstItem() + $loop->index }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge bg-{{ $roleColors[$user->role] ?? 'secondary' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="text-center">
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-eye"></i> Show
                    </a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block"
                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection
