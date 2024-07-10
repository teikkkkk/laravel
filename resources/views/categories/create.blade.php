<!-- resources/views/categories/create.blade.php -->
@extends('app')

@section('content')
<div class="container">
    <h1>Tạo mới danh mục</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name" required>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="text" name="price" value="{{ old('price') }}" class="form-control" id="price">
            @error('price')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="entry_date">Ngày nhập hàng:</label>
            <input type="date" name="entry_date" value="{{ old('entry_date') }}" class="form-control" id="entry_date">
            @error('entry_date')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
        </div>

        <button type="submit" class="btn btn-primary">Tạo mới</button>
    </form>
</div>
@endsection
