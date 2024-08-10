<?php

namespace App\Exports;

use App\Exports\Sheets\TipoSheet;
use App\Models\Tipo;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TipoExport implements WithMultipleSheets
{

    protected $tipos;

    public function __construct($tipos)
    {
        $this->tipos=$tipos;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new TipoSheet($this->tipos));
        return $sheet;
    }
}