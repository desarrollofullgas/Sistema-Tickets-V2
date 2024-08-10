<?php

namespace App\Exports\Folios\Salida\Sheets;


use App\Models\FoliosSalida;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SalidaSheet implements FromView,ShouldAutoSize,WithTitle,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($folio,$userID) {

        $this->folio = $folio;
        $this->userID = $userID;
    }
    public function collection()
    {
        //
    }
    public function view(): View
    {
        //$folio=FoliosSalida::find($this->folio);
        $folio=User::find($this->userID)->salidas->where('folio_id',$this->folio);
        //dd($folio);
        return view('excels.folios.salidas.salidaSheet',compact('folio'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event){
                $cells='A1:F'.$event->sheet->getHighestRow();
                //dd($event->sheet->getDelegate()->getCellCollection());
                /* $p=$event->sheet->getDelegate()->getCellCollection();
                dd($p->getCoordinates());
                foreach($p as $val){
                    dd($p);
                } */
                $arrayCells=$event->sheet->getDelegate()->getCellCollection()->getCoordinates();
                foreach($arrayCells as $celda){
                   $event->sheet->getDelegate()->getStyle($celda)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => 'ff000000'],
                        ]
                    ]
                   ]);
                }
                $event->sheet->getDelegate()->getStyle($cells)
                            ->applyFromArray([
                                'font' => [
                                    'name' => 'Arial',
                                    'size' => 12,
                                ],
                                
                            ]);
            }
        ];
    }
    public function title(): string
    {
        $usuario=User::find($this->userID);
        //$folio=FoliosSalida::find($this->folio);
        return $usuario->name;
    }
}