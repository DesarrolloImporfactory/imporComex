<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Cotizaciones;
use App\Models\Insumo;
use App\Models\PuertoChina;
use App\Models\User;
use App\Models\Variables;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AprobarCotizacion as EmailUsuario;
use PDF;

class AprobarCotizacion extends Component
{
    public $idCotizacion, $boton = false, $email, $usuario;
    public function mount($idCotizacion)
    {
        $this->idCotizacion = $idCotizacion;
        $cotizacion = Cotizaciones::findOrFail($this->idCotizacion);
        $this->usuario = User::findOrFail($cotizacion->usuario_id);
        // $this->email = $usuario->email;
        if ($cotizacion->estado == 'Aprobado') {
            $this->boton = true;
        } else {
            $this->boton = false;
        }
    }
    public function render()
    {
        return view('livewire.aprobar-cotizacion');
    }

    
    public function aprobar(String $valor)
    {
        try {
            if ($valor == 'Aprobado') {
                $this->boton = true;
                $pdfPath = $this->sendCotizacion($this->idCotizacion);
                $emails = [$this->usuario->email,'cargas@imporfactoryusa.com','insidesales2@hacargo.com'];
    
                $notification = new EmailUsuario($pdfPath);
    
                Notification::route('mail', $emails)->notify($notification);
    
                $this->emit('alert', 'La cotización ha sido enviada a su correo electrónico.');
            } else {
                $this->boton = false;
                $this->emit('alert', 'La cotización ha sido cancelada!');
            }
            
            Cotizaciones::where('id', $this->idCotizacion)->update([
                'estado' => $valor
            ]);
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    

    public function sendCotizacion($id)
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
        $fileName = $carbon . 'cotizacion.pdf';
        $storagePath = public_path('pdf/' . $fileName);
        $pdf->save($storagePath);
        return $storagePath;
    }
}
