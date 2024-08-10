<?php

namespace App\Http\Livewire\Analytics\Users;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CantTckIndividual extends Component
{
    public $mes,$user,$userList=[],$list;
    public function mount(){
        $this->mes=Carbon::now()->format('Y-m');
        $this->user=Auth::user()->id;
        foreach(User::all() as $user){
            if($user->tickets()->count() >0){
                array_push($this->userList,['id'=>$user->id,'name'=>$user->name]);
            }
        }
        $this->list=$this->calificaciones();
    }
    public function calificaciones():array{
        //$prioridades=[['Bajo',1],['Medio',2],['Alto',3],['Crítico',4],['Alto Crítico',5]];
        $total=[];
        $bajo=[];
        $medio=[];
        $alto=[];
        $cr=[];
        $altCr=[];
        $mes=Carbon::create($this->mes);
        $user=User::find($this->user);   
        $tcks=$user->tickets->whereBetween('created_at',[$mes->startOfMonth()->toDateTimeString(),$mes->endOfMonth()->toDateTimeString()]);
       
        foreach($tcks as $tck){
            if($tck->falla->prioridad->name=='Bajo'){
                array_push($bajo,$tck);
            }
            if($tck->falla->prioridad->name=='Medio'){
                array_push($medio,$tck);
            }
            if($tck->falla->prioridad->name=='Alto'){
                array_push($alto,$tck);
            }
            if($tck->falla->prioridad->name=='Crítico'){
                array_push($cr,$tck);
            }
            if($tck->falla->prioridad->name=='Alto Crítico'){
                array_push($altCr,$tck);
            }
        }
        array_push($total,['bajo'=>$bajo,'medio'=>$medio,'alto'=>$alto,'critico'=>$cr,'altCr'=>$altCr]);
        return $total;
    }
    public function updatedMes(){
        $this->list=$this->calificaciones();
    }
    public function updatedUser(){
        $this->list=$this->calificaciones();
    }
    public function render()
    {
        return view('livewire.analytics.users.cant-tck-individual');
    }
}