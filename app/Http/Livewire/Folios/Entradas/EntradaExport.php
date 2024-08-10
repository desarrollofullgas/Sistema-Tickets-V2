<?php

namespace App\Http\Livewire\Folios\Entradas;

use App\Exports\Folios\Entrada\SingleExport;
use App\Models\FoliosEntrada;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class EntradaExport extends Component
{
    public $folioID;
    public function download(FoliosEntrada $folio){
        return Excel::download(new SingleExport($this->folioID), $folio->folio.'.xlsx');
    }
    public function render()
    {
        return view('livewire.folios.entradas.entrada-export');
    }
}