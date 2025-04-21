@extends('app')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="container-fluid">
    <h3 style="font-weight: bold" class="text-center mb-4">Users Management</h3>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined at</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
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
</div>
@endsection
