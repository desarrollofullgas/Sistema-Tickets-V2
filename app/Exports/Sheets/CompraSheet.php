<?php

namespace App\Exports\Sheets;

use App\Models\Compra;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompraSheet implements WithTitle, FromView, WithStyles, ShouldAutoSize, WithEvents
{
    private $compras;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($compras)
    {
        $this->compras = $compras;
    }

    public function view(): View
    {
        return view('excels.compra.CompraSheet', [
            'compras' => Compra::whereIn('id', $this->compras)->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class   => function(AfterSheet $event){
                $cellRange = 'A1:G1';

                $totalRows = $event->sheet->getHighestRow();

                $celAll = 'A1:G'.$totalRows;

                $event->sheet->getDelegate()->getStyle($cellRange)
                            ->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => [
                                        'rgb' => 'ffffff'
                                    ],
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'color' => ['argb' => 'ffcc0000'],
                                ],
                            ]);

                $event->sheet->getDelegate()->getStyle($celAll)
                            ->applyFromArray([
                                'font' => [
                                    'name' => 'Arial',
                                    'size' => 12,
                                ],
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_MEDIUM,
                                        'color' => ['argb' => 'ff000000'],
                                    ]
                                ]
                            ]);
            }
        ];
    }

    public function title(): string
    {
        
            return 'REQUISICIONES';
    }
}
