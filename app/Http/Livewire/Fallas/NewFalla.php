<?php

namespace App\Http\Livewire\Fallas;

use App\Models\Falla;
use App\Models\Prioridad;
use App\Models\Servicio;
use App\Models\Tipo;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewFalla extends Component
{
    public $name,$servicio,$prioridad,$tipo,$prioridades,$modal=false;

    public function updatedTipo($id)
    { 
        $this->prioridades = Prioridad::where('tipo_id', $id)->get();
    }

    public function addFalla(){
        $this->validate([
            'name' =>['required'],
            'servicio' =>['required','not_in:0'],
            'prioridad' =>['required','not_in:0']
        ],[
            'name.required' =>'Ingrese un nombre para la falla',
            'servicio.required' =>'Seleccione un servicio',
            'prioridad.required' =>'Seleccione una prioridad',
        ]);
        $dato=new Falla();
        $dato->name=$this->name;
        $dato->servicio_id=$this->servicio;
        $dato->prioridad_id=$this->prioridad;
        $dato->save();
        Alert::success('Nueva falla', "La falla '".$this->name."' ha sido registrado con éxito");
        return redirect()->route('fallas');
    }
    
    public function render()
    {
        $tipos=Tipo::where('status','Activo')->get();
        $servicios=Servicio::where('status','Activo')->get();
        $prioridades=Prioridad::where('status','Activo')->get();
        return view('livewire.fallas.new-falla',compact('servicios','tipos','prioridades'));
    }
}