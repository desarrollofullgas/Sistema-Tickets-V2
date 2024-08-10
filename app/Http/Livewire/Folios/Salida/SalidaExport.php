<?php

namespace App\Http\Livewire\Folios\Salida;

use App\Exports\Folios\Salida\SingleEsport;
use App\Models\FoliosSalida;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class SalidaExport extends Component
{
    public $folioID;
    public function download(FoliosSalida $folio){
        return Excel::download(new SingleEsport($this->folioID),$folio->folio.'.xlsx');
    }
    public function render()
    {
        return view('livewire.folios.salida.salida-export');
    }
}
