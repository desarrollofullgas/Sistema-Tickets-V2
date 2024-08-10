<?php

namespace App\Http\Livewire\Fallas;

use App\Models\Areas;
use App\Models\Falla;
use App\Models\Servicio;
use App\Models\Tipo;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditFalla extends Component
{
    public $fallaID,$name,$servicio,$prioridad,$modal=false;
    public function editFalla(Falla $falla){
        $this->name = $falla->name;
        $this->prioridad=$falla->prioridad_id;
        $this->servicio = $falla->servicio_id;
        $this->modal=true;
    }
    public function updateFalla(Falla $falla){
        $this->validate([
            'name' =>['required'],
            'servicio' =>['required','not_in:0'],
            'prioridad' =>['required','not_in:0']
        ],[
            'name.required' =>'Ingrese un nombre para la falla',
            'servicio.required' =>'Seleccione un servicio',
            'prioridad.required' =>'Seleccione una prioridad',
        ]);
        $falla->name=$this->name;
        $falla->servicio_id=$this->servicio;
        $falla->prioridad_id=$this->prioridad;
        $falla->save();
        Alert::success('Actualización realizada','Los datos del registro se actualizaron con éxito');
        // return redirect()->route('fallas');
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        $tipos=Tipo::all()->where('status','Activo');
        $areas=Areas::all()->where('status','Activo');
        return view('livewire.fallas.edit-falla',compact('areas','tipos'));
    }
}