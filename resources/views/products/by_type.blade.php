@extends('app')

@section('content')
    <div class="container">
        <h1>Danh sách  {{ $type }}:</h1>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-2">
                    <div class="card mb-2">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Product Image">
                        @else
                            <div class="card-img-top" style="height: 50px; background-color: #eee;"></div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }}đ</p>
                            <p class="card-text">còn lại :{{ $product->quantity }} cái</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
