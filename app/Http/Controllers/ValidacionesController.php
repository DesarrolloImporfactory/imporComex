<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Validacion;
use \Milon\Barcode\DNS1D;
use App\Models\Cotizaciones;
use App\Models\Contenedores;
use App\Models\Impuesto;
use App\Models\cotizacion_impuesto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class ValidacionesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:validacion.print')->only('print');
    //     $this->middleware('can:validacion.store')->only('store');

    // }

    public function print($cotizacion_id)
    {

        $relacion = cotizacion_impuesto::where('cotizacion_id',$cotizacion_id)->exists();
        if($relacion==1){
            $impuestoCotizacion = cotizacion_impuesto::where('cotizacion_id',$cotizacion_id)->with('impuesto')->get();
        }else{
            $impuestoCotizacion="falso";
        }
        $cotizacion = Cotizaciones::whereid($cotizacion_id)->with(['validacions', 'modalidad', 'carga', 'pais', 'usuario'])->first();
        $carbon = new \Carbon\Carbon();
        $proveedores = Validacion::wherecotizacion_id($cotizacion_id)->get();
        $barcode = $cotizacion->barcode;
        $inBackground = true;
        $impuesto = Impuesto::all();
        return view('admin.calculadoras.indexPrint', compact(['cotizacion', 'carbon', 'barcode', 'proveedores', 'inBackground', 'impuesto','impuestoCotizacion']));
        //return $proveedores;

    }


    public function create()
    {
        return $data = "Vista Craete";
    }


    public function store(Request $request)
    {
        $request->validate([
            'liquidos' => ['required'],
            'inflamable' => ['required'],
            'proveedores' => ['required', 'numeric'],
        ]);

        $total = $request->input('estado');
        $contador = count($total) + 1;
        $liquidos = $request->input('liquidos');
        $inflamable = $request->input('inflamable');
        $proveedores = $request->input('proveedores');
        $cotizacion_id = $request->input('idCotizacion');

        if ($liquidos == 'si' || $inflamable == 'si') {
            $data = Cotizaciones::whereid($cotizacion_id)->first();

            return redirect()->route('validacion.edit', $data);
        } else {
            for ($i = 1; $i < $contador; $i++) {

                if ($request->hasFile('factura' . $i)) {
                    $archivo = $request->file('factura' . $i)->store('docs', 'public');
                } else {
                    $archivo = 'null';
                }
                if ($request->hasFile('foto' . $i)) {
                    $foto = $request->file('foto' . $i)->store('uploads', 'public');
                } else {
                    $foto = 'null';
                }

                if ($request->input('nombre_pro' . $i)) {
                    $nombre_pro = $request->input('nombre_pro' . $i);
                } else {
                    $nombre_pro = 'null';
                }
                if ($request->input('enlace' . $i)) {
                    $enlace = $request->input('enlace' . $i);
                } else {
                    $enlace = 'null';
                }
                if ($request->input('contacto' . $i)) {
                    $contacto = $request->input('contacto' . $i);
                } else {
                    $contacto = 'null';
                }
                if ($request->input('total_cartones' . $i)) {
                    $total_cartones = $request->input('total_cartones' . $i);
                } else {
                    $total_cartones = 'null';
                }

                DB::table('validacions')->insert([
                    'liquidos' => $liquidos,
                    'inflamable' => $inflamable,
                    'proveedores' => $proveedores,
                    'factura' => $archivo,
                    'foto' => $foto,
                    'nombre_pro' => $nombre_pro,
                    'enlace' => $enlace,
                    'contacto' => $contacto,
                    'cotizacion_id' => $cotizacion_id,
                    'total_cartones' => $total_cartones,
                    'created_at' => now()
                ]);
            }
            //codigo para traer el contenedor mas recientemente creado con estado libre =1
            $data = Contenedores::whereestado_id(1)->latest('created_at')->first();
            if (isset($data)) {
                $contenedorNuevo = $data->id;
            }

            //codigo para traer el especialista con menor cantidad de cotizaciones asignadas
            $query = "
       select count(id) as cotizaciones, contenedor_id from contenedor_cotizacions group by contenedor_id";

            $consulta = DB::select($query);

            //condicion para saber si existe cotizaciones asignadas
            if (count($consulta) > 0) {
                $id = min($consulta);
                $idContenedorExistente = $id->contenedor_id;
                if ($contenedorNuevo != $idContenedorExistente) {
                    $contenedor = $contenedorNuevo;
                } else {
                    $contenedor = $idContenedorExistente;
                }
            } else {

                $contenedor = $contenedorNuevo;
            }

            $cotizacion = Cotizaciones::whereid($cotizacion_id)->first();
            $total = ($cotizacion->total_logistica) + (($proveedores) * 50);

            $datos = array(
                "proceso" => '2',
                "total_logistica" => $total
            );
            Cotizaciones::whereid($cotizacion_id)->update($datos);
            DB::table('contenedor_cotizacions')->insert([
                'cotizacion_id' => $cotizacion_id,
                'contenedor_id' => $contenedor,
            ]);
            return redirect()->route('validacion.print', $cotizacion_id);
        }
    }

    public function guardar(Request $request, $id)
    {
        return $data = "Guardar";
    }

    public function editpaso2($data)
    {
        
        $validacion = Validacion::wherecotizacion_id($data)->first();
        $validaciones = Validacion::wherecotizacion_id($data)->get();
        $cotizacion = Cotizaciones::whereid($data)->with(['carga', 'pais', 'modalidad', 'validacions'])->first();
        if(count($validaciones)>0){
            $datos = [
                'validacion' => $validacion,
                'cotizacion' => $cotizacion,
                'validaciones' => $validaciones
            ];
            return view('admin.paso2.edit', $datos);
        }else{
            return redirect()->route('admin.colombia.edit', $data)->with('mensaje','Completemos la cotizacion!');
        }
         
        // //return $data;
        // 
    }

    public function edit($data)
    {
        $cotizacion = Cotizaciones::whereid($data)->with(['carga', 'pais', 'modalidad'])->first();
        $mensaje = "false";
        $data = [
            'cotizacion' => $cotizacion,
            'mensaje' => $mensaje
        ];
        return view('admin.calculadoras.colombia.grupal.formulario', $data);
    }



    public function update(Request $request, $id)
    {
        $total = $request->input('estado');
        $contador = count($total) + 1;
        $liquidos = $request->input('liquidos');
        $inflamable = $request->input('inflamable');
        $proveedores = $request->input('proveedores');
        $cotizacion_id = $request->input('idCotizacion');
        $usuarioId = $request->input('usuarioId');

        if ($liquidos == 'si' || $inflamable == 'si') {
            $data = Cotizaciones::whereid($cotizacion_id)->first();

            return redirect()->route('editar.paso2', $data)->with('error', 'error');
        } else {
            if (($request->input('condicion')) == "verdad") {
                for ($i = 1; $i < $contador; $i++) {

                    if ($request->hasFile('factura' . $i)) {
                        Storage::delete('public/' . $request->input('facturaOriginal' . $i));
                        $archivo = $request->file('factura' . $i)->store('docs', 'public');
                    } else {
                        $archivo = $request->input('facturaOriginal' . $i);
                    }
                    if ($request->hasFile('foto' . $i)) {
                        Storage::delete('public/' . $request->input('fotoOriginal' . $i));
                        $foto = $request->file('foto' . $i)->store('uploads', 'public');
                    } else {
                        $foto = $request->input('fotoOriginal' . $i);
                    }

                    if ($request->input('nombre_pro' . $i)) {
                        $nombre_pro = $request->input('nombre_pro' . $i);
                    } else {
                        $nombre_pro = 'null';
                    }
                    if ($request->input('enlace' . $i)) {
                        $enlace = $request->input('enlace' . $i);
                    } else {
                        $enlace = 'null';
                    }
                    if ($request->input('contacto' . $i)) {
                        $contacto = $request->input('contacto' . $i);
                    } else {
                        $contacto = 'null';
                    }
                    if ($request->input('total_cartones' . $i)) {
                        $total_cartones = $request->input('total_cartones' . $i);
                    } else {
                        $total_cartones = 'null';
                    }

                    DB::table('validacions')->where('id', $id)->update([
                        'liquidos' => $liquidos,
                        'inflamable' => $inflamable,
                        'proveedores' => $proveedores,
                        'factura' => $archivo,
                        'foto' => $foto,
                        'nombre_pro' => $nombre_pro,
                        'enlace' => $enlace,
                        'contacto' => $contacto,
                        'total_cartones' => $total_cartones,
                        'created_at' => now()
                    ]);
                }
            } else {
                Validacion::where('cotizacion_id', $cotizacion_id)->delete();
                for ($i = 1; $i < $contador; $i++) {

                    if ($request->hasFile('factura' . $i)) {
                        $archivo = $request->file('factura' . $i)->store('docs', 'public');
                    } else {
                        $archivo = 'null';
                    }
                    if ($request->hasFile('foto' . $i)) {
                        $foto = $request->file('foto' . $i)->store('uploads', 'public');
                    } else {
                        $foto = 'null';
                    }

                    if ($request->input('nombre_pro' . $i)) {
                        $nombre_pro = $request->input('nombre_pro' . $i);
                    } else {
                        $nombre_pro = 'null';
                    }
                    if ($request->input('enlace' . $i)) {
                        $enlace = $request->input('enlace' . $i);
                    } else {
                        $enlace = 'null';
                    }
                    if ($request->input('contacto' . $i)) {
                        $contacto = $request->input('contacto' . $i);
                    } else {
                        $contacto = 'null';
                    }
                    if ($request->input('total_cartones' . $i)) {
                        $total_cartones = $request->input('total_cartones' . $i);
                    } else {
                        $total_cartones = 'null';
                    }

                    DB::table('validacions')->insert([
                        'liquidos' => $liquidos,
                        'inflamable' => $inflamable,
                        'proveedores' => $proveedores,
                        'factura' => $archivo,
                        'foto' => $foto,
                        'nombre_pro' => $nombre_pro,
                        'enlace' => $enlace,
                        'contacto' => $contacto,
                        'cotizacion_id' => $cotizacion_id,
                        'total_cartones' => $total_cartones,
                        'created_at' => now()
                    ]);
                }
            }
        }
        return redirect()->route('validacion.print', $cotizacion_id);
        //return redirect()->route('admin.especialistas.show', $usuarioId)->with('mensaje', 'Paso 2 Actualizado');
    }


    public function destroy($id)
    {
        //
    }
}
