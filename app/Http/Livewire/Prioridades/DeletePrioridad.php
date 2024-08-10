<?php

namespace App\Http\Livewire\Prioridades;

use App\Models\Prioridad;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeletePrioridad extends Component
{
    public $prioridadID,$modal=false;
    public function ConfirmDelete(){
        $this->modal=true;
    }
    public function deletePrioridad(Prioridad $dato){
        $dato->status='Inactivo';
        $dato->delete();
        $dato->save();
        Alert::success('Registro eliminado','La prioridad ha sido eliminada');
        return redirect()->route('prioridades');
    }
    public function render()
    {
        return view('livewire.prioridades.delete-prioridad');
    }
}