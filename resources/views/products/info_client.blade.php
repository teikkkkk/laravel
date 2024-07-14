@extends('app')

@section('content')
    <div class="container">
        <h1>Mua {{ $product->name }}</h1>
        <form action="{{ route('complete', $product->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ giao hàng</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <button type="submit" class="btn btn-success">Xác nhận mua</button>
        </form>
    </div>
@endsection
