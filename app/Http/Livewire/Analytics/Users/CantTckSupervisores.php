<?php

namespace App\Http\Livewire\Analytics\Users;

use App\Models\Zona;
use Carbon\Carbon;
use Livewire\Component;

class CantTckSupervisores extends Component
{
    public $mes;
    public $labels=[], $groups=[] ,$dataGroups=[];

    public function mount(){
        $dia=Carbon::now();
        $this->mes=$dia->firstOfMonth()->format('Y-m');
        $this->updateChart();
    }
    public function updateData(){
        $this->updateChart();
        $this->emit('updateChart');
    }
    public function updateChart(){
        $this->labels=[];
        $this->groups=[];
        $this->dataGroups=[];
        $zonas=Zona::all();
        $dia=Carbon::create($this->mes);
        foreach($zonas as $z){
            array_push($this->labels,$z->name);
        }
        foreach($zonas as $z){
            $total=0;
            $dataUsers=[];
            foreach($z->users as $user){
                $cant=$user->tckGen->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
                if($cant > 0){
                    $total+=$cant;
                    array_push($dataUsers,[$user->name,$cant]);
                }
            }
            array_push($this->groups,['value' => $total, 'groupId' =>$z->name]);
            array_push($this->dataGroups,['dataGroupId'=>$z->name,'data'=>$dataUsers]);
        }
    }
    public function render()
    {
        return view('livewire.analytics.users.cant-tck-supervisores');
    }
}