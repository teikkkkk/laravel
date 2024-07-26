<!-- resources/views/auth/change-password.blade.php -->

@extends(' app')

@section('content')
<div class="container">
    <h2>Thay đổi mật khẩu</h2>

    <!-- Hiển thị thông báo lỗi nếu có -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Hiển thị thông báo thành công nếu có -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('change-password') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="current_password">Mật khẩu cũ</label>
            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
            @error('current_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Mật khẩu mới -->
        <div class="form-group">
            <label for="new_password">Mật khẩu mới</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
            @error('new_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Xác nhận mật khẩu mới -->
        <div class="form-group">
            <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation" required>
            @error('new_password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Thay đổi mật khẩu</button>
    </form>
</div>
@endsection
