<?php

namespace App\Http\Livewire\Tipos;

use App\Models\Tipo;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewTipo extends Component
{
    public $name,$modal=false;
    public function addTipo(){
        $this->validate([
            'name' =>['required']
        ],[
            'name.required' =>'Ingrese el nombre del departamento'
        ]);
        $dato=new Tipo();
        $dato->name=$this->name;
        $dato->save();
        Alert::success('Nuevo registro',$this->name.' ha sido registrado correctamente');
        return redirect()->route('tipos');
    }
    public function render()
    {
        return view('livewire.tipos.new-tipo');
    }
}