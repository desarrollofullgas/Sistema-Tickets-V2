<?php

namespace App\Http\Livewire\Analytics\Compras;

use App\Models\TckServicio;
use Carbon\Carbon;
use Livewire\Component;

class ServProd extends Component
{
    public $servicios,$mes,$data=[],$labels=[];
    public function mount(){
        $dia=Carbon::now();
        $this->servicios=TckServicio::all();
        foreach($this->servicios as $servicio){
            $cont=$servicio->compras->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            if($cont>0){
                array_push($this->labels,$servicio->name);
                array_push($this->data,$cont);
            }
        }
    }
    public function updateData(){
        $dia=Carbon::create($this->mes);
        $this->data = [];
        $this->labels = [];
        foreach($this->servicios as $servicio){
            $cont=$servicio->compras->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            if($cont>0){
                array_push($this->labels,$servicio->name);
                array_push($this->data,$cont);
            }
        }
        $this->emit('updateChart');
    }
    public function render()
    {
        return view('livewire.analytics.compras.serv-prod');
    }
}
