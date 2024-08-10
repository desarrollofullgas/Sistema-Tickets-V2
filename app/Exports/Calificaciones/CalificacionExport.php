<?php

namespace App\Exports\Calificaciones;

use App\Exports\Calificaciones\Sheets\Agentes;
use App\Exports\Calificaciones\Sheets\AreasAgenteSheet;
use App\Exports\Calificaciones\Sheets\PeriodoSheet;
use App\Exports\Calificaciones\Sheets\RankingSheet;
use App\Exports\Calificaciones\Sheets\ServicioSheet;
use App\Exports\Calificaciones\Sheets\TicketsPeriodo;
use App\Exports\Calificaciones\Sheets\TiposPrioridadSheet;
use App\Exports\Calificaciones\Sheets\TareasSheet;
use App\Exports\Calificaciones\Sheets\TareasUserSheet;
use App\Exports\Calificaciones\Sheets\TicketsDiarios;
use App\Exports\Calificaciones\Sheets\TiempoAreaSheet;
use App\Exports\Calificaciones\Sheets\TicketsZonas;
use App\Exports\Calificaciones\Sheets\UserFallaSheet;

use App\Models\Areas;
use App\Models\Departamento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CalificacionExport implements WithMultipleSheets
{
    public $data,$in,$end;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data,$in,$end)
    {
        $this->data = $data;
        $this->in=$in;
        $this->end = $end;
    }
    public function sheets(): array
    {
        //$deptosID=$this->deptosTcks();
        $arr=[];
        array_push($arr,new RankingSheet($this->data));
        array_push($arr,new PeriodoSheet($this->in,$this->end));
        array_push($arr,new Agentes($this->in,$this->end));
        array_push($arr,new ServicioSheet($this->in,$this->end));
        array_push($arr,new AreasAgenteSheet($this->in,$this->end));
        array_push($arr,new UserFallaSheet($this->in,$this->end));
        array_push($arr,new TiposPrioridadSheet($this->in,$this->end));
        array_push($arr,new TiempoAreaSheet($this->in,$this->end));
        array_push($arr,new TicketsPeriodo($this->in,$this->end));
        array_push($arr,new TicketsDiarios($this->in,$this->end));
        array_push($arr,new TareasSheet($this->in,$this->end));
        array_push($arr,new TareasUserSheet($this->in,$this->end));
        array_push($arr,new TicketsZonas($this->in,$this->end));

        return $arr;
    }
}
