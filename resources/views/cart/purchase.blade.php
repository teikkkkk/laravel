@extends('app')

@section('content')
    <div class="container">
        <h1 class="my-4">Thông tin mua hàng</h1>
        <form action="{{ route('cart.completePurchase') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" name="address" id="address" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Đơn hàng của bạn</h3>
                    <ul class="list-group">
                        @foreach ($cartItems as $cartItem)
                            <li class="list-group-item">
                                {{ $cartItem->product->name }} - {{ $cartItem->quantity }} x {{ number_format($cartItem->product->price) }}đ
                                <span class="float-end">{{ number_format($cartItem->product->price * $cartItem->quantity) }}đ</span>
                            </li>
                        @endforeach
                        <li class="list-group-item">
                            <strong>Tổng cộng:</strong> 
                            <span class="float-end">{{ number_format($cartItems->sum(function ($cartItem) { return $cartItem->product->price * $cartItem->quantity; })) }}đ</span>
                        </li>
                    </ul>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Xác nhận mua hàng</button>
        </form>
    </div>
@endsection
