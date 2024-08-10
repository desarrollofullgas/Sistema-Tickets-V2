<?php

namespace App\Http\Livewire\Productos\Marcas;

use App\Models\Marca;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewMarca extends Component
{
    public $name,$modal=false;
    public function addMarca(){
        $this->validate([
            'name' =>['required']
        ],[
            'name.required' =>'Ingrese el nombre de la clase del produco'
        ]);
        $marca=new Marca();
        $marca->name=$this->name;
        $marca->save();
        Alert::success('Nuevo registro','La marca "'.$this->name.'" ha sido registrada correctamente');
        return redirect()->route('marcas');
    }
    public function render()
    {
        return view('livewire.productos.marcas.new-marca');
    }
}
