<?php

namespace App\Http\Livewire\Prioridades;

use App\Models\Prioridad;
use Livewire\Component;

class ShowPrioridad extends Component
{
    public $prioridadID,$prioridad,$modal=false;
    public function showPrioridad(Prioridad $dato){
        $this->prioridad = $dato;
        $this->modal=true;
    }
    public function render()
    {
        return view('livewire.prioridades.show-prioridad');
    }
}