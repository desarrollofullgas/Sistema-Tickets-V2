<?php

namespace App\Exports;

use App\Exports\Sheets\CompraSheet;
use App\Models\Compra;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ComprasExport implements WithMultipleSheets
{

    protected $compras;

    public function __construct($compras)
    {
        $this->compras=$compras;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new CompraSheet($this->compras));
        return $sheet;
    }
}