<?php

namespace App\Http\Controllers\Rates;

use App\Http\Controllers\Controller;
use App\Models\Cotizaciones;
use Illuminate\Http\Request;

class AereosController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $cotizacion = Cotizaciones::with('modalidad')->where('id',$id)->first();
        return view('admin.calculadoras.cotizaciones.showAerea',compact('cotizacion'));
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
