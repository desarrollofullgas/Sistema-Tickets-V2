<?php

namespace App\Http\Livewire\Folios\Entradas;

use App\Models\Entrada;
use Livewire\Component;

class Lock extends Component
{
    public $entradaID;
    public function lock(Entrada $entrada){
        $entrada->editable=false;
        $entrada->save();
        return redirect()->route('folios.entradas');
    }
    public function render()
    {
        return view('livewire.folios.entradas.lock');
    }
}