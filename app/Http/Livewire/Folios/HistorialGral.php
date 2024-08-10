<?php

namespace App\Http\Livewire\Folios;

use App\Exports\Folios\GralExport;
use App\Models\FoliosSalida;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class HistorialGral extends Component
{
    public $tipo,$dateIn,$dateEnd;
    public function generarArchivo(){
        $this->validate(['tipo'=>['required']],['tipo.required'=>'Seleccione una opción']);
        if($this->tipo=='gral'){
            $folios=FoliosSalida::all();
        }else{
            $this->validate([
                'dateIn'=>['required'],
                'dateEnd'=>['required'],
            ],[
                'dateIn.required'=>'Ingrese una fecha inicial',
                'dateEnd.required'=>'Ingrese una fecha Final',
            ]);
            $folios=FoliosSalida::whereBetween('created_at',[$this->dateIn,$this->dateEnd.' 23:59:00'])->get();
        }
    return Excel::download(new GralExport($folios),'FOLIOS DE SALIDA.xlsx');
    
    }
    public function render()
    {
        return view('livewire.folios.historial-gral');
    }
}
