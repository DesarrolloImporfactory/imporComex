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
use App\Http\Controllers\CotizacionIndividualController;
use App\Http\Controllers\CotizacionProductosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpuestosController;



//Route::get('admin',[HomeController::class, 'index']);
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('idiomas', [IdiomasController::class, 'index'])->name('idiomas');
    Route::resource('admin/idiomas', IdiomasController::class)->names('admin.idiomas');

    Route::get('cargas', [CargasController::class, 'index'])->name('cargas');
    Route::patch('tarifa/{id}', [CargasController::class, 'updateTarifa'])->name('tarifa.updateTarifa');
    Route::resource('admin/cargas', CargasController::class)->names('admin.cargas');

    Route::get('paises', [PaisesController::class, 'index'])->name('paises');
    Route::resource('admin/paises', PaisesController::class)->names('admin.paises');

    Route::get('modalidades', [ModalidadesController::class, 'index'])->name('modalidades');
    Route::resource('admin/modalidades', ModalidadesController::class)->names('admin.modalidades');

    //Route::get('usuarios',[UsuariosController::class, 'index'])->name('usuarios');

    Route::patch('admin/show/{user}', [UsuariosController::class, 'show'])->name('usuarios.show');
    Route::resource('admin/usuarios', UsuariosController::class)->names('admin.usuarios');

    Route::resource('roles', RolesController::class)->names('admin.roles');

    Route::resource('calculadoras', CalculadorasController::class)->names('admin.calculadoras');
    Route::get('admin/calculadoras', [UsuariosController::class, 'createUserFast'])->name('create.user.fast');

    Route::resource('colombia', ColombiaController::class)->names('admin.colombia');

    Route::resource('validacion', ValidacionesController::class)->names('validacion');
    Route::get('validacion/{id}/print', [ValidacionesController::class, 'print'])->name('validacion.print');

    Route::get('ticket/{id}/pdf', [ReportesController::class, 'pdfTicket'])->name('ticket.pdf');
    Route::get('cotizacion/{id}/pdf', [ReportesController::class, 'pdfCotizacion'])->name('cotizacion.pdf');
    Route::resource('admin/calcular/impuesto', ReportesController::class)->names('calcular.impuestos');

    Route::resource('admin/contenedores', ContenedoresController::class)->names('admin.contenedores');
    Route::resource('admin/estados', EstadosController::class)->names('admin.estados');

    Route::resource('admin/cotizaciones', CotizacionesController::class)->names('admin.cotizaciones');

    Route::resource('admin/especialistas', EspecialistasController::class)->names('admin.especialistas');
    Route::get('admin/especialistas/count', [EspecialistasController::class, 'count'])->name('admin.especialistas.count');

    Route::get('admin/{foto}/dowload', [EspecialistasController::class, 'dowloadFoto'])->name('admin.dowload');
    Route::get('admin/{foto}/dowload/archivo', [EspecialistasController::class, 'dowloadArchivo'])->name('admin.dowload.archivo');
    //rutas para el dashboar
    Route::post('admin/dashboar/all', [DashboardController::class, 'all'])->name('admin.dashboard.all');
    Route::get('admin/dashboard/{id}', [DashboardController::class, 'totalCotizaciones'])
        ->name('admin.dashboard.totalCotizaciones');
    Route::get('admin/clientes', [DashboardController::class, 'clientes'])->name('admin.clientes');
    Route::post('admin/dashboar/grafica1', [DashboardController::class, 'grafica1'])
        ->name('admin.dashboard.grafica1');
    Route::post('admin/dashboar/cotizacionesPendientes', [DashboardController::class, 'cotizacionesPendientes'])
        ->name('admin.dashboard.cotizacionesPendientes');
    //fin de rutas 
    Route::get('admin/cotizaciones/aprobadas/{aprobado}', [CotizacionesController::class, 'cotizacionesAprobadas'])->name('admin.cotizaciones.aprobadas');
    Route::resource('admin/individual', CotizacionIndividualController::class)->names('admin.individual');

    Route::resource('admin/impuestos', ImpuestosController::class)->names('admin.impuestos');

    Route::get('editar/{id}/paso1', [ColombiaController::class, 'editpaso1'])->name('editar.paso1');
    Route::patch('actualizar/paso1/{id}', [ColombiaController::class, 'actualizarPaso1'])->name('actualizar.paso1');
    Route::get('editar/{id}/paso2', [ValidacionesController::class, 'editpaso2'])->name('editar.paso2');
    Route::post('admin/colombia/save', [ColombiaController::class, 'save'])->name('admin.colombia.save');
    Route::post('admin/save/producto', [ColombiaController::class, 'saveProduct'])->name('admin.save.producto');

    Route::resource('admin/relacion', CotizacionProductosController::class)->names('admin.relacion');
});
