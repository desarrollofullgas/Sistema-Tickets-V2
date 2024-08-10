<?php

namespace App\Http\Livewire\Servicios;

use App\Models\Departamento;
use App\Models\Servicio;
use App\Models\Tipo;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewServicio extends Component
{
    public $name,$prioridad,$area,$modal=false;
    public function addServicio(){
        $this->validate([
            'name'=>['required','min:1'],
            'area'=>['required','not_in:0']
        ],[
            'name.required'=>'Ingrese el nombre del servicio',
            'area.required'=>'Seleccione un área'
        ]);
        $dato=new Servicio();
        $dato->name=$this->name;
        $dato->area_id=$this->area;
        $dato->save();
        
        Alert::success('Nuevo Servicio', "El servicio ".$this->name." ha sido registrado con éxito");
        return redirect()->route('servicios');
    }
    public function render()
    {
        $deptos=Departamento::all()->where('status','Activo');
        return view('livewire.servicios.new-servicio',compact('deptos'));
    }
}