@extends('app')
@section('content')
<div class="container">
    <div class="row">
       
        <div class="col-md-2">
            <div class="list-group">
                <a href="{{ route('products.type', ['category_id' => '1']) }}" class="list-group-item list-group-item-action">ÁO</a>
                <a href="{{ route('products.type', ['category_id' => '2']) }}" class="list-group-item list-group-item-action">QUẦN</a>
                <a href="{{ route('products.type', ['category_id' => '3']) }}" class="list-group-item list-group-item-action">PHỤ KIỆN</a>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-10">
            <div class="jumbotron">
                <h1 class="mb-2">Trang Chủ</h1>
                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-md-4 col-lg-3 mb-3">
                        <div class="card h-100">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Product Image">
                            @else
                                <div class="card-img-top" style="height: 200px; background-color: #eee;"></div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                </h5>
                                <p class="card-text">Giá: {{ number_format($product->price) }}đ</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $products->links('pagination.home') }}
</div>
@endsection
