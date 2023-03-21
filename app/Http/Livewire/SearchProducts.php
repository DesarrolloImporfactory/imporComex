<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Producto;

class SearchProducts extends Component
{
    public $search;
    public $sort="id";
    public $direction="desc";
   
    public function render()
    {
        $datos = Producto::where('nombre','like','%'.$this->search.'%')->orWhere('valor','like', '%'.$this->search.'%')
        ->orderBy($this->sort, $this->direction)->get();
        return view('livewire.search-products',compact('datos'));
    }

    public function order($sort){
        if($this->sort==$sort){
            if($this->direction=='desc'){
                $this->direction='asc';
            }else{
                $this->direction='desc';
            }
        }else{
            $this->sort=$sort;
            $this->direction='asc';
        }
    
    }
}
