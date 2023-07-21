<?php

namespace App\Http\Livewire\Email;

use App\Models\Email;
use Livewire\Component;
use Livewire\WithPagination;

class AdminEmails extends Component
{
    use WithPagination;
    public $archivo;
    protected $paginationTheme = 'bootstrap';
    public $sort = "id", $direction = "asc";
    public $search = '', $paginate = '10', $idEmail;
    protected $listeners = ['delete'];
    public $email;

    public function render()
    {
        $emails = Email::where('id', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')->orderBy($this->sort, $this->direction)->paginate(10);
        return view('livewire.email.admin-emails', compact('emails'));
    }
    public $rules = [
        'email' => 'required|string|min:2|max:50|unique:imporcomex.emails,email',
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
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
            Email::create([
                'email' => $this->email,
            ]);
            $this->reset(['email']);
            $this->emit('alert', 'Registro creado con exito!.');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function show(Int $id)
    {
        try {
            $email = Email::findOrFail($id);
            $this->email = $email->email;
            $this->idEmail = $email->id;
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function update()
    {
        $this->validate([
            'email' => 'required'
        ]);
        try {
            Email::where('id', $this->idEmail)->update([
                'email' => $this->email,
            ]);
            $this->reset(['email']);
            $this->emit('alert', 'Registro update con exito!.');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function delete(Int $id)
    {
        try {
            Email::destroy($id);
            $this->emit('alert', 'Registro eliminado con exito!.');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
}
