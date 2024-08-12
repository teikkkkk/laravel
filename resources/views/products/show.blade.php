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
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $averageRating)
                                <i class="fa fa-star"></i>
                            @else
                                <i class="fa fa-star-o"></i>
                            @endif
                        @endfor
                        <span>({{ $reviewCount }})</span>
                    </div>
                </div>
                <div class="custom-hr"></div>
                 
                <div class="product-colors">
                    <h6>Chọn màu sắc</h6>
                    @foreach ($product->colors as $color)
                        <span class="detail" style="background-color: {{ $color->name }};"></span>
                    @endforeach
                </div>
                
                @if ($product->category_id != 3)
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
                    <input type="hidden" name="size" id="cart-size-redirect" value="">
                    <button type="submit" class="btn btn-primary">Mua</button>
                </form>
               
               </div>
               <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2" onsubmit="return updateCartQuantity(event)">
                @csrf
                <input type="hidden" name="quantity" id="cart-quantity-add" value="1">
                <input type="hidden" name="size" id="cart-size-add" value="">
                <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
            </form>
            @auth
            <button type="button" class="btn btn-secondary mt-3" id="reviewButton">Đánh giá sản phẩm</button>
                <div id="reviewPopup" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Đánh giá sản phẩm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>
                        <div class="modal-body">
                            <form id="reviewForm"  onclick=" checkSubmit()">
                                @csrf
                                <div class="form-group">
                                    <label for="rating">Điểm (1-5 sao)</label>
                                    <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                                </div>
                                <div class="form-group">
                                    <label for="content">Nội dung đánh giá</label>
                                    <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                                </div>
                                <button id="submit" type="submit" class="btn btn-primary">Gửi đánh giá</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editReviewModal" tabindex="-1" role="dialog" aria-labelledby="editReviewModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Chỉnh sửa đánh giá</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editReviewForm">
                                @csrf
                                <input type="hidden" id="ReviewId" name="review_id">
                                <input type="hidden" id="productId" name="product_id" value="{{ $product->id }}">
                                <div class="form-group">
                                    <label for="editRating">Điểm (1-5 sao)</label>
                                    <input type="number" class="form-control" id="editRating" name="rating" min="1" max="5" required>
                                </div>
                                <div class="form-group">
                                    <label for="editContent">Nội dung đánh giá</label>
                                    <textarea class="form-control" id="editContent" name="content" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật đánh giá</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p class="mt-3">Bạn cần đăng nhập để gửi đánh giá.</p>
        @endauth
            <div class="custom-hr"></div>
            <h3>Đánh giá</h3>
            <div id="commentsSection">
                @foreach ($product->reviews as $review)
                <div class="review border p-3 mb-3 rounded"  data-review_id="{{ $review->id }}" >
                    <div class="review-header"><strong>{{ $review->name }}</strong></div>
                    <div class="rating">
                        @for ($i = 0; $i < $review->rating; $i++)
                            <i class="fa fa-star"></i>
                        @endfor
                        @for ($i = $review->rating; $i < 5; $i++)
                            <i class="fa fa-star-o"></i>
                        @endfor
                    </div>
                    <div class="content">{{ $review->content }}</div>
                    <button type="button" class="edit-review">Sửa</button>

                </div>
                @endforeach
            </div>
            
        </div>
    </div>
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
 
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#reviewButton').click(function() {
                $('#reviewPopup').modal('show');
            });
               $('.close').click(function(){
                $('#reviewPopup').modal('hide');
               });
              
            //    $('.size-option').click(function(){
            //     let the = $(this).find(".size-box").text();
            //     alert("the la:" + the);
            //    })
                        
               $('#reviewForm').submit(function(event){
                    event.preventDefault();
                    $.ajax({
                        url:"{{ route('products.addReview',$product->id) }}",
                        method:'POST',
                        data:$(this).serialize(),
                        success: function(response){
                            alert(response.message);
                            $('#reviewPopup').modal('hide');
                            $('#commentsSection').append(
                               ' <div class="review border p-3 mb-3 rounded">'+
                    '<div class="review-header"><strong>'+{{ Auth::user()->name }}+'</strong></div>'+
                       ' <div class="rating">'+
                        new Array(parseInt($('#rating').val())).fill('<i class="fa fa-star"></i>').join('')+
                        new Array(5-parseInt($('#rating').val())).fill('<i class="fa fa-star-o"></i>').join('')+
                        '</div>'+
                        '<div class="content">'+$('#content').val()+'</div>'+
                        '</div>'
                            );
                            $('#rating').val('');
                            $('#content').val('');
                        },
                        error: function(xhr,status,error){
                            alert('ERROR');
                        }
                    });
               });
        });
        $(document).ready(function(){
            $('.close').click(function(){
                $('#editReviewModal').modal('hide');
               });
    $('.edit-review').click(function() {
        let reviewDiv = $(this).closest('.review');
        let reviewId = reviewDiv.data('review_id');
        let rating = reviewDiv.find('.fa-star').length;
        let content = reviewDiv.find('.content').text();
        $('#ReviewId').val(reviewId);
        $('#editRating').val(rating);
        $('#editContent').val(content);
        $('#editReviewModal').modal('show');
    });

    $('#editReviewForm').submit(function(event) {
        event.preventDefault();
        let reviewId = $('#ReviewId').val();
        let productId = $('#productId').val();
        $.ajax({
            url: "{{ route('products.updateReview', ['productId' => 'product_Id', 'reviewId' => 'review_Id']) }}"
                .replace('product_Id', productId)
                .replace('review_Id', reviewId),
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                alert(response.message);
                $('#editReviewModal').modal('hide');
               let reviewDiv=$('.review').filter(function(){
                    return $(this).data('review_id')== reviewId;
               });
               reviewDiv.find('.rating').html(
                new Array(parseInt($('#editRating').val())).fill('<i class="fa fa-star"></i>').join('')+
                new Array(5-parseInt($('#editRating').val())).fill('<i class="fa fa-star-o"></i>').join('')
               );
               reviewDiv.find('.content').html($('#editContent').val());
            },
            error: function(xhr, status, error) {
                let errorMessage = 'Lỗi cập nhật đánh giá'
                alert(errorMessage);
            }
        });
    });
});    
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
                const size = document.querySelector('input[name="size"]:checked')?.value || '';
                document.getElementById('cart-quantity-redirect').value = quantity;
                document.getElementById('cart-size-redirect').value = size;
    
    
                const form = event.target;
                const action = form.action;
    
                fetch(action, {
                    method: 'POST', 
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: quantity, size: size
                    })
                })
                .then(response => {
                    if (response.ok) {
                        window.location.href = "{{ route('products.info_client', $product->id) }}";
                    } else {
                        alert('Error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error');
                });
            }
    
            function updateCartQuantity(event) {
                event.preventDefault();
                const quantity = document.getElementById('quantity').value;
                const size = document.querySelector('input[name="size"]:checked')?.value || '';
                document.getElementById('cart-quantity-add').value = quantity;
                document.getElementById('cart-size-add').value = size;
                const form = event.target;
                form.submit();
            }

    </script>
@endsection
