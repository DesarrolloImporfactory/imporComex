<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use Livewire\Component;

class CreateProducts extends Component
{
    protected $listeners = ['modal' => 'modalAbrir'];
    public $nombre, $cantidad, $precio, $categoria_id;
    protected $rules = [
        'nombre' => 'required',
        'cantidad' => 'required',
        'precio' => 'required',
        'categoria_id' => 'required',
    ];
    public $open;

    public function modalAbrir()
    {
        //dd('hola');
        $this->dispatchBrowserEvent('show-form');
    }

    public function save()
    {
        try {
            $this->validate();
            $datos = new Producto();
            $datos->nombre = $this->nombre;
            $datos->cantidad = $this->cantidad;
            $datos->precio = $this->precio;
            $datos->categoria_id = $this->categoria_id;
            $datos->save();
            $this->dispatchBrowserEvent('close');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('show');
        }
    }


    public function render()
    {
        $datos = Categoria::all();
        return view('livewire.create-products', compact('datos'));
    }
}
