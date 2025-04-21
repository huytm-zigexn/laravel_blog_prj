@extends('app')

@section('title', 'Reset Password')

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
                    <h4 class="mb-0">Reset Password</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.updatePassword', Auth::id()) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Old password</label>
                            <input class="form-control" type="password" name="old_password" placeholder="Enter your old password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New password</label>
                            <input class="form-control" type="password" name="password" placeholder="Enter new password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Password confirmation</label>
                            <input class="form-control" type="password" name="password_confirmation" placeholder="Re-enter new password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('user.show', Auth::id()) }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
