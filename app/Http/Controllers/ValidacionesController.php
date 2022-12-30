<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Validacion;
use \Milon\Barcode\DNS1D;
use App\Models\Cotizaciones;
use App\Models\Contenedores;
use Illuminate\Support\Facades\DB;



class ValidacionesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:validacion.print')->only('print');
    //     $this->middleware('can:validacion.store')->only('store');
        
    // }

    public function print($cotizacion_id)
    {
        
        
        $cotizacion = Cotizaciones::whereid($cotizacion_id)->with(['validacions','modalidad','carga','pais','usuario'])->first();
         $carbon = new \Carbon\Carbon();
         $proveedores = Validacion::wherecotizacion_id($cotizacion_id)->get();
         $barcode= $cotizacion->barcode;
         $inBackground=true;
        return view('admin.calculadoras.indexPrint',compact(['cotizacion','carbon','barcode','proveedores','inBackground']));
         //return $proveedores;
        
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
         ]);

       $total=$request->input('estado');
       $contador=count($total)+1;
       $bateria=$request->input('bateria');
       $liquidos=$request->input('liquidos'); 
       $inflamable=$request->input('inflamable');
       $proveedores=$request->input('proveedores');
       $cotizacion_id=$request->input('idCotizacion');

       if ($bateria=='si' || $liquidos=='si' || $inflamable=='si') {
        $data = Cotizaciones::whereid($cotizacion_id)->first();
        
        return redirect()->route('validacion.edit',$data);

    } else {
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
           if ($request->input('enlace'.$i)) {
               $enlace=$request->input('enlace'.$i);   
           }else{
               $enlace='null';
           }
           if ($request->input('total_cartones'.$i)) {
               $total_cartones=$request->input('total_cartones'.$i);   
           }else{
               $total_cartones='null';
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
               'total_cartones'=>$total_cartones,
               'created_at'=>now()
           ]);
        }
        //codigo para traer el contenedor mas recientemente creado con estado libre =1
        $data = Contenedores::whereestado_id(1)->latest('created_at')->first();
        if (isset($data)) {
           $contenedorNuevo=$data->id;
        } 

            //codigo para traer el especialista con menor cantidad de cotizaciones asignadas
       $query= "
       select count(id) as cotizaciones, contenedor_id from contenedor_cotizacions group by contenedor_id";

       $consulta = DB::select($query);

       //condicion para saber si existe cotizaciones asignadas
       if (count($consulta)>0) {
            $id=min($consulta);
            $idContenedorExistente=$id->contenedor_id;
            if ($contenedorNuevo!= $idContenedorExistente) {
                $contenedor = $contenedorNuevo;
            } else {
                $contenedor =$idContenedorExistente;
            }
        } else {
            
            $contenedor=$contenedorNuevo;
        }

        $cotizacion = Cotizaciones::whereid($cotizacion_id)->first();
        $total=($cotizacion->total)+(($proveedores)*50);
        
        $datos=array(
            "proceso"=>'2',
            "total"=>$total
        );
        Cotizaciones::whereid($cotizacion_id)->update($datos);
        DB::table('contenedor_cotizacions')->insert([
            'cotizacion_id'=>$cotizacion_id,
            'contenedor_id'=>$contenedor,
        ]);
         return redirect()->route('validacion.print',$cotizacion_id);
        
    }
        

       
    }
    
    public function guardar(Request $request, $id)
    {
        return $data="Guardar";
    }
   
    public function show($id)
    {
        //
    }

    public function edit($data)
    {
        $cotizacion = Cotizaciones::whereid($data)->with(['carga','pais','modalidad'])->first();
        $mensaje="false";
        $data=[
            'cotizacion'=>$cotizacion,
            'mensaje'=>$mensaje
        ];
        return view('admin.calculadoras.colombia.grupal.formulario',$data);
     
    }


    
    public function update(Request $request, $id)
    {
        
    }

   
    public function destroy($id)
    {
        //
    }
}
