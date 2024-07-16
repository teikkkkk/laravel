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
            <input type="text" name="price" value="{{ old('price', $product->price) }}" class="form-control" id="price" required>
        </div>

        <div class="form-group">
            <label for="entry_date">Ngày nhập hàng:</label>
            <input type="date" name="entry_date" value="{{ old('entry_date', $product->entry_date) }}" class="form-control" id="entry_date" required>
        </div>

        <div class="form-group">
            <label for="category_id">Danh mục:</label>
            <select name="category_id" class="form-control" id="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Số lượng:</label>
            <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="form-control" id="quantity" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea name="description" class="form-control" id="description" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái:</label>
            <select name="status" class="form-control" id="status" required>
                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Còn hàng</option>
                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Hết hàng</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Ảnh đại diện:</label>
            <input type="file" name="image" class="form-control-file" id="image">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-thumbnail mt-2" style="height: 100px;">
            @endif
        </div>

        <div class="form-group">
            <label for="images">Ảnh khác:</label>
            <input type="file" name="images[]" class="form-control-file" id="images" multiple>
            @if ($product->images)
                <div class="mt-2">
                    @foreach ($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image) }}" alt="Additional Image" class="img-thumbnail" style="height: 100px;">
                    @endforeach
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
