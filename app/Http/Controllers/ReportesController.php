<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizaciones;
use PDF;


class ReportesController extends Controller
{
    public function pdfTicket(Request $request, $id){
        $cotizacion = Cotizaciones::whereid($id)->with(['validacions','modalidad','carga','pais','usuario'])->first();
        $carbon = new \Carbon\Carbon();
        $data=[
            'cotizacion'=>$cotizacion,
            
        ];
         $pdf = PDF::loadView('reportes.pdfTicket');
        return $pdf->download($carbon.'ticket.pdf');
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->stream();
    }
    public function pdfCotizacion(Request $request, $id){
        $cotizacion = Cotizaciones::whereid($id)->with(['validacions','modalidad','carga','pais','usuario'])->first();
        $carbon = new \Carbon\Carbon();
        $data=[
            'cotizacion'=>$cotizacion,
            'carbon'=>$carbon
        ];
         $pdf = PDF::loadView('reportes.pdfCotizacion', $data);
        return $pdf->download($carbon.'cotizacion.pdf');
    }
}
