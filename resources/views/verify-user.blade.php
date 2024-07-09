<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Xác nhận email</div>
                    <div class="card-body">
                            <div class="alert alert-success" role="alert">
                                Email của bạn đã được xác nhận thành công. Bây giờ bạn có thể <a href="{{ url('/login') }}">đăng nhập</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
