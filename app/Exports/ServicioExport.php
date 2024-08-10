<?php

namespace App\Exports;

use App\Exports\Sheets\ServicioSheet;
use App\Models\Servicio;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ServicioExport implements WithMultipleSheets
{

    protected $servicios;

    public function __construct($servicios)
    {
        $this->servicios=$servicios;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new ServicioSheet($this->servicios));
        return $sheet;
    }
}