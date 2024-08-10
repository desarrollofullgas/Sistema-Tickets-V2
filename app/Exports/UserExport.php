<?php

namespace App\Exports;

use App\Exports\Sheets\UserSheet;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserExport implements WithMultipleSheets
{
    protected $usuarios;

    public function __construct($usuarios)
    {
        $this->usuarios=$usuarios;
    }

    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new UserSheet($this->usuarios));
        return $sheet;
    }
}