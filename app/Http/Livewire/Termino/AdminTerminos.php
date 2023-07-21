<?php

namespace App\Http\Livewire\Termino;

use App\Models\PuertoChina;
use Livewire\Component;

class AdminTerminos extends Component
{
    public $sort = 'id', $direction = 'asc', $search = '';
    public $name, $idProveedor, $direccion, $email;
    protected $listeners = ['delete'];

    public function render()
    {
        $terminos = PuertoChina::where('name', 'like', '%' . $this->search . '%')->orWhere('id', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)->paginate(10);
        return view('livewire.termino.admin-terminos', compact('terminos'));
    }
    public function order($valor)
    {
        if ($this->sort == $valor) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $valor;
            $this->direction = 'asc';
        }
    }
    public function create()
    {
        $this->validate();
        try {
            PuertoChina::create([
                'name' => $this->name,
            ]);
            $this->reset(['name']);
            $this->emit('alert', 'Registro creado con exito!.');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public $rules = [
        'name' => 'required|string|min:2|max:20',
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function show(Int $id)
    {
        try {
            $categoria = PuertoChina::findOrFail($id);
            $this->name = $categoria->name;
            $this->idProveedor = $categoria->id;
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function update()
    {
        $this->validate([
            'name' => 'required|string|min:2|max:20',
        ]);
        try {
            PuertoChina::where('id', $this->idProveedor)->update([
                'name' => $this->name,
                'direccion' => $this->direccion,
                'email' => $this->email
            ]);
            $this->reset(['name']);
            $this->emit('alert', 'Registro update con exito!.');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function delete(Int $id)
    {
        try {
            PuertoChina::destroy($id);
            $this->emit('alert', 'Registro eliminado con exito!.');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
}
