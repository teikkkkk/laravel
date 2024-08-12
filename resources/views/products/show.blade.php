@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if ($product->image || $images->isNotEmpty())
                    <!-- Swiper -->
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @if ($product->image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="swiper-slide-image" alt="Product Image">
                                </div>
                            @endif
                            @foreach ($images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="swiper-slide-image" alt="Product Image">
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <div class="swiper mySwiperThumbs">
                        <div class="swiper-wrapper">
                            @if ($product->image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="swiper-slide-thumb" alt="Product Image">
                                </div>
                            @endif
                            @foreach ($images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="swiper-slide-thumb" alt="Product Image">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="img-thumbnail" style="height: 300px; width: auto; background-color: #eee;"></div>
                @endif
                <div class="custom-hr"></div>
                <h3>Description</h3>
                <div class="text">{{ $product->description }}</div>
            </div>
            <div class="col-md-4">
                <h1 class="product-name">{{ $product->name }}</h1>
                <div class="price-rating">
                    <h3 class="product-price">{{ number_format($product->price) }}đ</h3>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <span class="text">({{ $product->quantity }})</span>
                    </div>
                </div>
                <div class="custom-hr"></div>
                 
                <div class="product-colors">
                    <h6>Chọn màu sắc</h6>
                    @foreach ($product->colors as $color)
                        <span class="detail" style="background-color: {{ $color->name }};"></span>
                    @endforeach
                </div>
               @if ($product->category_id==1||$product->category_id==2)
               <h5 class="mt-3">Kích cỡ</h5>
               <div class="size-selector">
                   @foreach ($sizes as $size)
                       <label class="size-option">
                           <input type="radio" name="size" value="{{ $size->id }}" class="size-input">
                           <span class="size-box">{{ $size->size_name }}</span>
                       </label>
                   @endforeach
               </div>               
               @endif
                <h5 class="mt-3">Số lượng</h5>
               <div class="price-rating">
                <div class="input-group mb-2 quantity-input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary btn-minus" type="button">-</button>
                    </div>
                    <input type="number" name="quantity" class="form-control quantity-input" id="quantity" value="1" min="1">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-plus" type="button">+</button>
                    </div>
                </div>
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2" onsubmit="return addToCartAndRedirect(event)">
                    @csrf
                    <input type="hidden" name="quantity" id="cart-quantity-redirect" value="1">
                    <button type="submit" class="btn btn-primary">Mua</button>
                </form>
               
               </div>
               <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2" onsubmit="return updateCartQuantity(event)">
                @csrf
                <input type="hidden" name="quantity" id="cart-quantity-add" value="1">
                <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
            </form>
            </div>
        </div>
    </div>
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
 
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
 
    <script>
        var swiperThumbs = new Swiper(".mySwiperThumbs", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });

        var swiper = new Swiper(".mySwiper", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            thumbs: {
                swiper: swiperThumbs
            },
        });

        document.querySelector('.btn-minus').addEventListener('click', function() {
            var quantity = document.getElementById('quantity');
            if (quantity.value > 1) {
                quantity.value = parseInt(quantity.value) - 1;
            }
        });

        document.querySelector('.btn-plus').addEventListener('click', function() {
            var quantity = document.getElementById('quantity');
            quantity.value = parseInt(quantity.value) + 1;
        });

        function addToCartAndRedirect(event) {
            event.preventDefault();
            const quantity = document.getElementById('quantity').value;
            document.getElementById('cart-quantity-redirect').value = quantity;

            const form = event.target;
            const action = form.action;

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
                    window.location.href = "{{ route('products.info_client', $product->id) }}";
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
