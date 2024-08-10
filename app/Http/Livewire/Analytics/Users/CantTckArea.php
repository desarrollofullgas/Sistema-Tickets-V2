<?php

namespace App\Http\Livewire\Analytics\Users;

use App\Models\Areas;
use Carbon\Carbon;
use Livewire\Component;

class CantTckArea extends Component
{
    public $areas,$mes,$data=[],$labels=[];
    public function mount(){
        $dia=Carbon::now();
        $this->areas=Areas::all();
        foreach ($this->areas as $area){
            $cont=0;
            foreach($area->users as $user){
                $cont+=$user->tckGen->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            }
            if($cont>0){
                array_push($this->labels,$area->name);
                array_push($this->data,$cont);
            }
        }
    }
    public function updateData()
    {
        $this->data = [];
        $this->labels = [];
        $dia=Carbon::create($this->mes);
        foreach ($this->areas as $area){
            $cont=0;
            foreach($area->users as $user){
                $cont+=$user->tckGen->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            }
            if($cont>0){
                array_push($this->labels,$area->name);
                array_push($this->data,$cont);
            }
        }
        $this->emit('updateChart');
    }
    public function render()
    {
        return view('livewire.analytics.users.cant-tck-area');
    }
}
