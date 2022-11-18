<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IdiomasController;
use App\Http\Controllers\CargasController;
use App\Http\Controllers\PaisesController;
use App\Http\Controllers\ModalidadesController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Routing\RouteGroup;
use App\Http\Controllers\Admin\HomeController;


Route::get('admin',[HomeController::class, 'index']);
//Routes IDIOMAS
Route::get('idiomas',[IdiomasController::class, 'index'])->name('idiomas');
Route::resource('admin/idiomas', IdiomasController::class)->names('admin.idiomas');
//ROUTES CARGAS
Route::get('cargas',[CargasController::class, 'index'])->name('cargas');
Route::resource('admin/cargas', CargasController::class)->names('admin.cargas');
//ROUTES paises
Route::get('paises',[PaisesController::class, 'index'])->name('paises');
Route::resource('admin/paises', PaisesController::class)->names('admin.paises');

//ROUTES Modalidades
Route::get('modalidades',[ModalidadesController::class, 'index'])->name('modalidades');
Route::resource('admin/modalidades', ModalidadesController::class)->names('admin.modalidades');
//ROUTES Usuarios
Route::get('usuarios',[UsuariosController::class, 'index'])->name('usuarios');
Route::resource('admin/usuarios', UsuariosController::class)->names('admin.usuarios');