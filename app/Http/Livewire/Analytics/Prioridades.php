<?php

namespace App\Http\Livewire\Analytics;

use App\Models\Prioridad;
use Carbon\Carbon;
use Livewire\Component;

class Prioridades extends Component
{
    public $mes,$data=[],$labels=[];
    public function mount(){
        $dia=Carbon::now();
        $prioridades=Prioridad::all();
        foreach($prioridades as $prioridad){
            $cont=0;
            foreach($prioridad->fallas as $falla){
                $cont+=$falla->tickets([$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            }
            if($cont>0){
                array_push($this->labels,$prioridad->name.'-'.$prioridad->clase->name);
                array_push($this->data,$cont);
            }
        }
    }
    public function updateData(){
        $this->data=[];
        $this->labels=[];
        $dia=Carbon::create($this->mes);
        $prioridades=Prioridad::all();
        foreach($prioridades as $prioridad){
            $cont=0;
            foreach($prioridad->fallas as $falla){
                $cont+=$falla->tickets([$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            }
            if($cont>0){
                array_push($this->labels,$prioridad->name.'-'.$prioridad->clase->name);
                array_push($this->data,$cont);
            }
        }
        $this->emit('updateChart');
    }
    public function render()
    {
        return view('livewire.analytics.prioridades');
    }
}
