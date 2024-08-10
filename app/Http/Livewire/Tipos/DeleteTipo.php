<?php

namespace App\Http\Livewire\Tipos;

use App\Models\Tipo;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteTipo extends Component
{
    public $tipoID,$name,$modal=false;
    //función para el modal
    public function ConfirmDelete(Tipo $dato){
        $this->name = $dato->name;
        $this->modal=true;
    }
    //función para eliminar el tipo de ticket(cambio de estado)
    public function deleteTipo(Tipo $dato){
        $dato->status="Inactivo";
        $dato->delete();
        $dato->save();
        Alert::success("Eliminado","El tipo de ticket ha sido eliminado");
        return redirect()->route('tipos');
    }
    public function render()
    {
        return view('livewire.tipos.delete-tipo');
    }
}