<?php

namespace App\Http\Livewire\Regiones;

use App\Models\Region;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteRegion extends Component
{
    public $regionID,$name,$modal=false;

    public function ConfirmDelete(Region $region){
        $this->name = $region->name;
        $this->modal = true;
    }
    public function deleteRegion(Region $region){
        $region->status = "Inactivo";
        $region->delete();
        $region->save();
        Alert::success("Eliminado","La region '".$region->name."' ha sido eliminada");
        return redirect()->route('regiones');
    }
    public function render()
    {
        return view('livewire.regiones.delete-region');
    }
}