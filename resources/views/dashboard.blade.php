@extends('app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2 ">
            <div class="list-group no-underline category-colum">
                <a href="{{ route('products.type', ['category_id' => '1']) }}" class="list-group-item list-group-item-action">ÁO</a>
                <a href="{{ route('products.type', ['category_id' => '2']) }}" class="list-group-item list-group-item-action">QUẦN</a>
                <a href="{{ route('products.type', ['category_id' => '3']) }}" class="list-group-item list-group-item-action">PHỤ KIỆN</a>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-10">
            <div class="jumbotron">
                <h1 class="mb-2">Trang Chủ</h1>
                <div class="row no-gutters">
                    @foreach ($products as $product)
                    <div class="col-lg-3 no-underline product-column">
                        <a data-action="click" href="{{ route('products.show', $product->id) }}">
                            <div class="card h-100 product-card">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Product Image">
                                @else
                                    <div class="card-img-top"></div>
                                @endif
                                <div class="card-body">
                                    <div class="product-colors">
                                        @foreach ($product->colors as $color)
                                            <span class="color-badge" style="background-color: {{ $color->name }};"></span>
                                        @endforeach
                                    </div>
                                    <div class="product-info">
                                        <span>Giới tính: {{ $product->gender }}</span>
                                        <span>Size: {{ $product->size }}</span>
                                    </div>
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="product-description">{{ $product->description }}</p>
                                    <h5 class="product-price">{{ number_format($product->price) }}đ</h5>
                                    <div class="rating">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $product->average_rating)
                                                <i class="fa fa-star"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                        @endfor
                                        <span>({{ $product->review_count }})</span>
                                    </div>
                                </div>
                            </div>
                        </a>
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
