<?php

namespace App\Exports\Sheets;

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
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TicketSheet implements WithTitle, FromView, WithStyles, ShouldAutoSize, WithEvents
{
    private $ticket;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }


    public function view(): View
    {
        $tickets = $this->ticket;
        //dd($tickets);
        return view('excels.tickets.TicketsSheets',compact('tickets'));
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
            AfterSheet::class   => function (AfterSheet $event) {
                $cellRange = 'A1:S1';

                $totalRows = $event->sheet->getHighestRow();

                $celAll = 'A1:S' . $totalRows;

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
        return 'Tickets';
    }
}
