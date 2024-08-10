<?php

namespace App\Exports;

use App\Exports\Sheets\ZonaSheet;
use App\Models\Zona;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ZonaExport implements WithMultipleSheets
{
    protected $zonas;

    public function __construct($zonas)
    {
        $this->zonas = $zonas;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new ZonaSheet($this->zonas));
        return $sheet;
    }
}
