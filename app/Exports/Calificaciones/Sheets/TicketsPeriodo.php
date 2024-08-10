<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Ticket;
use Carbon\Carbon;
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

class TicketsPeriodo implements FromView,ShouldAutoSize,WithTitle,WithEvents
{
    public $ini,$end;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini,$end) {
        $this->ini=Carbon::create($ini);
        $this->end=Carbon::create($end);
    }
    //función para calcular el tiempo total de las tareas que tenga el ticket
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
        $tcks=Ticket::whereNotIn('status',['Por abrir'])->whereBetween('created_at',$rango)->get();
        //realizamos operaciones para obtener los valores faltantes y las asignamos a nuevas propiedades de cada registro
        foreach($tcks as $tck){
            $creacion=Carbon::create($tck->created_at);
            $vencimiento=Carbon::create($tck->fecha_cierre);
            $cierre=Carbon::create($tck->cerrado);

            //validamos si el ticket fue creado dentro del horario de oficina L-V 9-18:30 S 9-13:00
            if($creacion->dayOfWeek > 0){ //0=domingo
                $inicio=Carbon::create($tck->created_at)->startOfDay()->addHours(9);
                $creacion->dayOfWeek==6
                ?$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(13)
                :$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(18)->addMinutes(30);

                $creacion->greaterThanOrEqualTo($inicio)&&$creacion->lessThanOrEqualTo($limite)
                ?$tck->oficina='SI'
                :$tck->oficina='NO';
            }else{
                $tck->oficina='NO';
            }
            
            $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
            $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
            $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea)),2);

            $tck->falla->prioridad->tiempo >= $tck->tiempo_efectivo
            ?$tck->nivel_servicio='DENTRO'
            :$tck->nivel_servicio='FUERA';

        }
        return view('excels.calificaciones.tickets-periodo',compact('tcks'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $cabecera='A1:S1';
                $cells='A1:S'.$event->sheet->getDelegate()->getHighestRow();
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
                $event->sheet->getDelegate()->getStyle($cells)->applyFromArray([
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
        ];
    }
    public function title(): string
    {
        return 'Listado de tickets';
    }
}
