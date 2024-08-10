<?php

namespace App\Http\Livewire\Analytics\Users;

use App\Models\Zona;
use Carbon\Carbon;
use Livewire\Component;

class CantTckZona extends Component
{
    public $zonas,$mes,$data=[],$labels=[];
    public function mount(){
        $dia=Carbon::now();
        $this->zonas=Zona::all();
        foreach($this->zonas as $zona){
            $cont=0;
            foreach ($zona->users as $user) {
                $cont+=$user->tckGen->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            }
            if($cont>0){
                array_push($this->labels,$zona->name);
                array_push($this->data,$cont);
            }
        }
    }
    public function updateData(){
        $this->data = [];
        $this->labels = [];
        $dia=Carbon::create($this->mes);
        foreach($this->zonas as $zona){
            $cont=0;
            foreach ($zona->users as $user) {
                $cont+=$user->tckGen->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            }
            if($cont>0){
                array_push($this->labels,$zona->name);
                array_push($this->data,$cont);
            }
        }
        $this->emit('updateChart');
    }
    public function render()
    {
        return view('livewire.analytics.users.cant-tck-zona');
    }
}
