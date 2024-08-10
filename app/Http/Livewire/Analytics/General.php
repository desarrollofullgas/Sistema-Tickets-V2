<?php

namespace App\Http\Livewire\Analytics;

use App\Models\Tipo;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Livewire\Component;

class General extends Component
{
    public $mes,$tipos=[],$data,$labels;
    public function mount(){
        $dia=Carbon::now();
        $tipos=Tipo::all();
        foreach($tipos as $tipo){
            $cont=0;
            foreach($tipo->prioridad as $prioridad){
                foreach($prioridad->fallas as $falla){
                    $cont+=$falla->tickets([$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
                }
            }
            if($cont>0){

                array_push($this->tipos,['tipo'=>$tipo->name,'total'=>$cont]);
            }
        }
        $this->data=array_column($this->tipos,'total');
        $this->labels=array_column($this->tipos,'tipo');
    }
    public function change(){
        $this->tipos=[];
        $dia=Carbon::create($this->mes);
        $tipos=Tipo::all();
        foreach($tipos as $tipo){
            $cont=0;
            foreach($tipo->prioridad as $prioridad){
                foreach($prioridad->fallas as $falla){
                    $cont+=$falla->tickets([$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
                }
            }
            if($cont>0){

                array_push($this->tipos,['tipo'=>$tipo->name,'total'=>$cont]);
            }
        }
        $this->data=array_column($this->tipos,'total');
        $this->labels=array_column($this->tipos,'tipo');
        $this->emit('updateChart');
    }
    public function render()
    {
        return view('livewire.analytics.general');
    }
}
