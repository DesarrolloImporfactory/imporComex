<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idioma;

class IdiomasController extends Controller
{
   
   
    public function index(){
        $datos['idiomas']=Idioma::get();
        return view('admin.idiomas.index',$datos);
    }

    public function register(){
        $datos['idiomas']=Idioma::get();
        return view('auth.register',$datos);
    }

    public function search(Request $request){
        $temp = $request->get('temp');
        $query = Idioma::where('nombre', 'LIKE', '%'.$temp.'%')->get();
        $data = [];
        foreach($query as $idioma){
            $data[]=[
                'label' => $idioma->nombre
            ];
        }

        return $data;
    }

    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        $datosIdiomas = new Idioma();
        $datosIdiomas->nombre=$request->input('nombre');
        $datosIdiomas->codigo=$request->input('codigo');

        // return response()->json($datosIdiomas);
        $datosIdiomas->save();
        return redirect('idiomas')->with('mensaje','Idioma registrado');
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        $datos=array(
            "nombre"=>$request->input('nombre'),
            "codigo"=>$request->input('codigo')
        );
        
        Idioma::whereid($id)->update($datos);
        //return response()->json($datos);
        return redirect('idiomas')->with('mensaje','Idioma Actualizado');
     }

   
    public function destroy($id)
    {

        //return response()->json($id);
        Idioma::destroy($id);
        return redirect('idiomas')->with('mensaje','Idioma Eliminado');
    }
}
