<?php

namespace App\Exports;

use App\Exports\Sheets\ProdSerSheet;
use App\Models\TckServicio;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProdSerExport implements WithMultipleSheets
{
    
    protected $tckservicios;

    public function __construct($tckservicios)
    {
        $this->tckservicios=$tckservicios;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new ProdSerSheet($this->tckservicios));
        return $sheet;
    }
}