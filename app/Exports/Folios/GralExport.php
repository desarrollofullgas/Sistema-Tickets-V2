<?php

namespace App\Exports\Folios;

use App\Exports\Folios\Sheets\GralSheet;
use App\Models\FoliosSalida;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GralExport implements WithMultipleSheets
{
    public $folios;
    use Exportable;
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
            array_push($hojas,new GralSheet($folio->id));
        }
        return $hojas;
    }   
}