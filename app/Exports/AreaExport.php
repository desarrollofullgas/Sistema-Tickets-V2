<?php

namespace App\Exports;

use App\Exports\Sheets\AreaSheet;
use App\Models\Areas;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AreaExport implements WithMultipleSheets
{

    protected $areas;

    public function __construct($areas)
    {
        $this->areas=$areas;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new AreaSheet($this->areas));
        return $sheet;
    }
}