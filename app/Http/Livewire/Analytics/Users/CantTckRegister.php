<?php

namespace App\Http\Livewire\Analytics\Users;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class CantTckRegister extends Component
{
    public $users,$mes,$data=[],$labels=[];
    public function mount(){
        $dia=Carbon::now();
        $this->users=User::all();
        foreach($this->users as $user){
            $cont=$user->tckGen()->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            if($cont>0){
                array_push($this->labels,$user->name);
                array_push($this->data,$cont);
            }
        }
    }
    public function updateData(){
        $this->data=[];
        $this->labels=[];
        $dia=Carbon::create($this->mes);
        foreach($this->users as $user){
            $cont=$user->tckGen()->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            if($cont>0){
                array_push($this->labels,$user->name);
                array_push($this->data,$cont);
            }
        }
        $this->emit('updateChart');
    }
    public function render()
    {
        return view('livewire.analytics.users.cant-tck-register');
    }
}
