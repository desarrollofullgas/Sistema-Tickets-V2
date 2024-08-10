<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Comentario;
use App\Models\Ticket;
use App\Notifications\TicketReasignadoNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Reasignar extends Component
{
    public $ticketID, $personal, $asignado, $mensaje, $status, $statustck;
    public function mount()
    {
        $ticket = Ticket::find($this->ticketID);
        $this->personal = $ticket->falla->servicio->area->users()->where('status', 'Activo')->get();
        $this->asignado = $ticket->user_id;
    }
    public function changeAgente(Ticket $tck)
    {
        if ($tck->status === "Cerrado") {
            Alert::error('Ticket Cerrado', 'El ticket #' . $this->ticketID . ' está cerrado y no se puede reasignar.');
            return redirect()->route('tickets');
        }
        $this->validate([
            'mensaje'=>['required']
        ],[
            'mensaje.required'=>'Ingrese el motivo de la reasignación.'
        ]);
        $tck->user_id = $this->asignado;
        $tck->save();

        $reg = new Comentario();
        $reg->ticket_id = $tck->id;
        $reg->user_id = Auth::user()->id;
		$reg->tipo='Reasignacion';
        $reg->comentario = $this->mensaje;
        $reg->statustck = $tck->status;
        $reg->save();
        $tck->status = $tck->status;
        $tck->save();

        $agent = $tck->agente;

        $notification = new TicketReasignadoNotification($tck);
        $agent->notify($notification);

        Alert::success('Ticket Reasignado', 'El ticket #' . $this->ticketID . ' ha sido actualizado');
        if ($tck->status == "Por abrir") {
            return redirect()->route('tck.abierto');
        } else {
            return redirect()->route('tickets');
        }
    }
    public function render()
    {
        return view('livewire.tickets.reasignar');
    }
}
