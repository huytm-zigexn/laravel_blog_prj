@extends('app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0 rounded-4">
                @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header bg-white border-bottom-0">
                    <h4 class="mb-0">Chỉnh sửa thông tin</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', Auth::id()) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar</label><br>
                            @if ($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="Avatar" class="rounded mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                            <input type="file" name="avatar" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('user.show', Auth::id()) }}" class="btn btn-secondary">Hủy</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
