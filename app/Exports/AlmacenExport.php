<?php

namespace App\Exports;

use App\Exports\Sheets\AlmCisSheet;
use App\Models\AlmacenCi;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AlmacenExport implements WithMultipleSheets
{
    protected $almacenes;

    public function __construct($almacenes)
    {
        $this->almacenes=$almacenes;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new AlmCisSheet($this->almacenes));
        return $sheet;
    }
}