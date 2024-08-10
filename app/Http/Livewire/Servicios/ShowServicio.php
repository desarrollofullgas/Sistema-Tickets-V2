<?php

namespace App\Http\Livewire\Servicios;

use App\Models\Servicio;
use Livewire\Component;

class ShowServicio extends Component
{
    public $servicioID,$servicio,$modal=false;
    public function showServicio(Servicio $dato){
        $this->servicio = $dato;
        $this->modal=true;
    }
    public function render()
    {
        return view('livewire.servicios.show-servicio');
    }
}