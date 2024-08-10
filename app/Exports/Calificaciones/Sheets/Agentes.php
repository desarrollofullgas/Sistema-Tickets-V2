<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Tipo;
use App\Models\User;
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

class Agentes implements FromView, WithTitle, ShouldAutoSize,WithEvents
{
    public $ini,$end;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini,$end) {
        $this->ini=Carbon::create($ini);
        $this->end=Carbon::create($end);
    }
    public function view(): View
    {
        $tabla=[];
        $tipos=Tipo::all();
        $users=User::all();
        $totales=[];
        $totAb=0;
        $totProc=0;
        $totCer=0;
        $totGral=0;
        foreach($users as $user){
            
            $cantTcks=$user->tickets->whereBetween('created_at',[$this->ini->startOfMonth()->toDateTimeString(),$this->end->endOfMonth()->toDateTimeString()]);
            if($cantTcks->count()>0){
                //array_push($datos,['us' => $user->name]);
                $datos=[
                    'abierto'=>$cantTcks->where('status','Abierto')->count(),
                    'proceso'=>$cantTcks->where('status','En proceso')->count(),
                    'cerrado'=>$cantTcks->where('status','Cerrado')->count(),
                    'total'=>$cantTcks->count()
                ];
                $totAb+=$datos['abierto'];
                $totProc+=$datos['proceso'];
                $totCer+=$datos['cerrado'];
                $totGral+=$datos['total'];
                array_push($tabla,['us' => $user->name,'datos' => $datos]);
            }
        }
        $totales=['abiertos'=>$totAb,'proceso'=>$totProc,'cerrados'=>$totCer,'totGral'=>$totGral];
        return view('excels.calificaciones.agentes',compact('tabla','totales'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $cabecera='A1:E1';
                $cells='A1:E'.$event->sheet->getDelegate()->getHighestRow();
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
        return 'Agente asignados';
    }
}
