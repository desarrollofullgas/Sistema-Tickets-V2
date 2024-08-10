<?php

namespace App\Http\Livewire\Productos\Existencias;

use App\Models\TckServicio;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewServicio extends Component
{
    public $name,$prioridad,$descripcion;
    public function addServicio(){
        $this->validate([
            'name' =>['required'],
            'descripcion' =>['required'],
            'prioridad' =>['required'],
        ],[
            'name.required' => 'Ingrese el nombre del servicio',
            'descripcion.required' => 'Ingrese una descripción',
            'prioridad.required' => 'Seleccione la prioridad',
        ]);
        $servicio=new TckServicio();
        $servicio->name=$this->name;
        $servicio->descripcion=$this->descripcion;
        $servicio->prioridad=$this->prioridad;
        $servicio->save();
        Alert::success('Nuevo servicio', 'El servicio "'.mb_strtoupper($this->name).'" ha sido registrado');
        return redirect()->route('serviciosTCK');
    }
    public function render()
    {
        return view('livewire.productos.existencias.new-servicio');
    }
}
