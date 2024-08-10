<?php

namespace App\Http\Livewire\Regiones;

use App\Models\Region;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewRegion extends Component
{
    public $modal=false;
    public $region;

    public function addRegion(){
        $this->validate([
            'region' => ['required'],
        ],[
            'region.required' => 'Ingrese el nombre de la región'
        ]);
        $data=new Region();
        $data->name=$this->region;
        $data->save();
        Alert::success('Nueva región','La región '.$this->region.' ha sido registrada');
        return redirect()->route('regiones');
    }
    public function render()
    {
        return view('livewire.regiones.new-region');
    }
}