<?php

namespace App\Http\Livewire\Departamentos;

use App\Models\Departamento;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewDepto extends Component
{
    public $modal=false;
    public $name;
    //función para guardar el registro
    public function addDepto(){
        $this->validate([
            'name' =>['required']
        ],[
            'name.required' =>'Ingrese el nombre del departamento'
        ]);
        $dato=new Departamento();
        $dato->name=$this->name;
        $dato->status="Activo";
        $dato->save();
        Alert::success('Nuevo registro',$this->name.' ha sido registrado correctamente');
        return redirect()->route('departamentos');
    }
    public function render()
    {
        return view('livewire.departamentos.new-depto');
    }
}