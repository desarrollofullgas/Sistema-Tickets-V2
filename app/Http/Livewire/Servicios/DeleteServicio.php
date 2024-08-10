<?php

namespace App\Http\Livewire\Servicios;

use App\Models\Servicio;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteServicio extends Component
{
    public $servicioID,$name,$modal=false;
    public function ConfirmDelete(Servicio $dato){
        $this->name=$dato->name;
        $this->modal=true;
    }
    public function deleteServicio(Servicio $servicio){
        $servicio->status="Inactivo";
        $servicio->delete();
        $servicio->save();
        Alert::success("Eliminado","El servicio '".$servicio->name."' ha sido eliminado");
        return redirect()->route('servicios');
    }
    public function render()
    {
        return view('livewire.servicios.delete-servicio');
    }
}