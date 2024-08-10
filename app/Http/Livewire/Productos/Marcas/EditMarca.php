<?php

namespace App\Http\Livewire\Productos\Marcas;

use App\Models\Marca;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditMarca extends Component
{
    public $marcaID,
    $status,$name,$modal=false;
    public function editMarca(Marca $marca){
        $this->name = $marca->name;
        $this->status = $marca->status;
        $this->modal=true;
    }
    public function updateMarca(Marca $marca){
        $this->validate([
            'name' =>['required']
        ],[
            'name.required' =>'Ingrese el nombre de la clase del produco'
        ]);
        $marca->name=$this->name;
        $marca->status=$this->status;
        $marca->save();
        Alert::success('Actualización realizada','Los datos del registro se actualizaron con éxito');
        // return redirect()->route('marcas');
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.productos.marcas.edit-marca');
    }
}
