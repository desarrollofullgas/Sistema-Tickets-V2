<?php

namespace App\Http\Livewire\Folios\Salida;

use App\Models\Salida;
use Livewire\Component;

class Lock extends Component
{
    public $salidaID;
    public function lock(Salida $salida){
        $salida->editable=false;
        $salida->save();
        return redirect()->route('folios.salidas');
    }
    public function render()
    {
        return view('livewire.folios.salida.lock');
    }
}