<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use Livewire\Component;

class DetailsTck extends Component
{
    public $ticketID,$tck;
    public function mount(){
        $this->tck=Ticket::find($this->ticketID);
    }
    public function render()
    {
        return view('livewire.tickets.details-tck');
    }
}
