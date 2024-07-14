@extends('app')

@section('content')
    <div class="container">
        @if($products->isNotEmpty())
            <h1>Danh sách {{ $products->first()->category->name }}:</h1>
        @else
            <h1>Không có sản phẩm nào trong danh mục này.</h1>
        @endif
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-2">
                    <div class="card mb-2">
                        @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Product Image">
    @else
        <div class="card-img-top" style="height: 400px; background-color: #eee;"></div>
    @endif
    <div class="card-body">
        <h5 class="card-title">
            <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
        </h5>
        <p class="card-text">Giá: {{ number_format($product->price) }}đ</p>
        <p class="card-text">Còn lại: {{ $product->quantity }} cái</p>
    </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
