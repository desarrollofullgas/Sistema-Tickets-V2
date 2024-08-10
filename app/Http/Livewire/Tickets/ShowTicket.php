<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Areas;
use App\Models\Falla;
use App\Models\Ticket;
use Livewire\Component;

class ShowTicket extends Component
{
    public $ticketID,$cliente,$asunto,$mensaje,$creacion,$cierre,$evidenciaArc,$falla,$servicio;
    
    public function render()
    {
        $tck = Ticket::find($this->ticketID);
        $this->ticketID=$tck->id;
        //$this->asunto=$tck->asunto;
        $this->mensaje=$tck->mensaje;
        $this->evidenciaArc=$tck->archivos;
        $this->falla=$tck->falla->name;
        $this->servicio=$tck->falla->servicio->name;
        return view('livewire.tickets.show-ticket');
    }
}
