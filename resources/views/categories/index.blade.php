@extends('app')

@section('content')
<div class="container">
    <h2>Danh sách sản phẩm</h2>
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="mt-2 mb-3">
        <a class="btn btn-success" href="{{ route('categories.create') }}">Thêm sản phẩm mới</a>
    </div>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Ngày nhập hàng</th>
            <th>Hành động</th>
        </tr>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->price }}</td>
            <td>{{ $category->entry_date }}</td>
            <td>
                <a class="btn btn-info" href="{{ route('categories.edit', $category->id) }}">Chỉnh sửa</a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
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
