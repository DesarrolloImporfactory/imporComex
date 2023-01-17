<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IdiomasController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('verified');

Auth::routes(['verify'=>true]);


Route::get('/register',[IdiomasController::class,'register'])->name('register');
Route::get('/search/idioma',[IdiomasController::class,'search'])->name('search.idioma');



// Route::get('/idiomas',[IdiomasController::class,'index'])->name('idiomas');
// Route::resource('idiomas', IdiomasController::class);
