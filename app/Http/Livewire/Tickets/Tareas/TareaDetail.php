<?php

namespace App\Http\Livewire\Tickets\Tareas;

use App\Models\Tarea;
use Livewire\Component;

class TareaDetail extends Component
{
    public $tareaID,$tarea,$evidenciaArc,$modal=false;
    public function showTarea(Tarea $tarea){
        $this->tarea = $tarea;
        $this->modal=true;
    }
    public function render()
    {
        return view('livewire.tickets.tareas.tarea-detail');
    }
}
