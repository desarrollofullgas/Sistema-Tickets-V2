<?php

namespace App\Exports;

use App\Exports\Sheets\PrioridadSheet;
use App\Models\Prioridad;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PrioridadExport implements WithMultipleSheets
{
    protected $prioridades;

    public function __construct($prioridades)
    {
        $this->prioridades=$prioridades;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new PrioridadSheet($this->prioridades));
        return $sheet;
    }
}