<?php

namespace App\Http\Livewire\Folios;

use App\Exports\Folios\EntradaGralExport;
use App\Models\FoliosEntrada;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class HistorialEntradas extends Component
{
    public $tipo,$dateIn,$dateEnd;
    public function generarArchivo(){
        $this->validate(['tipo'=>['required']],['tipo.required'=>'Seleccione una opción']);
        if($this->tipo=='gral'){
            $folios=FoliosEntrada::all();
        }else{
            $this->validate([
                'dateIn'=>['required'],
                'dateEnd'=>['required'],
            ],[
                'dateIn.required'=>'Ingrese una fecha inicial',
                'dateEnd.required'=>'Ingrese una fecha Final',
            ]);
            $folios=FoliosEntrada::whereBetween('created_at',[$this->dateIn,$this->dateEnd.' 23:59:00'])->get();
        }
    return Excel::download(new EntradaGralExport($folios),'FOLIOS DE ENTRADA.xlsx');
    }
    public function render()
    {
        return view('livewire.folios.historial-entradas');
    }
}