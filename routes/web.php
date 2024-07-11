<?php
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetPasswordController;
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/login', [HomeController::class, 'showLoginForm'])->name('login');
Route::post('/home', [HomeController::class, 'postLogin'])->name('postLogin');
Route::post('/login', [HomeController::class, 'logout'])->name('logout');
Route::get('/register', [HomeController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [HomeController::class, 'register']);
Route::get('/verifyEmail/{token}', [HomeController::class, 'verifyEmail'])->name('verifyEmail');
Route::get('/forgot-password', [ResetPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');     

Route::get('/user/index',[UserController::class,'index'])->name('user.index');
Route::delete('user/index{id}',[UserController::class,'destroy'])->name('user.destroy');
Route::put('user/{id}',[UserController::class,'update'])->name('user.update');
Route::get('users/{id}/edit',[UserController::class,'edit'])->name('user.edit');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/type/{type}', [ProductController::class, 'productsByType'])->name('products.type');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');