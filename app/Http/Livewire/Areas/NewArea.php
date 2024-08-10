<?php

namespace App\Http\Livewire\Areas;

use App\Models\Areas;
use App\Models\Departamento;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewArea extends Component
{
    public $modal=false;
    public $area,$depto;
    public function addArea(){
        $this->validate([
            'area' =>['required','not_in:0'],
            'depto' =>['required']
        ],[
            'area.required' =>'Ingrese un nombre para el área',
            'depto.required' =>'Seleccione un departamento'
        ]);
        $dato=new Areas();
        $dato->name=$this->area;
        $dato->departamento_id=$this->depto;
        $dato->status="Activo";
        $dato->save();
        Alert::success('Nueva Área', "El area ".$this->area." ha sido registrada con éxito");
        return redirect()->route('areas');
    }
    public function render()
    {
        $departamentos=Departamento::all()->where('status','Activo');
        return view('livewire.areas.new-area',compact('departamentos'));
    }
}