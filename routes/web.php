<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IdiomasController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;


Route::get('/', [LoginController::class, 'showLoginForm']);

Auth::routes([
    "register" => false,
    "reset" => false,
    'verify' => false
]);


Route::get('/register', [IdiomasController::class, 'register'])->name('register');
Route::get('/search/idioma', [IdiomasController::class, 'search'])->name('search.idioma');
Route::get('admin/redirect/{id}', [LoginController::class, 'redirectUser'])->name('admin.redirect');
