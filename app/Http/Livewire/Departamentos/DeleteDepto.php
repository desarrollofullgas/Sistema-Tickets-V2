<?php

namespace App\Http\Livewire\Departamentos;

use App\Models\Departamento;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteDepto extends Component
{
    public $deptoID,$name,$modal=false;
    //función para el modal
    public function ConfirmDelete(Departamento $depto){
        $this->name = $depto->name;
        $this->modal=true;
    }
    //función para eliminar el departamento(cambio de estado)
    public function deleteDepto(Departamento $depto){
        $depto->status="Inactivo";
        $depto->delete();
        $depto->save();
        Alert::success("Eliminado","El departamento '".$depto->name."' ha sido eliminado");
        return redirect()->route('departamentos');
    }
    public function render()
    {
        return view('livewire.departamentos.delete-depto');
    }
}