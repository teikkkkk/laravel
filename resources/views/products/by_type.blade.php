@extends('app')

@section('content')
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
                        @php
                            $fullStars = floor($product->average_rating);
                            $halfStar = $product->average_rating - $fullStars;
                        @endphp
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $fullStars)
                                <i class="fa fa-star"></i>
                            @elseif ($i == $fullStars && $halfStar >= 0.5)
                                <i class="fa fa-star-half-o"></i>
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
@endsection
