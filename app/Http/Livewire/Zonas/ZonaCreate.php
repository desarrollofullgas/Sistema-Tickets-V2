<?php

namespace App\Http\Livewire\Zonas;

use App\Models\Region;
use Livewire\Component;
use App\Models\Zona;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ZonaCreate extends Component
{
    public $newgZona;
    public $name, $region;

    public function resetFilters()
    {
        $this->reset(['name']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->newgZona = false;
    }

    public function showModalFormZona()
    {

        $this->resetFilters();

        $this->newgZona = true;
    }

    public function addZona()
    {
        $this->validate(
            [
                'name' => ['required', 'min:3', 'max:250'],
                'region' => ['required'],
            ],
            [
                'name.required' => 'El Nombre de la Zona es obligatorio',
                'name.max' => 'El Nombre de la Zona no debe ser mayor a 250 caracteres',
                'name.min' => 'El Nombre de la Zona debe ser mayor a 3 caracteres',
                'region.required' => 'La Región es obligatoria',
            ]
        );

        $zona = Zona::create([
            'name' => $this->name,
        ]);
        $zona->regions()->attach($this->region);

        $this->mount();


        //Alert::success('Nueva Zona', "La Zona". ' '.$this->name. ' '. "ha sido agregada al sistema");
        session()->flash('flash.banner', 'Nueva Zona, la zona "' . $this->name . '" ha sido agregada al sistema.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('zonas');
    }
    public function render()
    {
        $regions = Region::where('status', 'Activo')->whereNotIn('id', [1,2])->get(); // Regiones
        return view('livewire.zonas.zona-create',['regions' => $regions]);
    }
}
