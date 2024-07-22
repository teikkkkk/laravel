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
                <p><strong>Mô tả:</strong> {{ $product->description }}</p>
                <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>
                
                <div class="input-group mb-3">
                    <input type="number" name="quantity" class="form-control" id="quantity" value="1" min="1">
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2" onsubmit="return addToCartAndRedirect(event)">
                    @csrf
                    <input type="hidden" name="quantity" id="cart-quantity-redirect" value="1">
                    <button type="submit" class="btn btn-primary">Mua</button>
                </form>
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2" onsubmit="return updateCartQuantity(event)">
                    @csrf
                    <input type="hidden" name="quantity" id="cart-quantity-add" value="1">
                    <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addToCartAndRedirect(event) {
            event.preventDefault();
            const quantity = document.getElementById('quantity').value;
            document.getElementById('cart-quantity-redirect').value = quantity;

            const form = event.target;
            const action = form.action;

            // Gửi request AJAX để thêm vào giỏ hàng
            fetch(action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantity: quantity
                })
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = "{{ route('info_client', $product->id) }}";
                } else {
                    alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            });
        }

        function updateCartQuantity(event) {
            event.preventDefault();
            const quantity = document.getElementById('quantity').value;
            document.getElementById('cart-quantity-add').value = quantity;

            const form = event.target;
            form.submit();
        }
    </script>
@endsection
