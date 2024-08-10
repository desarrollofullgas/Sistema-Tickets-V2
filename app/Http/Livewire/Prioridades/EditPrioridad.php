<?php

namespace App\Http\Livewire\Prioridades;

use App\Models\Prioridad;
use App\Models\Tipo;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditPrioridad extends Component
{
    public $prioridadID,$name,$tipo,$tiempo,$modal=false;

    public function editPrioridad(Prioridad $data){
        $this->name = $data->name;
        $this->tipo = $data->tipo_id;
        $this->tiempo = $data->tiempo;
        $this->modal = true;
    }

    public function updatePrioridad(Prioridad $data){
        $this->validate([
            'tiempo' =>['required','gt:0'],
        ],[
            'tiempo.gt' =>'La cantidad de horas debe ser mayor a cero'
        ]);
        $data->name = $this->name;
        $data->tipo_id = $this->tipo;
        $data->tiempo = $this->tiempo;
        $data->save();
        Alert::success('Actualización realizada','Los datos del registro se actualizaron con éxito');
        // return redirect()->route('prioridades');
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        $tipos=Tipo::all()->where('status','Activo');
        return view('livewire.prioridades.edit-prioridad',compact('tipos'));
    }
}