<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
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

class ServicioSheet implements FromView,ShouldAutoSize,WithTitle,WithEvents, WithStyles
{
    public $ini,$end;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini,$end) {
        $this->ini=Carbon::create($ini);
        $this->end=Carbon::create($end);
    }
    public function styles(Worksheet $sheet)
    {
        return [
            'A'=>['font'=>['bold'=>true]]
        ];
    }
    public function view(): View
    {
        $tablas=[];
        $servicios=Servicio::all();
        foreach($servicios as $servicio){
            $fallas=[];
            $totAb=0;
            $totProc=0;
            $totCer=0;
            $totGral=0;
            //buscamos los tickets de acuerdo a las fallas
            foreach($servicio->fallas as $falla){
                $tcks=$falla->tickets([$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()])->where('status','!=','Por abrir');
                if($tcks->count()>0){
                    $datos=[
                        'abierto'=>$falla->tickets([$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()])->where('status','Abierto')->count(),
                        'proceso'=>$falla->tickets([$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()])->where('status','En proceso')->count(),
                        'cerrado'=>$falla->tickets([$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()])->where('status','Cerrado')->count(),
                        'vencido'=>$falla->tickets([$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()])->where('status','Vencido')->count(),
                        'total'=>$tcks->count()
                    ];
                    $totAb+=$datos['abierto'];
                    $totProc+=$datos['proceso'];
                    $totCer+=$datos['cerrado'];
                    $totGral+=$datos['total'];
                    array_push($fallas,['falla'=>$falla->name,'datos'=>$datos]);
                }
            }
            if(count($fallas)>0){
                array_push($tablas,['serv'=>$servicio->name,'fallas'=>$fallas,'totales'=>['abiertos'=>$totAb,'proceso'=>$totProc,'cerrados'=>$totCer,'totGral'=>$totGral]]);
            }
        }
        //dd($tablas);
        return view('excels.calificaciones.servicios', compact('tablas'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $cabecera='A1:F1';
                $cells='A1:F'.$event->sheet->getDelegate()->getHighestRow();
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
        return 'Tickets por servicio-fallas';
    }
}
