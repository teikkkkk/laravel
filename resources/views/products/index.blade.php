@extends('app')

@section('content')
<div class="container">

    <h2>Danh sách sản phẩm</h2>
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <h4>lỗi upload</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('products.export') }}" class="btn btn-success">Tải xuống CSV</a>
    </div>
    <form action="{{ route('products.upload') }}" method="POST" role="form" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="">Chọn file</label>
            <input type="file" class="form-control" name="csvfile" placeholder="Input field">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form> 
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
            <td>{{ $product->category->name }}</td>
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
    <div class="d-flex justify-content-center">
        {{ $products->links('pagination.custom') }}
    </div>

</div>
@endsection
