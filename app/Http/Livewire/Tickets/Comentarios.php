<?php

namespace App\Http\Livewire\Tickets;

use App\Models\ArchivosComentario;
use App\Models\Comentario;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\AdminAgenteComent;
use App\Notifications\AdminClienteComent;
use App\Notifications\AdminNotifyComent;
use App\Notifications\TicketAgenteComentarioNotification;
use App\Notifications\TicketClienteComentarioNotification;
use App\Notifications\TicketComentarioNotification;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class Comentarios extends Component
{
    use WithFileUploads;
    public $ticketID, $status, $mensaje, $urlArchi, $evidencias = [], $statustck, $modal = false;
    public function mount()
    {
        $tck = Ticket::find($this->ticketID);
        $this->status = $tck->status;
    }
    public function addCom(Ticket $tck)
    {
        $this->validate([
            'status' => ['required', 'not_in:0'],
            'mensaje' => ['required']
        ], [
            'status.required' => 'Seleccione el status',
            'mensaje.required' => 'Ingrese el contenido del comentario'
        ]);

        //No cerrar si tiene tareas con status distinto a cerrado
        if ($tck->status != 'Cerrado' && Auth::user()->permiso_id != 1) {
            $tareasPendientes = $tck->tareas->where('status', '!=', 'Cerrado');
            if ($tareasPendientes->isNotEmpty() && $this->status == 'Cerrado') {
                Alert::warning('Tareas Pendientes', 'No es posible cerrar el ticket debido a que existen tareas pendientes.');
                return redirect()->route('tickets');
            }
        }

        //No cerrar si tiene requisiciones con status distinto a completado
        if ($tck->status != 'Cerrado' && Auth::user()->permiso_id != 1) {
            $requisPendientes = $tck->compras->where('status', '!=', 'Completado');
            if ($requisPendientes->isNotEmpty() && $this->status == 'Completado') {
                Alert::warning('Requisiciones Pendientes', 'No es posible cerrar el ticket debido a que existen requisiciones pendientes.');
                return redirect()->route('tickets');
            }
        }

        try {
            $reg = new Comentario();
            $reg->ticket_id = $this->ticketID;
            $reg->user_id = Auth::user()->id;
            $reg->comentario = $this->mensaje;
            $reg->statustck = $this->status;
            $reg->save();

            $tck->status = $this->status;
            $tck->save();

            if ($tck->status == 'Cerrado') {
                $tck->cerrado = now();
                $tck->save();
            }

            if (count($this->evidencias) > 0) {
                foreach ($this->evidencias as $lue) {
                    $this->urlArchi = $lue->store('tck/comentarios', 'public');
                    $archivo = new ArchivosComentario();
                    $archivo->comentario_id = $reg->id;
                    $archivo->nombre_archivo = $lue->getClientOriginalName();
                    $archivo->mime_type = $lue->getMimeType();
                    $archivo->size = $lue->getSize();
                    $archivo->archivo_path = $this->urlArchi;
                    $archivo->save();
                }
            }

            $ticketOwner = $tck->cliente;
            $agent = $tck->agente;
            $currentUserId = Auth::user()->id;
            $currentUser = Auth::user();
			
			$Admins = User::where('permiso_id',1)->whereNotIn('id',[155])->get();

            //Cliente comenta notifica a agente asignado
            if ($currentUserId === $ticketOwner->id) {
                $notification = new TicketAgenteComentarioNotification($tck);
                $agent->notify($notification);
				Notification::send($Admins, new AdminClienteComent($tck));
            } elseif ($currentUserId === $agent->id) { //Agente comenta notifica a cliente (quien solicita el ticket)
                $notification = new TicketClienteComentarioNotification($tck);
                $ticketOwner->notify($notification);
				Notification::send($Admins, new AdminAgenteComent($tck));
            }

            if ($currentUser->permiso_id === 1 || $currentUser->permiso_id === 2 || $currentUser->permiso_id === 7) {
                $notification = new TicketComentarioNotification($tck);
                $ticketOwner->notify($notification);

                $notification = new TicketComentarioNotification($tck);
                $agent->notify($notification);
            }

            // Alert::success('Nuevo Comentario', "El comentario ha sido registrado");
            session()->flash('flash.banner', 'Nuevo Comentario, el comentario se ha registrado correctamente');
            session()->flash('flash.bannerStyle', 'success');
        } catch (Exception $e) {
            Alert::error('ERROR', $e->getMessage());
        }
        return redirect()->route('tck.ver', ['id' => $tck->id]); //para redirigir a la pestaña del ticket que se crea el comentario
    }

    public function removeCom(Comentario $dato)
    {
        foreach ($dato->archivos as $archivo) {
            $archivo->delete();
        }
        $dato->delete();
    }
    public function render()
    {
        // $comentarios=Comentario::where('ticket_id',$this->ticketID)->orderBy('id','desc')->get();
        $tck = Ticket::find($this->ticketID);
        $ticketOwner = $tck->solicitante_id; //para evitar que quien cree el ticket pueda cambiar su status
        $agente = $tck->user_id;
        return view('livewire.tickets.comentarios', compact('tck','ticketOwner','agente'));
    }
}
