<?php

namespace App\Http\Livewire\Prioridades;

use App\Models\Prioridad;
use App\Models\Tipo;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewPrioridad extends Component
{
    public $name,$tipo,$tiempo,$modal=false;
    //funcion para añadir una nueva prioridad
    public function addPrioridad(){
        $this->validate([
            'name' =>['required','not_in:0'],
            'tipo' =>['required','not_in:0'],
            'tiempo' =>['required','gt:0'],
        ],[
            'name.required' =>'Seleccione un nivel de prioridad',
            'tipo.required' =>'Seleccione el tipo de ticket',
            'tiempo.required' =>'El tiempo es requerido',
            'tiempo.gt' =>'La cantidad de horas debe ser mayor a cero'
        ]);
        $find=Prioridad::where('name',$this->name)->where('tipo_id',$this->tipo);
        if($find->count() > 0){
            Alert::error('Prioridad existente', "Ya existe una prioridad del mismo tipo y nivel");
        }
        else{
            $registro=new Prioridad();
            $registro->name=$this->name;
            $registro->tipo_id=$this->tipo;
            $registro->tiempo=$this->tiempo;
            $registro->save();
            Alert::success('Nueva Prioridad', "Los datos han sido registrados ");
        }
        return redirect()->route('prioridades');
    }
    public function render()
    {
        $tipos=Tipo::all()->where('status','Activo');
        return view('livewire.prioridades.new-prioridad',compact('tipos'));
    }
}