<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Areas;
use App\Models\Ticket;
use App\Models\Tipo;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PeriodoSheet implements FromView,ShouldAutoSize,WithTitle,WithEvents
{
    public $ini,$end;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini,$end) {
        $this->ini=Carbon::create($ini);
        $this->end=Carbon::create($end);
    }
    public function tiempoTareas($tareas){
        $total=0;
        foreach($tareas as $tarea){
                $creacion=Carbon::create($tarea->created_at);
                $cierre=Carbon::create($tarea->fecha_cierre);
                $total+=$cierre->floatDiffInHours($creacion);
        }
        return number_format($total,2);
    }
    public function view(): View
    {
        $rango=[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()];
        //obtenemos las áreas cuyas fallas tengan tickets 
        $areas=Areas::whereHas('servicios',function(Builder $query)use ($rango){
            $query->whereHas('fallas',function(Builder $k)use ($rango){
                $k->whereHas('alltickets',function(Builder $q)use ($rango){
                    $q->whereBetween('created_at',$rango);
                });
            });
        })->get();
        $tablaAreas=[];
        $tiposTck=Tipo::orderBy('name','ASC')->get();
        $tickets=Ticket::whereBetween('created_at',[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()])->get();
        $lvServ=['dentro'=>0, 'fuera'=>0];
        $horario=['dentro'=>0, 'fuera'=>0];
        $infoTcks=[
            'abiertos'=> $tickets->where('status','Abierto')->count(),
            'cerrados'=> $tickets->where('status','Cerrado')->count(),
            'proceso'=> $tickets->where('status','En proceso')->count(),
            //'vencidos'=> $tickets->where('status','Vencido')->count()
        ];
        //dd($infoTcks);
        $arrTipos=[];
        foreach($tiposTck as $tipo){
            $cont=0;
            $pendientes=0;
            $dentro=0;
            $fuera=0;
            $enHorario=0;
            $fueraHorario=0;
            foreach($tipo->prioridad as $prioridad){
                foreach($prioridad->fallas as $falla){
                    $tcks=$falla->tickets([$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()]);
                    $cont+=$tcks->count();
                    $pendientes+=$falla->tickets([$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()])->where('status','!=','Cerrado')->count();
                    foreach($tcks->get() as $ticket){
                        $creado=Carbon::create($ticket->created_at);
                        $vencimiento=Carbon::create($ticket->fecha_cierre);
                        $cierre=Carbon::create($ticket->updated_at);
                        //modificación para que cuadre la cant de tck de nvl de servicio para tcks cerrados
                        if($ticket->status=='Cerrado'){
                            $ticket->tiempo_total=$creado->floatDiffInHours($cierre);
                            $ticket->tiempo_tarea=$this->tiempoTareas($ticket->tareas->where('status','Cerrado'));
                            $ticket->tiempo_efectivo=number_format(($ticket->tiempo_total - floatval($ticket->tiempo_tarea)),2);
                            //$cierre->lessThanOrEqualTo($vencimiento)
                            $ticket->falla->prioridad->tiempo >= $ticket->tiempo_efectivo
                            ?$dentro++
                            :$fuera++;
                        }
                        //verificamos que tickets están dentro o fuera del horario laboral
                        if($creado->dayOfWeek>0){
                            $inicio=Carbon::create($ticket->created_at)->startOfDay()->addHours(9);
                            $creado->dayOfWeek==6
                            ?$fin=Carbon::create($ticket->created_at)->startOfDay()->addHours(13)
                            :$fin=Carbon::create($ticket->created_at)->startOfDay()->addHours(18)->addMinutes(30);

                            //comparamos el horario
                            $creado->greaterThanOrEqualTo($inicio) && $creado->lessThanOrEqualTo($fin)
                            ?$enHorario++
                            :$fueraHorario++;
                        }else{
                            $fueraHorario++;
                        }
                    }
                }
            }
            array_push($arrTipos,[
                $tipo->name,
                'total'=> $cont, 
                'pendientes'=> $pendientes,
                'dentro'=> $dentro,
                'fuera'=> $fuera,
                'inHr' => $enHorario,
                'fHr' => $fueraHorario
            ]);
            $lvServ['dentro']+=$dentro;
            $lvServ['fuera']+=$fuera;
            $horario['dentro']+=$enHorario;
            $horario['fuera']+=$fueraHorario;
        }
        foreach($areas as $area){
            $clases=['ACTIVIDAD'=>0,'INCIDENTE'=>0,'SOLICITUD'=>0,'TOTAL'=>0];
            foreach($arrTipos as $tipo){
                if(mb_stripos($tipo[0],$area->name)!==false){
                    foreach($clases as $key=>$clase){
                        if(mb_stripos($tipo[0],$key)!==false){
                            $clases[$key]=$tipo['total'];
                            $clases['TOTAL']+=$tipo['total'];
                        }
                    }
                }
            }
            array_push($tablaAreas,['area'=>$area->name,'datos'=>$clases]);
        }
        $totales=['ACTIVIDAD'=>0,'INCIDENTE'=>0,'SOLICITUD'=>0,'TOTAL'=>0];
        //trabajamos losdatos para obtener la columna de totales que se mostrará
        foreach($totales as $key=>$rowTotal){
            foreach($tablaAreas as $area){
                foreach($area['datos'] as $tipo=>$clase){
                    if($tipo == $key){
                        $totales[$key]+=$clase;
                    }
                }
            }
        }
        //dd($lvServ,$horario);
        return view('excels.calificaciones.periodo',compact('arrTipos','infoTcks','lvServ','horario','tablaAreas','totales'));
    }
    public function registerEvents(): array
    {
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cabecera='A1:C1';
                //dd($event->sheet->getDelegate()->getMergeCells(),$event->sheet->getDelegate()->getCellCollection()->getCoordinates());
                $cells='A1:C'.$event->sheet->getDelegate()->getHighestRow();
                $celdasDatos=$event->sheet->getDelegate()->getCellCollection()->getCoordinates();
                //$lateral='A1:A'.$event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getDelegate()->getStyle($cabecera)->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        'color'=>['argb'=>Color::COLOR_WHITE]
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => Color::COLOR_RED],
                    ]
                ]);
                /* $event->sheet->getDelegate()->getStyle($lateral)->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        'color'=>['argb'=>Color::COLOR_WHITE]
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => Color::COLOR_DARKRED],
                    ]
                ]); */
                $event->sheet->getDelegate()->getStyle($cells)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ]
                ]);
                foreach($celdasDatos as $celda){
                    $event->sheet->getDelegate()->getStyle($celda)->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'ff000000'],
                            ]
                        ]
                    ]);
                }
            }
        ];
    }
    public function title(): string
    {
        return 'Resumen Periodo';
    }
}
