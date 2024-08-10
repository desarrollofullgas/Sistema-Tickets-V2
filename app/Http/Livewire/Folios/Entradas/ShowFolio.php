<?php

namespace App\Http\Livewire\Folios\Entradas;

use App\Models\FoliosEntrada;
use Livewire\Component;

class ShowFolio extends Component
{
    public $folioID,$folio;
    public function mount(){
        $this->folio=FoliosEntrada::find($this->folioID);
    }
    public function render()
    {
        return view('livewire.folios.entradas.show-folio');
    }
}