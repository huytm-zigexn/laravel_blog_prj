@extends('app')

@section('title', 'Chỉnh sửa người dùng')

@section('content')
<div class="container py-4">
    @include('partials.arrowBack')
    <h2 class="mb-4">Chỉnh sửa người dùng</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Họ tên</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
            </div>

            <div class="col-md-6">
                <label for="role" class="form-label">Vai trò</label>
                <select class="form-select" name="role" id="role">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
                    <option value="reader" {{ $user->role === 'reader' ? 'selected' : '' }}>Reader</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Ảnh đại diện</label><br>
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-2" width="80" height="80">
            @endif
            <input type="file" class="form-control" name="avatar" id="avatar">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu (để trống nếu không thay đổi)</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-1"></i> Cập nhật
            </button>
        </div>
    </form>
</div>
@endsection
