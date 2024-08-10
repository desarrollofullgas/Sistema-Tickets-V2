<?php

namespace App\Http\Livewire\Analytics\Users;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class CantTckAsignado extends Component
{
    public $users,$mes,$data=[],$labels=[],$groups=[],$dataGroups=[],$tcks=[];
    public function mount(){
        $dia=Carbon::now();
        $this->mes=$dia->firstOfMonth()->format('Y-m');
        //$this->users=User::all();
        $this->changeData();
        $this->emit('updateChartUser');
        /* foreach($this->users as $user){
            $cont=$user->tickets()->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            if($cont>0){
                array_push($this->labels,$user->name);
                array_push($this->data,$cont);
            }
        } */
    }
    public function updateData(){
        $this->changeData();
        //dd($this->tcks,$this->dataGroups);
        $this->emit('updateChartUser');
    }
    public function changeData(){
        $this->data=[];
        $this->labels=[];
        $this->groups=[];
        $this->dataGroups=[];
        $users=User::all();
        $dia=Carbon::create($this->mes);
        foreach($users as $user){
            $bajo=0;
            $medio=0;
            $alto=0;
            $critico=0;
            $altoCritico=0;
            $cont=$user->tickets()->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()]);
            if($cont->count() > 0){
                foreach($cont->get() as $tck){
                    if($tck->falla->prioridad->name=='Bajo'){
                        $bajo++;
                    }
                    if($tck->falla->prioridad->name=='Medio'){
                        $medio++;
                    }
                    if($tck->falla->prioridad->name=='Alto'){
                        $alto++;
                    }
                    if($tck->falla->prioridad->name=='Crítico'){
                        $critico++;
                    }
                    if($tck->falla->prioridad->name=='Alto Crítico'){
                        $altoCritico++;
                    }
                }
                array_push($this->labels,$user->name);
                array_push($this->groups,['value' => $cont->count(), 'groupId' =>$user->name]);
                $dataUser=[
                    ['Bajos',$bajo],
                    ['Medios',$medio],
                    ['Altos',$alto],
                    ['Altos Criticos',$altoCritico],
                    ['Críticos',$critico],
                ];
                array_push($this->dataGroups,['dataGroupId'=>$user->name,'data'=>$dataUser]);
            }
        }
    }
    public function render()
    {
        return view('livewire.analytics.users.cant-tck-asignado');
    }
}
