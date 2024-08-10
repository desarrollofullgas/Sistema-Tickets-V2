<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Http\Livewire\Tickets\Tickets;
use App\Models\Areas;
use App\Models\Falla;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
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

class AreasAgenteSheet implements FromView,ShouldAutoSize,WithTitle,WithEvents
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
        $rango=[[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()]];
        $datos=[];
        //obtenemos las áreas cuyas fallas tengan tickets 
        $areas=Areas::whereHas('servicios',function(Builder $query){
            $query->whereHas('fallas',function(Builder $k){
                $k->whereHas('alltickets',function(Builder $q){
                    $q->whereBetween('created_at',[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()]);
                });
            });
        })->get();
        $totales=[];
        $totAb=0;
        $totProc=0;
        $totCer=0;
        $totGral=0;
        foreach($areas as $area){
            $abiertos=0;
            $cerrados=0;
            $proceso=0;
            $vencidos=0;
            $total=0;
            foreach($area->servicios as $servicio){
                foreach($servicio->fallas as $falla){
                    $abiertos+=$falla->tickets($rango)->where('status','Abierto')->count();
                    $cerrados+=$falla->tickets($rango)->where('status','Cerrado')->count();
                    $proceso+=$falla->tickets($rango)->where('status','En proceso')->count();
                    $vencidos+=$falla->tickets($rango)->where('status','Vencido')->count();
                    $total+=$falla->tickets($rango)->where('status','!=','Por abrir')->count();
                }
            }
            $totAb+=$abiertos;
            $totProc+=$proceso;
            $totCer+=$cerrados;
            $totGral+=$total;
            array_push($datos,[
                'area' => $area->name,
                'abierto'=>$abiertos,
                'cerrado'=>$cerrados,
                'proceso'=>$proceso,
                'vencido'=>$vencidos,
                'total' => $total
            ]);
        }
        $totales=['abiertos'=>$totAb,'proceso'=>$totProc,'cerrados'=>$totCer,'totGral'=>$totGral];
        return view('excels.calificaciones.areas-agente',compact('datos','totales'));
    }
    public function registerEvents(): array
    {
        return[
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
        return 'Tickets por área';
    }
}
