<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::post('login', [AuthController::class, 'login']);
Route::middleware('jwt')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/pp',[HomeController::class,'index']);