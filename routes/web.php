<?php
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;;
use App\Http\Controllers\CategoryController;
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

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
