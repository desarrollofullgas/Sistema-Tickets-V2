<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Areas;
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

class TiempoAreaSheet implements FromView,WithTitle,ShouldAutoSize,WithEvents
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
        $rango=[[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()]];
        //buscamos las áreas cuyas fallas asignadas tengan tickets generados en el rango de tiempo
        $areas=Areas::whereHas('servicios',function(Builder $query)use($rango){
            $query->whereHas('fallas',function(Builder $k)use($rango){
                $k->whereHas('alltickets',function(Builder $q)use($rango){
                    $q->where('status','Cerrado')->whereBetween('created_at',$rango);
                });
            });
        })->get();
        //buscamos los tipos de tickets cuyas fallas tengan tickets
        $tiposTcks=Tipo::whereHas('prioridad',function(Builder $query){
            $query->whereHas('fallas',function(Builder $q){
                $q->whereHas('alltickets',function(Builder $k){
                    $k->where('status','!=','Por abrir')->whereBetween('created_at',[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()]);
                });
            });
        })->orderBy('name','ASC')->get();
        foreach($areas as $area){
            $tablaTiempos=[
                'ACTIVIDAD'=>['Bajo'=>['suma'=>0,'cant'=>0],'Medio'=>['suma'=>0,'cant'=>0],'Alto'=>['suma'=>0,'cant'=>0],'Crítico'=>['suma'=>0,'cant'=>0],'Alto Crítico'=>['suma'=>0,'cant'=>0]],
                'INCIDENTE'=>['Bajo'=>['suma'=>0,'cant'=>0],'Medio'=>['suma'=>0,'cant'=>0],'Alto'=>['suma'=>0,'cant'=>0],'Crítico'=>['suma'=>0,'cant'=>0],'Alto Crítico'=>['suma'=>0,'cant'=>0]],
                'SOLICITUD'=>['Bajo'=>['suma'=>0,'cant'=>0],'Medio'=>['suma'=>0,'cant'=>0],'Alto'=>['suma'=>0,'cant'=>0],'Crítico'=>['suma'=>0,'cant'=>0],'Alto Crítico'=>['suma'=>0,'cant'=>0]]
            ];
            foreach($area->servicios as $servicio){
                foreach($servicio->fallas as $falla){
                    $tcks=$falla->tickets($rango)->get();
                    foreach($tcks as $tck){
                        if($tck->status=='Cerrado'){
                            $creacion=Carbon::create($tck->created_at);
                            $vencimiento=Carbon::create($tck->fecha_cierre);
                            $cierre=Carbon::create($tck->updated_at);
                            //calculamos el tiempo en el que se resuenve el ticket desde que se crea hasta que se cierra
                            $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
                            $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
                            $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea) ),2);
                            foreach($tablaTiempos as $keyTipo => $rowTipo){
                                if(mb_stripos($falla->prioridad->tipo->name,$keyTipo)!==false){
                                    foreach($rowTipo as $keyPrioridad => $cell){
                                        if($keyPrioridad==$falla->prioridad->name){
                                            $tablaTiempos[$keyTipo][$keyPrioridad]['suma']+=floatval($tck->tiempo_efectivo);
                                            $tablaTiempos[$keyTipo][$keyPrioridad]['cant']++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            array_push($tablas,['area'=>$area->name,'data'=>$tablaTiempos]);
        }
        //dd($tablas);
        return view('excels.calificaciones.tiempo-area',compact('tablas'));
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
        return 'Tiempo área (Hrs)';
    }
}
