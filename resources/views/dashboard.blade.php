<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm thời trang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-inverse {
            background-color: #39648f;
            border-color: #3b73ab;
        }
        .navbar-inverse .navbar-brand, 
        .navbar-inverse .navbar-nav .nav-link {
            color: #bbd247;
        }
        .navbar-inverse .navbar-nav .nav-link:hover {
            color: #f5a70b;
        }
        .jumbotron {
            background-color: #ffffff;
            padding: 2rem 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .container {
            margin-top: 50px;
        }
        .card-img-top {
            object-fit: cover;
            height: 200px;
        }
        .notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #e99910; /* Màu xanh lá cây */
    color: white;
    padding: 15px;
    border-radius: 5px;
    z-index: 1000;
    transition: opacity 0.5s;
}
    </style>
</head>
@if (session('success'))
    <div id="notification" class="notification">
        <p>{{ session('success') }}</p>
    </div>
@endif

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-inverse">
        <div class="container">
            <a class="navbar-brand" >HOME </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.index') }}">Danh Sách User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Danh Sách sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.search') }}">Tìm kiếm sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">Giỏ Hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.statistics') }}">Thống kê</a>
                    </li>
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                </ul>
            </div>
            
        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2">
                <div class="list-group">
                    <a href="{{ route('products.type', ['category_id' => '1']) }}" class="list-group-item list-group-item-action">ÁO</a>
                    <a href="{{ route('products.type', ['category_id' => '2']) }}" class="list-group-item list-group-item-action">QUẦN</a>
                    <a href="{{ route('products.type', ['category_id' => '3']) }}" class="list-group-item list-group-item-action">PHỤ KIỆN</a>
                    
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-10">
                <div class="jumbotron">
                    <h1 class="mb-2">Trang Chủ</h1>
                    <div class="row">
                        @foreach ($products as $product)
                        <div class="col-md-2 mb-3">
                            <div class="card h-100">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Product Image">
                                @else
                                    <div class="card-img-top" style="height: 400px; background-color: #eee;"></div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                    </h5>
                                    <p class="card-text">Giá: {{ number_format($product->price) }}đ</p>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
    <div class="d-flex justify-content-center">
        {{ $products->links('pagination.home') }} 
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notification = document.getElementById('notification');
            if (notification) {
                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 500);
                }, 3000); 
            }
        });
    </script>
    
</body>
</html>
