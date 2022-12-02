<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IdiomasController;
use App\Http\Controllers\CargasController;
use App\Http\Controllers\PaisesController;
use App\Http\Controllers\ModalidadesController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\CalculadorasController;
use App\Http\Controllers\EcuadorController;
use App\Http\Controllers\ColombiaController;
use Illuminate\Routing\RouteGroup;
use App\Http\Controllers\Admin\HomeController;


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin',[HomeController::class, 'index']);
//Routes IDIOMAS
Route::get('idiomas',[IdiomasController::class, 'index'])->name('idiomas');
Route::resource('admin/idiomas', IdiomasController::class)->names('admin.idiomas');
//ROUTES CARGAS
Route::get('cargas',[CargasController::class, 'index'])->name('cargas');
Route::patch('tarifa/{id}',[CargasController::class,'updateTarifa'])->name('tarifa.updateTarifa');
Route::resource('admin/cargas', CargasController::class)->names('admin.cargas');
//ROUTES paises
Route::get('paises',[PaisesController::class, 'index'])->name('paises');
Route::resource('admin/paises', PaisesController::class)->names('admin.paises');

//ROUTES Modalidades
Route::get('modalidades',[ModalidadesController::class, 'index'])->name('modalidades');
Route::resource('admin/modalidades', ModalidadesController::class)->names('admin.modalidades');
//ROUTES Usuarios
Route::get('usuarios',[UsuariosController::class, 'index'])->name('usuarios');

Route::patch('admin/show/{user}',[UsuariosController::class, 'show'])->name('usuarios.show');
Route::resource('admin/usuarios', UsuariosController::class)->names('admin.usuarios');
//rutas de roles
Route::resource('roles', RolesController::class)->names('admin.roles');
//rutas de calculadora
//Route::get('calculadoras/ecuador',[CalculadorasController::class, 'indexEcuador'])->name('admin.calculadoras.indexEcuador');
Route::resource('calculadoras', CalculadorasController::class)->names('admin.calculadoras');
//ruta controlador ecuador

//ruta controlador colombia
//Route::get('colombia', [ColombiaController::class, 'index'])->name('colombia');
//Route::get('colombia/calculadoras', [ColombiaController::class, 'index'])->name('colombia.calculadoras');
Route::resource('colombia', ColombiaController::class)->names('admin.colombia');
Route::get('ecuador/calculadoras', [EcuadorController::class, 'index'])->name('ecuador.calculadoras');

Route::resource('ecuador', EcuadorController::class)->names('admin.ecuador');

