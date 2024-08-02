@extends('app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa thông tin người dùng</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form chỉnh sửa thông tin người dùng -->
    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" id="name" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" id="phone">
        </div>
        <div class="form-group">
            <label for="birthdate">Ngày sinh:</label>
            <input type="date" name="birthdate" value="{{ old('birthdate', $user->birthdate) }}" class="form-control" id="birthdate">
        </div>
        <div class="form-group">
            <label for="gender">Giới tính:</label>
            <select name="gender" class="form-control" id="gender">
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>

    <!-- Form gán vai trò cho người dùng -->
    <div class="mt-4">
        <h3>Gán vai trò</h3>
        <form action="{{ route('user.assignRole', $user->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="role">Vai trò:</label>
                <select name="role" id="role" class="form-control">
                    <option value="">Chọn vai trò</option>
                    <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                    <option value="mod" {{ $user->hasRole('mod') ? 'selected' : '' }}>Mod</option>
                    <option value="customer" {{ $user->hasRole('customer') ? 'selected' : '' }}>Customer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Gán vai trò</button>
        </form>
    </div>
</div>
@endsection
