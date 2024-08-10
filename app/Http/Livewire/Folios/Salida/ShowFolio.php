<?php

namespace App\Http\Livewire\Folios\Salida;

use App\Models\FoliosSalida;
use Livewire\Component;

class ShowFolio extends Component
{
    public $folioID,$folio;
    public function mount(){
        $this->folio=FoliosSalida::find($this->folioID);
    }
    public function render()
    {
        return view('livewire.folios.salida.show-folio');
    }
}
