<?php

namespace App\Exports\Folios\Entrada\Sheets;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class EntradaSheet implements FromView,ShouldAutoSize,WithTitle,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($folio,$userID) {
        $this->folio=$folio;
        $this->userID = $userID;
    }
    public function view(): View
    {
        $folio=User::find($this->userID)->entradas->where('folio_id',$this->folio);
        return view('excels.folios.entradas.entradaSheet',compact('folio'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $headers=$event->sheet->getDelegate()->getMergeCells();
                $celdas=$event->sheet->getDelegate()->getCellCollection()->getCoordinates();
                foreach($headers as $head){
                    $event->sheet->getDelegate()->getStyle($head)->applyFromArray([
                        'font'=>[
                            'bold'=>true,
                            'color'=>['argb'=>Color::COLOR_WHITE]
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['argb' => Color::COLOR_DARKRED],
                        ]
                    ]);
                }
                foreach($celdas as $celda){
                    $event->sheet->getDelegate()->getStyle($celda)->applyFromArray([
                        'borders'=>[
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'ff000000'],
                            ]
                        ],
                    ]);
                }
            }
        ];
    }
    public function title(): string
    {
        $user=User::find($this->userID);
        return $user->name;
    }
}