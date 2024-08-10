<?php

namespace App\Http\Livewire\Areas;

use App\Models\Areas;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteArea extends Component
{
    public $modal=false;
    public $areaID,$areaName;
    //funcion para mostrar el modal con el nombre del área a eliminar
    public function ConfirmDelete(Areas $area){
        $this->areaName=$area->name;
        $this->modal=true;
    }
    //funcion para eliminar (cambio de estado) el registro
    public function deleteArea(Areas $area){
        $area->status="Inactivo";
        $area->delete();
        $area->save();
        Alert::success("Eliminado","El área '".$area->name."' ha sido eliminada");
        return redirect()->route('areas');
    }
    public function render()
    {
        return view('livewire.areas.delete-area');
    }
}