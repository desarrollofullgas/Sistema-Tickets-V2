<?php

namespace App\Http\Livewire\Productos\Existencias;

use App\Models\TckServicio;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditServicio extends Component
{
    public $servicioID,$name,$descripcion,$prioridad;
    public function mount(){
        $servicio=TckServicio::find($this->servicioID);
        $this->name=$servicio->name;
        $this->descripcion=$servicio->descripcion;
        $this->prioridad=$servicio->prioridad;
    }
    public function updateServicio(TckServicio $servicio){
        $this->validate([
            'name' =>['required'],
            'descripcion' =>['required'],
            'prioridad' =>['required'],
        ],[
            'name.required' => 'Ingrese el nombre del servicio',
            'descripcion.required' => 'Ingrese una descripción',
            'prioridad.required' => 'Seleccione una prioridad',
        ]);
        $servicio->name=$this->name;
        $servicio->descripcion=$this->descripcion;
        $servicio->prioridad=$this->prioridad;
        $servicio->save();
        Alert::success('Servicio actualizado', 'La información del registro ha sido actualizada');
        // return redirect()->route('serviciosTCK');
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.productos.existencias.edit-servicio');
    }
}
