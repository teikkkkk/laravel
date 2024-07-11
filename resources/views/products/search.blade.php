@extends('app')

@section('content')
    <div class="container">
        <h1 class="my-4">Danh sách sản phẩm</h1>

        <form action="{{ route('products.search') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm" value="{{ request('name') }}">
                </div>
                <div class="col-md-4">
                    <select name="type" class="form-control">
                        <option value="">Chọn loại sản phẩm</option>
                        <option value="áo" {{ request('type') == 'áo' ? 'selected' : '' }}>Áo</option>
                        <option value="quần" {{ request('type') == 'quần' ? 'selected' : '' }}>Quần</option>
                        <option value="phụ kiện" {{ request('type') == 'phụ kiện' ? 'selected' : '' }}>Phụ kiện</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="min_price" class="form-control" placeholder="Giá từ" value="{{ request('min_price') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="max_price" class="form-control" placeholder="Giá đến" value="{{ request('max_price') }}">
                </div>
                <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>
        </form>

        @if($products->isEmpty())
            <div class="alert alert-warning">
                Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm.
            </div>
        @else
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Product Image">
                            @else
                                <div class="card-img-top" style="height: 200px; background-color: #eee;"></div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted">{{ number_format($product->price) }}đ</p>
                                <p class="card-text">Còn lại: {{ $product->quantity }} cái</p>
                                <p class="card-text">Loại: {{ $product->type }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
