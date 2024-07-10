<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-inverse {
            background-color: #343a40;
            border-color: #454d55;
        }
        .navbar-inverse .navbar-brand, 
        .navbar-inverse .navbar-nav .nav-link {
            color: #ffffff;
        }
        .navbar-inverse .navbar-nav .nav-link:hover {
            color: #d4d4d4;
        }
        .jumbotron {
            background-color: #ffffff;
            padding: 2rem 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .jumbotron .display-4 {
            font-size: 0.5rem;
        }
        .jumbotron .lead {
            font-size: 1.25rem;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-inverse">
        <div class="container">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                  
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.index') }}">Danh Sách User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">Danh Sách sản phẩm</a>
                    </li>
                </ul>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="jumbotron">
            <div class="container mt-5">
                <h1 class="mb-4">Trang Chủ</h1>
                <div class="gallery">
                  
                    <img src="{{ asset('images/manu2.jpg') }}" alt="Football Image 2">
                    <img src="{{ asset('images/manu3.jpg') }}"alt="Football Image 3">
                    <img src="{{ asset('images/1.jpg') }}"alt="Football Image 3">
                    <img src="{{ asset('images/2.jpg') }}"alt="Football Image 3">
                   
        
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <hr class="my-4">
            
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
