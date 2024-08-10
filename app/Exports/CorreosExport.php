<?php

namespace App\Exports;

use App\Exports\Sheets\CorreoSheet;
use App\Models\CorreosCompra;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CorreosExport implements WithMultipleSheets
{

    protected $correos;

    public function __construct($correos)
    {
        $this->correos=$correos;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new CorreoSheet($this->correos));
        return $sheet;
    }
}