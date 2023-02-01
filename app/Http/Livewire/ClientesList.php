<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;



class ClientesList extends Component
{

    protected $listeners = ['render' => 'render'];

    public function render()
    {
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();
        return view('livewire.clientes-list', compact('clientes'));
    }
}
