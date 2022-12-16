<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Validacion;
use \Milon\Barcode\DNS1D;
use App\Models\Cotizaciones;
use Illuminate\Support\Facades\DB;



class ValidacionesController extends Controller
{
    
    public function print($id)
    {
        
        
        $cotizacion = Cotizaciones::whereid($id)->with(['validacions','modalidad','carga','pais','usuario'])->first();
        $carbon = new \Carbon\Carbon();
        $id= $cotizacion->barcode;
        
        return view('admin.calculadoras.indexPrint',compact(['cotizacion','carbon','id']));
        //return $code;
    }

    
    public function create()
    {
        return $data="Vista Craete";
    }

   
    public function store(Request $request)
    {
        $request->validate([
             'bateria'=>['required'],
             'liquidos' => ['required'],
             'inflamable' => ['required'],
             'proveedores'=>['required','numeric'],
             'enlace'=>['required','url'],    
          ]);

        $total=$request->input('estado');
        $contador=count($total)+1;

        $bateria=$request->input('bateria');
        $liquidos=$request->input('liquidos');
        $inflamable=$request->input('inflamable');
        $proveedores=$request->input('proveedores');
        $enlace=$request->input('enlace');
        //$nombre_pro=$request->input('nombre_pro');
        $cotizacion_id=$request->input('idCotizacion');
    
        
         for ($i=1; $i < $contador ; $i++) { 
            
             if ($request->hasFile('factura'.$i)) {
                 $archivo=$request->file('factura'.$i)->store('docs','public');   
             }else{
                $archivo='null';
             }
             if ($request->hasFile('foto'.$i)) {
                $foto=$request->file('foto'.$i)->store('uploads','public');   
            }else{
                $foto='null';
            }

            if ($request->input('nombre_pro'.$i)) {
                $nombre_pro=$request->input('nombre_pro'.$i);   
            }else{
                $nombre_pro='null';
            }
            
          
             DB::table('validacions')->insert([
                'bateria'=>$bateria,
                'liquidos'=>$liquidos,
                'inflamable'=>$inflamable,
                'proveedores'=>$proveedores,
                'factura'=>$archivo,
                'foto'=>$foto,
                'nombre_pro'=>$nombre_pro,
                'enlace'=>$enlace,
                'cotizacion_id'=>$cotizacion_id,
                'created_at'=>now()
            ]);
         }
            $id=$request->input('idCotizacion');
            $cotizacion = Cotizaciones::select('*')->whereid($id)->first();
            $total=($cotizacion->total)+(($proveedores)*50);
            

             $datos=array(
                 "proceso"=>'2',
                 "total"=>$total
             );
            
             Cotizaciones::whereid($id)->update($datos);
             return redirect()->route('validacion.print',$id);
            
            
            
    }
    
    public function guardar(Request $request, $id)
    {
        return $data="Guardar";
    }
   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        return $id;
    }

    
    public function update(Request $request, $id)
    {
        
    }

   
    public function destroy($id)
    {
        //
    }
}
