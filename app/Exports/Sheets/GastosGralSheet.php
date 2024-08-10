<?php

namespace App\Exports\Sheets;

use App\Models\ProductoExtraordinario;
use App\Models\ProductoSolicitud;
use App\Models\Solicitud;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GastosGralSheet implements FromView,ShouldAutoSize,WithTitle,WithStyles, WithEvents,WithColumnFormatting
{
    private $ini;
    private $fin;
    public function __construct($ini,$fin)
    {
        $this->ini = $ini;
        $this->fin = $fin;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        /* $datos=Solicitud::join('producto_solicitud as ps','ps.solicitud_id','solicituds.id')
        ->join('productos as p','p.id','ps.producto_id')
        ->join('estacions as e','e.id','solicituds.estacion_id')
        ->select(DB::raw('solicituds.id,solicituds.estacion_id, p.name, (p.precio*0.16) as iva, p.precio,(p.precio - (p.precio*0.16)) as sub,e.name as estacion'))
        ->where('solicituds.status','Solicitud Aprobada')->get(); */
        $datos=Solicitud::where('solicituds.status','Solicitud Aprobada')
        ->whereBetween('created_at',[$this->ini,$this->fin])->get();
        $total=ProductoSolicitud::join('solicituds as s','s.id','producto_solicitud.solicitud_id')
        ->groupBy('solicitud_id')
        ->where('s.status','Solicitud Aprobada')
        ->whereBetween('s.created_at',[$this->ini,$this->fin])
        ->select(DB::raw('SUM(total) as total, solicitud_id'))->get();

        $totalEX=ProductoExtraordinario::join('solicituds as s','s.id','producto_extraordinario.solicitud_id')
        ->groupBy('solicitud_id')
        ->where('s.status','Solicitud Aprobada')
        ->whereBetween('s.created_at',[$this->ini,$this->fin])
        ->select(DB::raw('SUM(total) as total,SUM(IF(tipo="Servicio",((total -(total*0.16))*0.0125),0)) as isr, solicitud_id'))->get();
        $proveedor=ProductoSolicitud::join('solicituds as s','s.id','producto_solicitud.solicitud_id')
        ->join('proveedors as p','p.id','producto_solicitud.proveedor_id')
        ->where('s.status','Solicitud Aprobada')
        ->whereBetween('s.created_at',[$this->ini,$this->fin])
        ->select('p.titulo_proveedor','s.id','producto_solicitud.producto_id')
        ->get();

        $cantP=ProductoSolicitud::join('solicituds as s','s.id','producto_solicitud.solicitud_id')
        ->where('s.status','Solicitud Aprobada')
        ->whereBetween('s.created_at',[$this->ini,$this->fin])
        ->select('solicitud_id','producto_id','cantidad')->get();
        /* $total2=ProductoSolicitud::join('solicituds as s','s.id','producto_solicitud.solicitud_id')
        ->groupBy('estacion_id')
        ->where('s.status','Solicitud Aprobada')
        ->select(DB::raw('SUM(total) as total, estacion_id'))->get(); */
        //dd($proveedores);
/*         foreach($datos as $d){
            dd($d->productos);
        } */
        //dd($totalEX);
        return view('excels.gastos.GastosGralSheet',compact('datos','total','cantP','totalEX','proveedor'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1=>['font'=>['bold'=>true]],
        ];
    }
    public function columnFormats(): array
    {
        return [
            'F'=>NumberFormat::FORMAT_CURRENCY_USD,
            'G'=>NumberFormat::FORMAT_CURRENCY_USD,
            'H'=>NumberFormat::FORMAT_CURRENCY_USD,
            'I'=>NumberFormat::FORMAT_CURRENCY_USD
        ];
    }
    public function registerEvents(): array
    {
        return[
            AfterSheet::class=>function(AfterSheet $event){
                $cabecera='A1:K1';
                $totalRows = $event->sheet->getHighestRow();
                $general='A1:K'.$totalRows;
                $event->sheet->getDelegate()->getStyle($cabecera)
                            ->applyFromArray([
                                'font' => [
                                    'size'=>12,
                                    'bold' => true,
                                    'color' => ['rgb' => 'ffffff'],
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                    'vertical' => Alignment::VERTICAL_CENTER
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'color' => ['argb' => 'ffcc0000'],
                                ],
                            ]);
                $event->sheet->getDelegate()->getStyle($general)
                ->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
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
        return "Gastos Generales";
    }
}