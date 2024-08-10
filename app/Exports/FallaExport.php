<?php

namespace App\Exports;

use App\Exports\Sheets\FallaSheet;
use App\Models\Falla;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FallaExport implements WithMultipleSheets
{

    protected $fallas;

    public function __construct($fallas)
    {
        $this->fallas=$fallas;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new FallaSheet($this->fallas));
        return $sheet;
    }
}