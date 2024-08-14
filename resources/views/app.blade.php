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
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  
</head>
<body>
   
    @can('view notifications')
    <div id="notification" class="notification alert">
        <p id="notificationMessage"></p>
    </div>
    @endcan

    <nav class="navbar navbar-expand-lg navbar-dark navbar-inverse fixed-navbar fixed-top">
        <div class="container">
            <div class="d-flex align-items-center">
                <span class="hotline me-3 text"><i class="fa fa-phone"></i> Hotline: 0123 456 789</span>
                <a class="navbar-brand" href="{{ route('home') }}"><i class="fa fa-home icon"></i></a>
            </div>
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
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fa fa-shopping-cart icon"></i> </a>
                    </li>
                    @endcan

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.search') }}">
                            <i class="fa fa-search icon"></i>
                        </a>
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
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@latest/dist/echo.iife.min.js"></script>

    <script>
      
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });

        window.Echo.channel('orders')
            .listen('.order.created', (e) => {
  
                const notificationElement = document.getElementById('notification');
                    const notificationMessage = document.getElementById('notificationMessage');
                    notificationMessage.innerHTML = `Có đơn hàng mới từ ${e.order.customer_name}<br>Đơn hàng ID ${e.order.id}`;
                    notificationElement.style.display = 'block';

                setTimeout(() => {
                    document.getElementById('notification').style.display = 'none';
                }, 8000);
            });
    </script>
</body>
</html>
