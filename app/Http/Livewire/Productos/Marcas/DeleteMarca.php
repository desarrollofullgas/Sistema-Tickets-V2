<?php

namespace App\Http\Livewire\Productos\Marcas;

use App\Models\Marca;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteMarca extends Component
{
    public $marcaID,$modal=false;
    public $mName;
    public function ConfirmDelete($id){
        $supplier=Marca::find($id);
        $this->mName=$supplier->name;
        $this->modal=true;
    }
    public function deleteMarca(Marca $marca){
        $marca->delete();
        Alert::success("Eliminado","La Marca ha sido eliminada");
        return redirect()->route('marcas');
    }
    public function render()
    {
        return view('livewire.productos.marcas.delete-marca');
    }
}
