@extends('app')

@section('content')
<div class="container">
    <h1>Tạo mới sản phẩm</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Các trường thông tin sản phẩm khác -->
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name" required>
        </div>

        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="text" name="price" value="{{ old('price') }}" class="form-control" id="price" required>
        </div>

        <div class="form-group">
            <label for="entry_date">Ngày nhập hàng:</label>
            <input type="date" name="entry_date" value="{{ old('entry_date') }}" class="form-control" id="entry_date" required>
        </div>

        <div class="form-group">
            <label for="category_id">Danh mục:</label>
            <select name="category_id" class="form-control" id="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Số lượng:</label>
            <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control" id="quantity" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea name="description" class="form-control" id="description" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Ảnh đại diện:</label>
            <input type="file" name="image" class="form-control-file" id="image" required>
        </div>



        <div class="form-group">
            <label for="images">Ảnh khác:</label>
            <input type="file" name="images[]" class="form-control-file" id="images" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Tạo mới</button>
    </form>
</div>
@endsection
