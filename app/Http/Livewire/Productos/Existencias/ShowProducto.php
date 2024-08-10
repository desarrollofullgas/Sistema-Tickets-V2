<?php

namespace App\Http\Livewire\Productos\Existencias;

use App\Models\Producto;
use Livewire\Component;

class ShowProducto extends Component
{
    public $productoID,$name,$descripcion,$unidad,$modelo,$categoria,$marca,$prioridad,$imagen,$urlImg,$modal=false;
    public function showProducto(Producto $producto){
        $this->name=$producto->name;
        $this->imagen=$producto->product_photo_path;
        $this->categoria=$producto->categoria->name;
        $this->marca=$producto->marca->name;
        $this->modelo=$producto->modelo;
        $this->unidad=$producto->unidad;
        $this->descripcion=$producto->descripcion;
        $this->prioridad=$producto->prioridad;
        $this->modal=true;
    }
    public function render()
    {
        return view('livewire.productos.existencias.show-producto');
    }
}
