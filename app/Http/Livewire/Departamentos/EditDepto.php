<?php

namespace App\Http\Livewire\Departamentos;

use App\Models\Departamento;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditDepto extends Component
{
    public $deptoID,$name,$status,$modal=false;
    //obtenemos la información del registro
    public function editDepto(Departamento $depto){
        $this->name=$depto->name;
        $this->status=$depto->status;
        $this->modal=true;
    }
    //actualizamos la información del registro
    public function updateDepto(Departamento $depto){
        $this->validate([
            'name' =>['required']
        ],[
            'name.required' =>'Ingrese un nombre para el departamento'
        ]);
        $depto->name=$this->name;
        $depto->status=$this->status;
        $depto->save();
        Alert::success('Actualización realizada','Los datos del registro se actualizaron con éxito');
        // return redirect()->route('departamentos');
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.departamentos.edit-depto');
    }
}