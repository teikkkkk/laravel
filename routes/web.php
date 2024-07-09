<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;;
use App\Http\Controllers\ResetPasswordController;
Route::get('/login', [HomeController::class, 'showLoginForm'])->name('login');
Route::post('/photo', [HomeController::class, 'postLogin'])->name('postLogin');
Route::post('/login', [HomeController::class, 'logout'])->name('logout');
Route::get('/register', [HomeController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [HomeController::class, 'register']);
Route::get('/verifyEmail/{token}', [HomeController::class, 'verifyEmail'])->name('verifyEmail');
Route::get('/forgot-password', [ResetPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');     