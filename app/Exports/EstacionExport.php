<?php

namespace App\Exports;

use App\Exports\Sheets\EstacionSheet;
use App\Models\Estacion;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EstacionExport implements WithMultipleSheets
{
    protected $estaciones;

    public function __construct($estaciones)
    {
        $this->estaciones=$estaciones;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new EstacionSheet($this->estaciones));
        return $sheet;
    }
}
