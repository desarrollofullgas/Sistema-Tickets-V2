<?php

namespace App\Exports;

use App\Exports\Sheets\DeptoSheet;
use App\Models\Departamento;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DeptoExport implements WithMultipleSheets
{

    protected $departamentos;

    public function __construct($departamentos)
    {
        $this->departamentos=$departamentos;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new DeptoSheet($this->departamentos));
        return $sheet;
    }
}