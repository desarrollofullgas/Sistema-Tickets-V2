<?php

namespace App\Exports;

use App\Exports\Sheets\RegionSheet;
use App\Models\Region;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RegionExport implements WithMultipleSheets
{

    protected $regiones;

    public function __construct($regiones)
    {
        $this->regiones=$regiones;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new RegionSheet($this->regiones));
        return $sheet;
    }
}