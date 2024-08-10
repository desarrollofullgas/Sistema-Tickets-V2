<?php

namespace App\Exports\Folios\Entrada;

use App\Exports\Folios\Entrada\Sheets\EntradaSheet;
use App\Models\FoliosEntrada;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SingleExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($folioID) {
        $this->folioID = $folioID;
    }
    public function sheets(): array
    {
        $hojas=[];
        $users=FoliosEntrada::find($this->folioID,)->usersCount()->get();
        foreach($users as $user){
            array_push($hojas,new EntradaSheet($this->folioID,$user->user_id));
        }
        return $hojas;
    }
}