@extends('app')

@section('content')
<div class="container">
    <h2>Danh sách sản phẩm</h2>
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="mt-5 mb-7">
        <a class="btn btn-success" href="{{ route('products.create') }}">Thêm sản phẩm mới</a>
    </div>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Ảnh đại diện</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Ngày nhập hàng</th>
            <th>Số lượng còn lại</th>
            <th>Loại</th>
            <th>Hành động</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" style="max-width: 100px;" alt="Product Image">
                @else
                    <p>No image</p>
                @endif
            </td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->entry_date }}</td>
            <td>{{ $product->quantity - $product->sold_quantity }}</td>
            <td>{{ $product->type }}</td>
            <td>    
                <a class="btn btn-info" href="{{ route('products.edit', $product->id) }}">Chỉnh sửa</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>    
<div>   
@endsection
