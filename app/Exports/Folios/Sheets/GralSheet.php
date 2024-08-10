<?php

namespace App\Exports\Folios\Sheets;

use App\Models\FoliosSalida;
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

class GralSheet implements FromView,ShouldAutoSize,WithStyles,WithTitle,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($folioID) {
        $this->folioID = $folioID;
    }
    public function styles(Worksheet $sheet)
    {
        return[
            1 => [
                'font'=>[
                    'bold'=>true,
                    'color'=>['argb'=>Color::COLOR_WHITE]
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['argb' => Color::COLOR_DARKRED],
                ]
            ],
        ];
    }
    public function view(): View
    {
        $folio=FoliosSalida::find($this->folioID);
        return view('excels.folios.salidas.gralSheet',compact('folio'));
    }
    public function registerEvents(): array
    {
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cells='A1:G'.$event->sheet->getDelegate()->getHighestRow();
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
        $folio=FoliosSalida::find($this->folioID);
        return $folio->folio;
    }
}