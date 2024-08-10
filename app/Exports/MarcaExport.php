<?php

namespace App\Exports;

use App\Exports\Sheets\MarcaSheet;
use App\Models\Marca;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MarcaExport implements WithMultipleSheets
{
     protected $marcas;

    public function __construct($marcas)
    {
        $this->marcas=$marcas;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new MarcaSheet($this->marcas));
        return $sheet;
    }
}