<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Tarea;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TareasSheet implements FromView,ShouldAutoSize,WithColumnWidths,WithTitle,WithEvents
{
    public $ini,$end;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini,$end) {
        $this->ini=Carbon::create($ini);
        $this->end=Carbon::create($end);
    }
    public function columnWidths(): array
    {
        return [
            'I' => 70
        ];
    }
    public function view(): View
    {
        $rango=[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()];
        $tareas=Tarea::whereBetween('created_at',$rango)->get();
        foreach($tareas as $tarea){
            if ($tarea->fecha_cierre!=null) {
                $creado=Carbon::create($tarea->created_at);
                $cierre=Carbon::create($tarea->fecha_cierre);
                $tarea->solucion=$creado->floatDiffInHours($cierre);
            } else {
                $tarea->solucion=0;
            }
            
            $creado=Carbon::create($tarea->created_at);
        }
        //dd($tareas);
        return view('excels.calificaciones.tareas',compact('tareas'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $cabecera='A1:I1';
                $cells='A1:I'.$event->sheet->getDelegate()->getHighestRow();
                $colMensaje='I2:I'.$event->sheet->getDelegate()->getHighestRow();
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
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'ff000000'],
                        ]
                    ]
                ]);
                $event->sheet->getDelegate()->getStyle($colMensaje)->getAlignment()->setWrapText(true);
            }
        ];
    }
    public function title(): string
    {
        return 'Listado de tareas';
    }
}
