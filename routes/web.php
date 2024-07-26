<?php

use App\Http\Controllers\{
    CartController,
    ChangePasswordController,
    HomeController,
    ProductController,
    ResetPasswordController,
    UserController
};
use App\Http\Middleware\AuthenticatedUser;
use Illuminate\Support\Facades\Route;



// Đăng nhập và đăng xuất
Route::get('/login', [HomeController::class, 'showLoginForm'])->name('login');
Route::post('/login', [HomeController::class, 'postLogin'])->name('postLogin');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

// Đăng ký và xác thực email
Route::get('/register', [HomeController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [HomeController::class, 'register']);
Route::get('/verifyEmail/{token}', [HomeController::class, 'verifyEmail'])->name('verifyEmail');

// Quên mật khẩu và đặt lại mật khẩu
Route::get('/forgot-password', [ResetPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware(['auth'])->group(function () {
Route::get('/home', [HomeController::class, 'home'])->name('home');
// Thay đổi mật khẩu
Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-password.form');
Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');

// Quản lý người dùng
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name('index');
    Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('{id}', [UserController::class, 'update'])->name('update');
    Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy');
});

// Quản lý sản phẩm
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('{id}', [ProductController::class, 'destroy'])->name('destroy');
    Route::get('/category/{category_id}', [ProductController::class, 'productsByCategory'])->name('type');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('{id}', [ProductController::class, 'show'])->name('show');
    Route::get('purchase/{id}', [ProductController::class, 'purchase'])->name('info_client');
    Route::post('purchase/{id}', [ProductController::class, 'complete'])->name('complete');
    Route::get('/statistics', [ProductController::class, 'filterStatistics'])->name('statistics');
    Route::post('/statistics/filter', [ProductController::class, 'filterStatistics'])->name('filterStatistics');
});

// Giỏ hàng
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('add/{id}', [CartController::class, 'add'])->name('add');
    Route::delete('remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('update/{id}', [CartController::class, 'updateQuantity'])->name('updateQuantity');
    Route::get('purchase', [CartController::class, 'purchaseForm'])->name('purchaseForm');
    Route::post('purchase', [CartController::class, 'completePurchase'])->name('completePurchase');
});
});
 
// Trang mặc định
Route::get('/kkk', function () {
    return view('test');
});
