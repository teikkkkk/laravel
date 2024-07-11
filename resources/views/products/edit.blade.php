<!-- resources/views/products/edit.blade.php -->
@extends('app')

@section('content')
<div class="container">
    <h1>Chỉnh sửa sản phẩm</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" id="name" required>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="text" name="price" value="{{ old('price', $product->price) }}" class="form-control" id="price">
            
        </div>
        <div class="form-group">
            <label for="entry_date">Ngày nhập hàng:</label>
            <input type="date" name="entry_date" value="{{ old('entry_date', $product->entry_date) }}" class="form-control" id="entry_date">
            
        </div>
        <div class="form-group">
            <label for="quantity">Số lượng</label>
            <input type="text" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="form-control" id="quantity">
            
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Loại sản phẩm</label>
            <select class="form-control" id="type" name="type">
                <option value="">Select type</option>
                <option value="áo">Áo</option>
                <option value="quần">Quần</option>
                <option value="phụ kiện">Phụ kiện</option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Ảnh đại diện hiện tại:</label>
            @if ($product->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $product->image) }}" style="max-width: 200px;" alt="Current Product Image">
                </div>
            @else
                <p>No image</p>
            @endif
            <label for="image">Chọn ảnh mới:</label>
            <input type="file" name="image" class="form-control-file" id="image">
            @error('image')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection