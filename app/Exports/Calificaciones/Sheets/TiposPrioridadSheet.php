<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Tipo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
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

class TiposPrioridadSheet implements FromView,ShouldAutoSize,WithTitle,WithEvents
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
        $tablas=[];
        $rango=[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()];
        $tablaTiempos=[
            'ACTIVIDAD'=>['Bajo'=>['suma'=>0,'cant'=>0],'Medio'=>['suma'=>0,'cant'=>0],'Alto'=>['suma'=>0,'cant'=>0],'Crítico'=>['suma'=>0,'cant'=>0],'Alto Crítico'=>['suma'=>0,'cant'=>0]],
            'INCIDENTE'=>['Bajo'=>['suma'=>0,'cant'=>0],'Medio'=>['suma'=>0,'cant'=>0],'Alto'=>['suma'=>0,'cant'=>0],'Crítico'=>['suma'=>0,'cant'=>0],'Alto Crítico'=>['suma'=>0,'cant'=>0]],
            'SOLICITUD'=>['Bajo'=>['suma'=>0,'cant'=>0],'Medio'=>['suma'=>0,'cant'=>0],'Alto'=>['suma'=>0,'cant'=>0],'Crítico'=>['suma'=>0,'cant'=>0],'Alto Crítico'=>['suma'=>0,'cant'=>0]]
        ];
        //buscamos los tipos de tickets cuyas fallas tengan tickets
        $tiposTcks=Tipo::whereHas('prioridad',function(Builder $query){
            $query->whereHas('fallas',function(Builder $q){
                $q->whereHas('alltickets',function(Builder $k){
                    $k->where('status','!=','Por abrir')->whereBetween('created_at',[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()]);
                });
            });
        })->get();
        $totales=[];
        foreach($tiposTcks as $tipo){
            $datPrioridades=[];
            foreach($tipo->prioridad as $prioridad){
                $abierto=0;
                $cerrado=0;
                $proceso=0;
                $vencido=0;
                $total=0;
                foreach($prioridad->fallas as $falla){
                    $abierto+=$falla->tickets($rango)->where('status','Abierto')->count();
                    $cerrado+=$falla->tickets($rango)->where('status','Cerrado')->count();
                    $proceso+=$falla->tickets($rango)->where('status','En proceso')->count();
                    $vencido+=$falla->tickets($rango)->where('status','Vencido')->count();
                    $total+=$falla->tickets($rango)->where('status','!=','Por abrir')->count();


                    $tickets=$falla->tickets($rango)->where('status','Cerrado')->get();
                    //apartado para la tabla de tiempos 
                    foreach($tickets as $tck){
                        $creacion=Carbon::create($tck->created_at);
                        $vencimiento=Carbon::create($tck->fecha_cierre);
                        $cierre=Carbon::create($tck->cerrado);
                        //calculamos el tiempo en el que se resuenve el ticket desde que se crea hasta que se cierra
                        $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
                        $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
                        $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea) ),2);
                        foreach($tablaTiempos as $keyTipo => $rowTipo){
                            if(mb_stripos($tipo->name,$keyTipo)!==false){
                                foreach($rowTipo as $keyPrioridad => $cell){
                                    if($keyPrioridad==$prioridad->name){
                                        floatval($tck->tiempo_efectivo) > 0 
                                        ?$tablaTiempos[$keyTipo][$keyPrioridad]['suma']+=floatval($tck->tiempo_efectivo)
                                        :$tablaTiempos[$keyTipo][$keyPrioridad]['suma']+=$tck->tiempo_total;
                                        $tablaTiempos[$keyTipo][$keyPrioridad]['cant']++;
                                    }
                                }
                            }
                        }
                    }
                }
                array_push($datPrioridades,[
                    'prioridad' => $prioridad->name,
                    'abiertos'=>$abierto,
                    'cerrados'=>$cerrado,
                    'procesos'=>$proceso,
                    'vencidos'=>$vencido, 
                    'total' => $total
                ]);
            }
            array_push($tablas,['tipo' => $tipo->name,'data'=>$datPrioridades]);
            //array_push($totales,['tipo' => $tipo->name,'data'=>['abierto'=>$totAb,'proceso'=>$totProc,'cerrado'=>$totCer,'total'=>$totGral]]);

        }
        foreach($tablas as $ktipo=>$tipo){
            $totAb=0;
            $totProc=0;
            $totCer=0;
            $totGral=0;
            foreach($tipo['data'] as $prioridad){
                $totAb+=$prioridad['abiertos'];
                $totProc+=$prioridad['procesos'];
                $totCer+=$prioridad['cerrados'];
                $totGral+=$prioridad['total'];
            }
            array_push($totales,['tipo'=>$tipo['tipo'],'data'=>['abierto'=>$totAb,'proceso'=>$totProc,'cerrado'=>$totCer,'total'=>$totGral]]);
        }

        //dd($tablas);
        return view('excels.calificaciones.tipos-prioridad',compact('tablas','tablaTiempos','totales'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $celdas=$event->sheet->getDelegate()->getCellCollection()->getCoordinates();
                $headers=$event->sheet->getDelegate()->getMergeCells();
                foreach($headers as $head){
                    $event->sheet->getDelegate()->getStyle($head)->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER
                        ],
                        'font'=>[
                            'bold'=>true,
                            'color'=>['argb'=>Color::COLOR_WHITE]
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['argb' => '404040'],
                        ]
                    ]);
                }
                foreach($celdas as $celda){
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
        return 'Prioridades';
    }
}
