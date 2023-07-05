<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CalculadoraTemporal;
use Illuminate\Http\Request;
use App\Models\Paises;
use Illuminate\Support\Facades\Validator;

class CalculadorasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.calculadoras.index')->only('index');
    }

    public function index()
    {
        $paises = Paises::get();
        $countryAPI = new Country();
        $countries = $countryAPI->getCountries();
        return view('admin.calculadoras.index', compact('paises','countries'));
    }



    public function create()
    {
        try {
            $calculos = CalculadoraTemporal::with('producto')->where('usuario_id', auth()->user()->id)->get();
            return response()->json([
                'status' => 200,
                'calculos' => $calculos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'insumo_id' => 'required',
            'cartones' => 'required',
            'largo' => 'required',
            'ancho' => 'required',
            'alto' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 404,
                'message' => $validator->messages()
            ]);
        } else {
            CalculadoraTemporal::create([
                'usuario_id' => auth()->user()->id,
                'insumo_id' => $request->input('insumo_id'),
                'cartones' => $request->input('cartones'),
                'largo' => $request->input('largo'),
                'ancho' => $request->input('ancho'),
                'alto' => $request->input('alto'),
                'total' => (($request->input('largo') * $request->input('ancho') * $request->input('alto')) / 1000000) * $request->input('cartones'),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Registro actualizado exitosamente!',
            ]);
        }
    }

    public function total()
    {
        try {
            $calculos = CalculadoraTemporal::with('usuario')->where('usuario_id', auth()->user()->id)->get();
            $total = 0;
            foreach ($calculos as  $calculo) {
                $total = $total + $calculo->total;
            }
            return response()->json([
                'status' => 200,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function show($id)
    {
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
        try {
            CalculadoraTemporal::destroy($id);
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
    }
}
