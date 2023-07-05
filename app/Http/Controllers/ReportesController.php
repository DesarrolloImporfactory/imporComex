<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Cotizaciones;
use App\Models\Validacion;
use App\Models\cotizacion_impuesto;
use App\Models\Insumo;
use PDF;
use App\Models\ProductoInsumo;
use App\Models\PuertoChina;
use App\Models\Variables;
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
        return $pdf->stream($carbon . 'ticket.pdf');
    }

    public function cotizacionPrint($id)
    {
        $carbon = new \Carbon\Carbon();
        $categoria = Categoria::all();
        $insumo = Insumo::all();
        $cotizacion = Cotizaciones::whereid($id)->with(['carga', 'pais', 'modalidad', 'gastos', 'incoterms'])->first();
        $otrosGastos = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Otros gastos')->get();
        $gastosOrigen = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Gastos origen')->get();
        $gastosLocalesCompuesta = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Gastos locales compuesta')->get();
        $gastosLocaleSimple = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Gastos locales simple')->get();
        $incoterm = PuertoChina::findOrFail($cotizacion->incoterms->puerto_id);
        $mensaje = "true";
        $data = [
            'categoria' => $categoria,
            'insumo' => $insumo,
            'cotizacion' => $cotizacion,
            'mensaje' => $mensaje,
            'otrosGastos' => $otrosGastos,
            'gastosOrigen' => $gastosOrigen,
            'gastoSimple' => $gastosLocaleSimple,
            'gastosCompuesta' => $gastosLocalesCompuesta,
            'incoterm' => $incoterm
        ];
        $pdf = PDF::loadView('admin.calculadoras.cotizacionPrint', $data);

        return $pdf->stream($carbon . 'cotizacion.pdf');
    }

    

    public function pdfCotizacion(Request $request, $id)
    {
        $cotizacion = Cotizaciones::whereid($id)->with(['validacions', 'modalidad', 'carga', 'pais', 'usuario', 'ciudad'])->first();
        $carbon = new \Carbon\Carbon();
        $productos = ProductoInsumo::wherecotizacion_id($id)->with('insumo')->get();
        $inBackground = false;
        $data = [
            'cotizacion' => $cotizacion,
            'carbon' => $carbon,
            'inBackground' => $inBackground,
            'productos' => $productos
        ];
        $pdf = PDF::loadView('reportes.pdfCotizacion', $data);
        return $pdf->stream($carbon . 'cotizacion.pdf');
    }

    public function cotizacionDownload(Request $request, $id)
    {
        $cotizacion = Cotizaciones::whereid($id)->with(['validacions', 'modalidad', 'carga', 'pais', 'usuario', 'ciudad'])->first();
        $carbon = new \Carbon\Carbon();
        $productos = ProductoInsumo::wherecotizacion_id($id)->with('insumo')->get();
        $inBackground = false;
        $data = [
            'cotizacion' => $cotizacion,
            'carbon' => $carbon,
            'inBackground' => $inBackground,
            'productos' => $productos
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
        $relacion = cotizacion_impuesto::where('cotizacion_id', $id)->exists();
        if ($relacion == 1) {
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
                DB::table('cotizacion_impuestos')->where('impuesto_id', $id_inpuesto)->where('cotizacion_id', $id)->update([

                    'valor' => $valor,
                ]);
                $total1 = $total1 + $valor;
            }
        } else {
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
        }
        $totalCotizacion = Cotizaciones::whereid($id)->first();
        $valorTotal = $totalCotizacion->total_logistica;
        $datos = array(
            "total_impuesto" => $total1,
            "total" => $total1 + $valorTotal
        );

        Cotizaciones::whereid($id)->update($datos);

        return redirect()->route('validacion.print', $id)->with('mensaje', 'Calculo de impuestos realizado!');
    }
}
