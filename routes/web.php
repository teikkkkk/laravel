<?php

use App\Http\Controllers\{
    CartController,
    ChangePasswordController,
    HomeController,
    ProductController,
    ResetPasswordController,
    UploadController,
    UserController
};
use App\Http\Middleware\AuthenticatedUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductExportController;



// Đăng nhập và đăng xuất
Route::get('/login', [HomeController::class, 'showLoginForm'])->name('login');
Route::post('/login', [HomeController::class, 'postLogin'])->name('postLogin');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
// Đăng ký
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
Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-password.form');
Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');

Route::prefix('user')->name('user.')->middleware('role:admin')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name('index');
    Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('{id}', [UserController::class, 'update'])->name('update');
    Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::post('{id}/assign-role', [UserController::class, 'assignRole'])->name('assignRole');
});

// Quản lý sản phẩm
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/category/{category_id}', [ProductController::class, 'productsByCategory'])->name('type');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('{id}', [ProductController::class, 'show'])->name('show');
    Route::get('purchase/{id}', [ProductController::class, 'purchase'])->name('info_client');
    Route::post('purchase/{id}', [ProductController::class, 'complete'])->name('complete');
    Route::post('/reviews/{id}', [ProductController::class, 'addReview'])->name('addReview');
    Route::put('/{productId}/reviews/{reviewId}', [ProductController::class, 'updateReview'])->name('updateReview');
});
 
Route::prefix('products')->name('products.')->middleware('role:admin|mod')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('{id}', [ProductController::class, 'destroy'])->name('destroy');
    Route::post('/statistics/filter', [ProductController::class, 'filterStatistics'])->name('filterStatistics');
});
Route::middleware(['role:admin|mod'])->group(function () {
Route::get('/statistics', [ProductController::class, 'filterStatistics'])->name('products.statistics');
Route::get('create', [ProductController::class, 'create'])->name('products.create');
Route::get('/export', [ProductExportController::class, 'export'])->name('products.export');
Route::post('/upload', [UploadController::class, 'upload'])->name('products.upload');
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
