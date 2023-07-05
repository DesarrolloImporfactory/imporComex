<?php

namespace App\Http\Livewire\Country;

use App\Models\Ciudad;
use App\Models\Country;
use App\Models\Insumo;
use App\Models\Modalidades;
use App\Models\Puerto;
use App\Models\PuertoChina;
use App\Models\Tarifario;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ListCountry extends Component
{
    use WithPagination;
    public $region = 'americas', $tipo, $pais, $modalidad;
    protected $paginationTheme = 'bootstrap';
   

    // public function setPais($value)
    // {
    //     $this->pais = $value;
    // }

    public function render()
    {
        $countryAPI = new Country();
        $countries = $countryAPI->getCountries();
        return view('livewire.country.list-country', compact('countries'));
    }

    protected $rules = [
        'tipo' => 'required',
        'pais' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function create()
    {
        $this->validate();

        $mensajes = [
            'modalidad' => $this->tipo,
            'pais' => $this->pais,
        ];
        session()->put('mensajes', $mensajes);
        return redirect()->route('admin.colombia.create');
    }
}
