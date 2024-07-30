@extends('app')

@section('content')
<div class="container">
    <h2>Danh sách người dùng</h2>
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered mt-2">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>SĐT</th>
            <th>Giới tính</th>
            <th>BirthDate</th>
            <th>Vai trò</th>
            <th>Hành động</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->gender }}</td>
            <td>{{ $user->birthdate }}</td>
            <td>
                @foreach ($user->roles as $role)
                    <span class="mb-3">{{ $role->name }}</span>
                @endforeach
            </td>
            <td>
                <a class="btn btn-info" href="{{ route('user.edit', $user->id) }}">Chỉnh sửa</a>
                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection