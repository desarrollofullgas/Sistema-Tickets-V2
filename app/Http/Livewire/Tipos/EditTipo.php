<?php

namespace App\Http\Livewire\Tipos;

use App\Models\Tipo;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditTipo extends Component
{
    public $tipoID,$name,$status,$modal=false;
    public function editTipo(Tipo $tipo){
        $this->name = $tipo->name;
        $this->status = $tipo->status;
        $this->modal = true;
    }
    public function updateTipo(Tipo $tipo){
        $this->validate([
            'name' =>['required']
        ],[
            'name.required' =>'Ingrese un nombre para el departamento'
        ]);
        $tipo->name=$this->name;
        $tipo->status=$this->status;
        $tipo->save();
        Alert::success('Actualización realizada','Los datos del registro se actualizaron con éxito');
        return redirect()->route('tipos');
    }
    public function render()
    {
        return view('livewire.tipos.edit-tipo');
    }
}