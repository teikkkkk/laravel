@extends('app')

@section('content')
    <div class="container">
        <h1 class="my-4">{{ $product->name }}</h1>
        <div class="row">
            <div class="col-md-6">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail" alt="Product Image">
                @else
                    <div class="img-thumbnail" style="height: 300px; width: auto; background-color: #eee;"></div>
                @endif
                
                <h5 class="mt-3">Hình ảnh khác:</h5>
                <div class="row">
                    @foreach ($product->images as $image)
                        <div class="col-4">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" alt="Product Image" style="height: 150px; width: auto;">
                        </div>
                    @endforeach
                </div>
                
            </div>
            <div class="col-md-6">
                <h3>Thông tin chi tiết</h3>
                <p><strong>Giá:</strong> {{ number_format($product->price) }}đ</p>
                <p><strong>Số lượng:</strong> {{ $product->quantity }}</p>
                <p><strong>Mô tả:</strong> {{ $product->description }}</p>
                <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>
                <a href="{{ route('info_client', $product->id) }}" class="btn btn-primary">Mua</a>
            </div>
        </div>
    </div>
@endsection
