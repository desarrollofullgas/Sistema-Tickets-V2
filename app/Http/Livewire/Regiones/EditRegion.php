<?php

namespace App\Http\Livewire\Regiones;

use App\Models\Region;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditRegion extends Component
{
    public $regionID,$name,$status,$modal=false;
    //función para obtener datos del registro
    public function editRegion(Region $region){
        $this->name=$region->name;
        $this->status=$region->status;
        $this->modal=true;
    }
    //funcion para actualizar el registro
    public function updateRegion(Region $region){
        $this->validate([
            'name' =>['required']
        ],[
            'name.required' =>'Ingrese un nombre para la región'
        ]);
        $region->name=$this->name;
        $region->status=$this->status;
        $region->save();
        Alert::success('Actualización realizada','Los datos del registro se actualizaron con éxito');
        //return redirect()->route('regiones');
		 return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.regiones.edit-region');
    }
}