<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Ticket;
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

class TicketsDiarios implements FromView,WithTitle,ShouldAutoSize,WithEvents
{
    public $ini,$end;
    public function __construct($ini,$end) {
        $this->ini=Carbon::create($ini);
        $this->end=Carbon::create($end);
    }
    public function view(): View
    {
        $limite=$this->ini->diffInDays($this->end);
        $datos=[];
        $rango=[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()];
        $totales=[
            'abiertos'=>Ticket::where('status','Abierto')->whereBetween('created_at',$rango)->count(),
            'proceso'=>Ticket::where('status','En proceso')->whereBetween('created_at',$rango)->count(),
            'cerrados'=>Ticket::where('status','Cerrado')->whereBetween('created_at',$rango)->count(),
            'totGral'=>Ticket::where('status','!=','Por abrir')->whereBetween('created_at',$rango)->count()
        ];
        for ($i=0; $i <=$limite ; $i++) { 
            $dia=$this->ini;
            array_push($datos,
                ['dia'=>$dia->toDateString(),
                'abierto'=>Ticket::where('status','Abierto')->whereBetween('created_at',[$dia->startOfDay()->toDateTimeString(),$dia->endOfDay()->toDateTimeString()])->count(),
                'proceso'=>Ticket::where('status','En proceso')->whereBetween('created_at',[$dia->startOfDay()->toDateTimeString(),$dia->endOfDay()->toDateTimeString()])->count(),
                'vencido'=>Ticket::where('status','Vencido')->whereBetween('created_at',[$dia->startOfDay()->toDateTimeString(),$dia->endOfDay()->toDateTimeString()])->count(),
                'cerrado'=>Ticket::where('status','Cerrado')->whereBetween('created_at',[$dia->startOfDay()->toDateTimeString(),$dia->endOfDay()->toDateTimeString()])->count(),
                'total'=>Ticket::where('status','!=','Por abrir')->whereBetween('created_at',[$dia->startOfDay()->toDateTimeString(),$dia->endOfDay()->toDateTimeString()])->count()
            ]);
            $this->ini->addDay();
        }
        //dd($datos);
        return view('excels.calificaciones.tickets-diarios',compact('datos','totales'));
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
        return 'Tickets por día';
    }
}
