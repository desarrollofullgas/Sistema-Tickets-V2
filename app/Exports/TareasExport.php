<?php

namespace App\Exports;

use App\Exports\Sheets\TareaSheet;
use App\Models\Tarea;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TareasExport implements WithMultipleSheets
{

    protected $tareas;

    public function __construct($tareas)
    {
        $this->tareas=$tareas;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new TareaSheet($this->tareas));
        return $sheet;
    }
}