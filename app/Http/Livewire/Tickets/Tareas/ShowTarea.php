<?php

namespace App\Http\Livewire\Tickets\Tareas;

use App\Models\ComentarioTarea;
use App\Models\Tarea;
use Livewire\Component;

class ShowTarea extends Component
{
    public $tareaID,$modal=false;
    public $user_asignado,$asunto,$mensaje,$status,$fecha;
    public $asuntotck,$mensajetck,$idticket,$vencetck,$solicitatck;

    public function showTarea(Tarea $tarea){
        $this->tareaID= $tarea->id;
        $this->user_asignado=$tarea->user->name;
        $this->asunto=$tarea->asunto;
        $this->mensaje=$tarea->mensaje;
        $this->status=$tarea->status;
        $this->fecha=$tarea->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a');

        $this->asuntotck = $tarea->ticket->asunto;
        $this->mensajetck = $tarea->ticket->mensaje;
        $this->idticket = $tarea->ticket->id;
        $this->vencetck = $tarea->ticket->fecha_cierre;
        $this->solicitatck = $tarea->ticket->cliente->name;

        $this->modal=true;
    }
    public function render()
    {
        $comentarios=ComentarioTarea::where('tarea_id',$this->tareaID)->orderBy('id','desc')->get();
        return view('livewire.tickets.tareas.show-tarea', compact('comentarios'));
    }
}
