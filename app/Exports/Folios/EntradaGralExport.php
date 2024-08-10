<?php

namespace App\Exports\Folios;

use App\Exports\Folios\Entrada\EntradaGralSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EntradaGralExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($folios) {
        $this->folios = $folios;
    }
    public function sheets(): array
    {
        $hojas=[];
        foreach($this->folios as $folio){
            array_push($hojas,new EntradaGralSheet($folio->id));
        }
        return $hojas;
    }
}