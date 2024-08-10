<?php

namespace App\Http\Livewire\Areas;

use App\Models\Areas;
use App\Models\Departamento;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditArea extends Component
{
    public $areaID;
    public $modal=false;
    public $area,$depto,$deptoName,$status;
    //funcion para cargar los datos del registro
    public function editArea(Areas $area){
        $this->modal=true;
        $this->area=$area->name;
        $this->depto=$area->departamento_id;
        $this->status=$area->status;
        //$this->deptoName=Departamento::find($area->departamento_id)->name;
    }
    //función para actualizar el registro
    public function updateArea(Areas $area){
        $this->validate([
            'area' =>['required','not_in:0'],
            'depto' =>['required']
        ],[
            'area.required' =>'Ingrese un nombre para el área',
            'depto.required' =>'Seleccione un departamento'
        ]);
        $area->name = $this->area;
        $area->departamento_id=$this->depto;
        $area->status=$this->status;
        $area->save();
        Alert::success('Actualización realizada','Los datos del registro se actualizaron con éxito');
        return redirect()->route('areas');
    }
    public function render()
    {
        $departamentos=Departamento::all()->where('status','Activo');
        return view('livewire.areas.edit-area',compact('departamentos'));
    }
}