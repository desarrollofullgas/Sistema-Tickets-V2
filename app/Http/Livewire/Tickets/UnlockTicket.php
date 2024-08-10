<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Comentario;
use App\Models\Ticket;
use App\Notifications\TicketReAbiertoNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class UnlockTicket extends Component
{
    public $ticketID,$mensaje,$statustck,$status,$modal=false;
    public function unlockTicket(Ticket $tck){
        
        $tck->status="Abierto";
        $tck->cerrado = NULL;
        $tck->save();

        $reg=new Comentario();
        $reg->ticket_id=$tck->id;
        $reg->user_id=Auth::user()->id;
		$reg->tipo='Abrir';
        $reg->comentario=$this->mensaje;
        $reg->statustck=$tck->status;
        $reg->save();
        $tck->status = $tck->status;
        $tck->save();

        $ticketOwner = $tck->cliente;
        $agent = $tck->agente;

        $notification = new TicketReAbiertoNotification($tck);
        $ticketOwner->notify($notification);

        $notification = new TicketReAbiertoNotification($tck);
        $agent->notify($notification);

        Alert::success('Ticket Abierto','El ticket #'.$this->ticketID.' ha sido actualizado');
        return redirect()->route('tickets');
    }
    public function render()
    {
        return view('livewire.tickets.unlock-ticket');
    }
}
