<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Cotizaciones as cotizacion;

class Cotizaciones extends Component
{

    //public $datos;
    protected $listeners = ['postAdded' => 'render'];

    public function render()
    {
        //$this->datos=cotizacion::count();
        $datos=cotizacion::count();
        return view('livewire.dashboard.cotizaciones',compact('datos'));
        
    }
}
