<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizaciones;
use App\Models\Validacion;
use PDF;
use Illuminate\Support\Facades\DB;


class ReportesController extends Controller
{
    public function pdfTicket(Request $request, $id)
    {
        $cotizacion = Cotizaciones::whereid($id)->with(['validacions', 'modalidad', 'carga', 'pais', 'usuario'])->first();
        $carbon = new \Carbon\Carbon();
        $barcode = $cotizacion->id;
        $proveedores = Validacion::wherecotizacion_id($id)->get();
        $inBackground = false;
        $data = [
            'cotizacion' => $cotizacion,
            'barcode' => $barcode,
            'proveedores' => $proveedores,
            'inBackground' => $inBackground
        ];
        $pdf = PDF::loadView('reportes.pdfTicket', $data);
        return $pdf->download($carbon . 'ticket.pdf');
    }
    public function pdfCotizacion(Request $request, $id)
    {
        $cotizacion = Cotizaciones::whereid($id)->with(['validacions', 'modalidad', 'carga', 'pais', 'usuario'])->first();
        $carbon = new \Carbon\Carbon();
        $inBackground = false;
        $data = [
            'cotizacion' => $cotizacion,
            'carbon' => $carbon,
            'inBackground' => $inBackground
        ];
        $pdf = PDF::loadView('reportes.pdfCotizacion', $data);
        return $pdf->download($carbon . 'cotizacion.pdf');
    }

    public function update(Request $request, $id)
    {

        $total = $request->input('estado');
        $total1 = 0;
        $contador = count($total);
        $usuario_id = $request->input('usuario_id');

        for ($i = 1; $i <= $contador; $i++) {
            if ($request->input('impuesto' . $i)) {
                $id_inpuesto = $request->input('impuesto' . $i);
            } else {
                $id_inpuesto = null;
            }
            if ($request->input('valor' . $i)) {
                $valor = $request->input('valor' . $i);
            } else {
                $valor = null;
            }
            DB::table('cotizacion_impuestos')->insert([
                'cotizacion_id' => $id,
                'impuesto_id' => $id_inpuesto,
                'usuario_id' => $usuario_id,
                'valor' => $valor,
            ]);
            $total1 = $total1 + $valor;
        }
        $totalCotizacion = Cotizaciones::whereid($id)->first();
        $valorTotal = $totalCotizacion->total_logistica;
        $datos = array(
            "total_impuesto" => $total1,
            "total"=>$total1+$valorTotal
        );

        Cotizaciones::whereid($id)->update($datos);

        return redirect()->route('validacion.print',$id)->with('mensaje','Calculo d eimpuestos realizado!');
    }
}
