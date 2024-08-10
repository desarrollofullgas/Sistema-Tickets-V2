<?php

namespace App\Http\Livewire\Analytics;

use App\Models\Falla;
use Carbon\Carbon;
use Livewire\Component;

class Fallas extends Component
{
    public $mes,$data=[],$labels=[];
    public function mount(){
        $dia=Carbon::now();
        $fallas=Falla::all();
        foreach($fallas as $falla){
            $cont=$falla->tickets([$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            if($cont>0){
                array_push($this->labels,$falla->name);
                array_push($this->data,$cont);
            }
        }
    }
    public function updateData(){
        $this->data=[];
        $this->labels=[];
        $dia=Carbon::create($this->mes);
        $fallas=Falla::all();
        foreach($fallas as $falla){
            $cont=$falla->tickets([$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            if($cont>0){
                array_push($this->labels,$falla->name);
                array_push($this->data,$cont);
            }
        }
        $this->emit('updateChart');
    }
    public function render()
    {
        return view('livewire.analytics.fallas');
    }
}
