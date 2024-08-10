<?php

namespace App\Http\Livewire\Productos\Almacen;

use App\Models\AlmacenCi;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteAlmacen extends Component
{
    public $idAlma,$name;
    public function mount(){
        $p=AlmacenCi::find($this->idAlma);
        $this->name = $p->producto->name;
    }
    public function deleteAlma(AlmacenCi $reg){
        $reg->delete();
        Alert::warning('Producto eliminado', 'El producto ha sido eliminado del almacén');
        return redirect()->route('almacenCIS');
    }

    public function render()
    {
        return view('livewire.productos.almacen.delete-almacen');
    }
}
