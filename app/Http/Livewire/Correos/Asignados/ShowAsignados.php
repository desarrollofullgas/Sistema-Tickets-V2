<?php

namespace App\Http\Livewire\Correos\Asignados;

use App\Models\Categoria;
use Livewire\Component;

class ShowAsignados extends Component
{
    public $categoriaID,$categoria,$correos,$zonas;
    public function mount(){
        $this->categoria=Categoria::find($this->categoriaID);
        $this->correos=$this->categoria->correos;
        $this->zonas=$this->categoria->zonas;

    }
    public function render()
    {
        return view('livewire.correos.asignados.show-asignados');
    }
}