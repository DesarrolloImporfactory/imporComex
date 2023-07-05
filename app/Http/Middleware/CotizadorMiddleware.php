<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CotizadorMiddleware
{
    
    public function handle(Request $request, Closure $next)
    {
        $usuarioAutenticado = Auth::user();
        $rol = $usuarioAutenticado->roles->first();

        $usuariosConSuscripcionesActivas = DB::table('suscripcions')->where('estado', 'Activa')
            ->where('usuario_id', $usuarioAutenticado->id)
            ->where('sistema_id', 1)->first();

        if (isset($usuariosConSuscripcionesActivas) || $rol->name == 'Admin' || $rol->name == 'Especialista') {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
