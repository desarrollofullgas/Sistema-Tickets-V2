<?php

namespace App\Exports;

use App\Exports\Sheets\CategoriaSheet;
use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CategoriaExtport implements WithMultipleSheets
{

    protected $categorias;

    public function __construct($categorias)
    {
        $this->categorias=$categorias;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new CategoriaSheet($this->categorias));
        return $sheet;
    }
}
