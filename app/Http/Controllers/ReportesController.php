<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizaciones;
use App\Models\Validacion;
use PDF;


class ReportesController extends Controller
{
    public function pdfTicket(Request $request, $id){
        $cotizacion = Cotizaciones::whereid($id)->with(['validacions','modalidad','carga','pais','usuario'])->first();
        $carbon = new \Carbon\Carbon();
        $id= $cotizacion->id;
        $proveedores = Validacion::wherecotizacion_id($id)->get();
        $inBackground=false;
        $data=[
            'cotizacion'=>$cotizacion,
            'id'=>$id,
            'proveedores'=>$proveedores,
            'inBackground'=>$inBackground
        ];
         $pdf = PDF::loadView('reportes.pdfTicket',$data);
        return $pdf->download($carbon.'ticket.pdf');
       
    }
    public function pdfCotizacion(Request $request, $id){
        $cotizacion = Cotizaciones::whereid($id)->with(['validacions','modalidad','carga','pais','usuario'])->first();
        $carbon = new \Carbon\Carbon();
        $inBackground=false;
        $data=[
            'cotizacion'=>$cotizacion,
            'carbon'=>$carbon,
            'inBackground'=>$inBackground
        ];
         $pdf = PDF::loadView('reportes.pdfCotizacion', $data);
        return $pdf->download($carbon.'cotizacion.pdf');
    }
}
