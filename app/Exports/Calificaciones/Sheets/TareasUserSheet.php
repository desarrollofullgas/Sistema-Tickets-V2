<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Tarea;
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

class TareasUserSheet implements FromView,ShouldAutoSize,WithTitle,WithEvents
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
        $tabla=[];
        $agentes=User::whereHas('tareas',function(Builder $tareas)use($rango){
            $tareas->whereBetween('created_at',$rango);
        })->get();
        foreach($agentes as $user){
            array_push($tabla,[
                'name'=>$user->name,
                'abierto'=>Tarea::where([['status','Abierto'],['user_asignado',$user->id]])->whereBetween('created_at',$rango)->count(),
                'proceso'=>Tarea::where([['status','En Proceso'],['user_asignado',$user->id]])->whereBetween('created_at',$rango)->count(),
                'cerrado'=>Tarea::where([['status','Cerrado'],['user_asignado',$user->id]])->whereBetween('created_at',$rango)->count(),
                'totales'=>Tarea::where('user_asignado',$user->id)->whereBetween('created_at',$rango)->count()
            ]);
        }
        $totales=[
            'abierto'=>Tarea::where('status','Abierto')->whereBetween('created_at',$rango)->count(),
            'proceso'=>Tarea::where('status','En Proceso')->whereBetween('created_at',$rango)->count(),
            'cerrado'=>Tarea::where('status','Cerrado')->whereBetween('created_at',$rango)->count(),
            'totales'=>Tarea::whereBetween('created_at',$rango)->count()
        ];
        return view('excels.calificaciones.tareas-user',compact('tabla','totales'));
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
        return 'Tareas asignadas';
    }
}
