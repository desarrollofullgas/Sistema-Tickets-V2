<?php

namespace App\Exports\Calificaciones\Sheets;

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

class RankingSheet implements FromView,ShouldAutoSize,WithTitle,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data) {
        $this->data=$data;
    }
    public function view(): View
    {
        $grupos=$this->data;
        return view('excels.calificaciones.ranking',compact('grupos'));
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
        return "Calificaciones";
    }
}
