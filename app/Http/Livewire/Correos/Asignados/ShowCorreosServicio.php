<?php

namespace App\Http\Livewire\Correos\Asignados;

use App\Models\CorreosServicio;
use Livewire\Component;

class ShowCorreosServicio extends Component
{
    public $correos,$zonas;
    public function mount(){
        $this->correos=CorreosServicio::all();
        $this->zonas=CorreosServicio::select('zona_id')->groupBy('zona_id')->get();
    }
    public function render()
    {
        return view('livewire.correos.asignados.show-correos-servicio');
    }
}