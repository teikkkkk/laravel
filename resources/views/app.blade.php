<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sản phẩm thời trang')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" >
</head>
<body>
    @if (session('success'))
        <div id="notification" class="notification">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <nav class="navbar navbar-expand-lg navbar-dark navbar-inverse">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">HOME</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @can('view products')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Danh sách sản phẩm</a>
                        </li>
                    @endcan

                    @can('view users')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.index') }}">Danh sách người dùng</a>
                        </li>
                    @endcan

                    @can('statistic products')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.statistics') }}">Thống kê</a>
                        </li>
                    @endcan
                    @can('cart')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">Giỏ hàng</a>
                    </li>
                    @endcan
                   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.search') }}">Tìm kiếm sản phẩm</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-info" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                             
                                <a class="dropdown-item" href="{{ route('change-password.form') }}">Thay đổi mật khẩu</a>
                            
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </div>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.js"></script>
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
