<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use Livewire\Component;

class CreateProducts extends Component
{
    
    public $nombre,$cantidad,$precio,$categoria_id;
    protected $rules = [
        'nombre'=>'required',
        'cantidad'=>'required',
        'precio'=>'required',
        'categoria_id'=>'required',
    ];
    public $open;

    public function addNew($open){
        $this->open=$open;
        if($open==true){
            $this->dispatchBrowserEvent('show-form');
        }else{
            $this->dispatchBrowserEvent('keyboard-form');
        }
        
    }

    public function save(){
        
        $this->validate();
        $datos = new Producto();
        $datos->nombre=$this->nombre;
        $datos->cantidad=$this->cantidad;
        $datos->precio=$this->precio;
        $datos->categoria_id=$this->categoria_id;
        if($datos->save()){
           $this->addNew(false);
        }else{
            $this->addNew(true);
        }
    }
    

    public function render()
    {
        $datos = Categoria::all();
        return view('livewire.create-products', compact('datos'));
    }
}
