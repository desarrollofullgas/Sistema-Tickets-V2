<?php

namespace App\Exports\Folios\Salida;

use App\Exports\Folios\Salida\Sheets\SalidaSheet;
use App\Models\FoliosSalida;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SingleEsport implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($id) {
        $this->id = $id;
    }
    public function sheets(): array
    {
        $hojas=[];
        $users=FoliosSalida::find($this->id)->usersCount()->get();
        foreach($users as $user){
            array_push($hojas,new SalidaSheet($this->id,$user->user_id));
        }
        return $hojas;
    }
}