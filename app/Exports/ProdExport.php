<?php

namespace App\Exports;

use App\Exports\Sheets\ProductoSheet;
use App\Models\Producto;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProdExport implements WithMultipleSheets
{

    protected $productos;

    public function __construct($productos)
    {
        $this->productos=$productos;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new ProductoSheet($this->productos));
        return $sheet;
    }
}