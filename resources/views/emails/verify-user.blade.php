<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận Email</title>
</head>
<body>
    <h1>Xin chào, {{ $user->name }}</h1>
    <p>Vui lòng nhấn vào liên kết dưới đây để xác nhận email của bạn:</p>
    <a href="{{ url('verifyEmail', $token) }}">Xác nhận email</a>
</body>
</html>
