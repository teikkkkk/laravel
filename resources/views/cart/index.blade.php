@extends('app')

@section('content')
    <div class="container">
        <h1 class="my-4">Giỏ hàng</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if ($cartItems->isEmpty())
            <p>Giỏ hàng trống.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $cartItem)
                        <tr>
                            <td>{{ $cartItem->product->name }}</td>
                            <td>{{ number_format($cartItem->product->price) }}đ</td>
                            <td>
                                <form action="{{ route('cart.updateQuantity', $cartItem->id) }}" method="POST" class="form-inline">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1" class="form-control" style="width: 80px;">
                                    <button type="submit" class="btn btn-primary btn-sm ml-2">Sửa</button>
                                </form>
                            </td>
                            <td>{{ number_format($cartItem->product->price * $cartItem->quantity) }}đ</td>
                            <td>
                                <form action="{{ route('cart.remove', $cartItem->product_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('cart.purchaseForm') }}" class="btn btn-success">Thanh toán</a>
        @endif
    </div>
@endsection
