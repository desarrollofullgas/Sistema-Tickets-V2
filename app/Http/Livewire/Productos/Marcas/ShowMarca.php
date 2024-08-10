<?php

namespace App\Http\Livewire\Productos\Marcas;

use App\Models\Marca;
use Livewire\Component;

class ShowMarca extends Component
{
    public $marcaID,$marca,$modal=false;
    public function showMarca(Marca $marca){
        $this->marca = $marca;
        $this->modal = true;
    }
    public function render()
    {
        return view('livewire.productos.marcas.show-marca');
    }
}
