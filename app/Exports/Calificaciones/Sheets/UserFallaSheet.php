<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Servicio;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserFallaSheet implements FromView,ShouldAutoSize,WithTitle,WithStyles,WithEvents
{
    public $ini,$end;
    public function __construct($ini,$end) {
        $this->ini=Carbon::create($ini);
        $this->end=Carbon::create($end);
    }
    public function styles(Worksheet $sheet)
    {
        return [
            'A'=>['font'=>['bold'=>true]],
            'B'=>['font'=>['bold'=>true]]
        ];
    }
    public function view(): View
    {
        //obtenemos los usuarios con tickes en el rango de fechas recibido
        $rango=[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()];
        $tablas=[];
        $users=User::whereHas('tickets',function(Builder $tickets)use($rango){
            $tickets->whereBetween('created_at',$rango);
        })->get();
        //Obtenemos los servicios cuyas fallas tengan tickets
        $servicios=Servicio::whereHas('fallas',function(Builder $fallas)use($rango){
            $fallas->whereHas('alltickets',function(Builder $tickets)use($rango){
                $tickets->whereBetween('created_at',$rango);
            });
        })->get();
        $gruposTcks=Ticket::selectRaw('user_id, count(id) as cant,falla_id,status')->whereBetween('created_at',$rango)->groupByRaw('user_id,falla_id,status')->get();


        //obtenemos los datos finales
        foreach($users as $user){
            $dataUser=[];
            $datServicios=[];
            $totAb=0;
            $totProc=0;
            $totCer=0;
            $totGral=0;
            $rows=0;//esta variable sirve para el rowspan en el archivo
            foreach($servicios as $servicio){
                $dataFalla=[];
                foreach($servicio->fallas as $falla){
                    $ab=0;
                    $proc=0;
                    $cerr=0;
                    $ven=0;
                    foreach ($gruposTcks as $grupo){
                        if(($grupo->falla_id == $falla->id)&&($user->id==$grupo->user_id)){
                            if($grupo->status=='Abierto'){
                                $ab+=$grupo->cant;
                                $totAb+=$ab;
                            }
                            if($grupo->status=='En proceso'){
                                $proc+=$grupo->cant;
                                $totProc+=$proc;
                            }
                            if($grupo->status=='Cerrado'){
                                $cerr+=$grupo->cant;
                                $totCer+=$cerr;
                            }
                            if($grupo->status=='Vencido'){
                                $ven+=$grupo->cant;
                            }
                        }
                    }
                    if($ab>0 || $proc>0 || $cerr>0 || $ven>0){
                        $rows++;
                        $totGral+=($ab+$proc+$cerr+$ven);
                        array_push($dataFalla,['falla'=>$falla->name,'abierto'=>$ab,'proceso'=>$proc,'cerrados'=>$cerr,'vencido'=>$ven, 'total'=>($ab+$proc+$cerr+$ven)]);
                    }
                }
                if(count($dataFalla)>0){
                    array_push($datServicios,['servicio'=>$servicio->name,'datos'=>$dataFalla]);
                }
            }
            if(count($datServicios)>0){
                array_push($tablas,['user'=>$user->name,'servicios'=>$datServicios,'rows'=>$rows,'totales'=>['abiertos'=>$totAb,'proceso'=>$totProc,'cerrados'=>$totCer,'totGral'=>$totGral]]);
            }
        }
        //dd($tablas);
        return view('excels.calificaciones.user-falla',compact('tablas'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $cabecera='A1:G1';
                $cells='A1:G'.$event->sheet->getDelegate()->getHighestRow();
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
        return 'Tickets Usuario-Servicios-Fallas';
    }
}
