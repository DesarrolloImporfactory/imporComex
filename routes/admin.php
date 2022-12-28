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
use App\Http\Controllers\EspecialistasController;
use App\Http\Controllers\ColombiaController;
use App\Http\Controllers\ValidacionesController;
use App\Http\Controllers\EstadosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\CotizacionesController;
use Illuminate\Routing\RouteGroup;
use App\Http\Controllers\ContenedoresController;
use App\Http\Controllers\Admin\HomeController;


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('admin',[HomeController::class, 'index']);
Route::middleware('auth')->group(function () {

    Route::get('idiomas',[IdiomasController::class, 'index'])->name('idiomas');
    Route::resource('admin/idiomas', IdiomasController::class)->names('admin.idiomas');
    
    Route::get('cargas',[CargasController::class, 'index'])->name('cargas');
    Route::patch('tarifa/{id}',[CargasController::class,'updateTarifa'])->name('tarifa.updateTarifa');
    Route::resource('admin/cargas', CargasController::class)->names('admin.cargas');
    
    Route::get('paises',[PaisesController::class, 'index'])->name('paises');
    Route::resource('admin/paises', PaisesController::class)->names('admin.paises');
    
    Route::get('modalidades',[ModalidadesController::class, 'index'])->name('modalidades');
    Route::resource('admin/modalidades', ModalidadesController::class)->names('admin.modalidades');
    
    //Route::get('usuarios',[UsuariosController::class, 'index'])->name('usuarios');

    Route::patch('admin/show/{user}',[UsuariosController::class, 'show'])->name('usuarios.show');
    Route::resource('admin/usuarios', UsuariosController::class)->names('admin.usuarios');
 
    Route::resource('roles', RolesController::class)->names('admin.roles');

    Route::resource('calculadoras', CalculadorasController::class)->names('admin.calculadoras');
    
    Route::resource('colombia', ColombiaController::class)->names('admin.colombia');

    Route::resource('validacion', ValidacionesController::class)->names('validacion');
    Route::get('validacion/{id}/print', [ValidacionesController::class, 'print'])->name('validacion.print');

    Route::get('ticket/{id}/pdf', [ReportesController::class, 'pdfTicket'])->name('ticket.pdf');
    Route::get('cotizacion/{id}/pdf', [ReportesController::class, 'pdfCotizacion'])->name('cotizacion.pdf');

    Route::resource('admin/contenedores', ContenedoresController::class)->names('admin.contenedores');
    Route::resource('admin/estados', EstadosController::class)->names('admin.estados');

    Route::resource('admin/cotizaciones', CotizacionesController::class)->names('admin.cotizaciones');

    Route::resource('admin/especialistas', EspecialistasController::class)->names('admin.especialistas');
    Route::get('admin/especialistas/count',[EspecialistasController::class, 'count'])->name('admin.especialistas.count');
});

