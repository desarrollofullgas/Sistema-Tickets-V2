<?php

namespace App\Http\Livewire\Tickets\Tareas;

use App\Models\ComentarioTarea;
use App\Models\Tarea;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TareaReasignada;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditTarea extends Component
{
    public $modal = false;
    public $tareaID;
    public $ticketID;
    public $asunto, $user_asignado;
    public $mensaje, $status;

    public function editTarea(Tarea $tarea)
    {
        $this->tareaID = $tarea->id;
        $this->ticketID = $tarea->ticket_id;
        $this->asunto = $tarea->asunto;
        $this->mensaje = $tarea->mensaje;
        $this->status = $tarea->status;
        $this->user_asignado = $tarea->user_asignado;
        $this->modal = true;
    }

    public function updateTarea()
    {
        $this->validate([
            'asunto' => 'required',
            'mensaje' => 'required',
            'user_asignado' => 'required|exists:users,id',
        ]);

        $tarea = Tarea::findOrFail($this->tareaID);

        // Revisa si el usuario asignado es distinto al actual
        if ($tarea->user_asignado != $this->user_asignado) {
            // Notificar tarea reasignada
            $newAssignedUser = User::findOrFail($this->user_asignado);
            $newAssignedUser->notify(new TareaReasignada($tarea));
        }

        // Actualizar atributos
        $tarea->asunto = $this->asunto;
        $tarea->mensaje = $this->mensaje;
        $tarea->status = $this->status;
        $tarea->user_asignado = $this->user_asignado;

        // Agregar la fecha de cierre y comentario
        if ($this->status == 'Cerrado') {
            $tarea->fecha_cierre = now();

            $reg = new ComentarioTarea();
            $reg->tarea_id = $this->tareaID;
            $reg->user_id = Auth::user()->id;
            $reg->comentario = 'Tarea Cerrada';
            $reg->statustarea = $this->status;
            $reg->save();
        }

        // Guardar la tarea
        $tarea->save();

        // Ocultar el modal
        $this->modal = false;

        // Mostrar mensaje de éxito
        session()->flash('flash.banner', 'La tarea ha sido actualizada exitosamente.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('tck.tarea', ['id' => $this->ticketID]);
    }

    public function render()
    {
        $ticket = Ticket::find($this->ticketID);
        // $agentes = [];

        // if ($ticket && $ticket->falla && $ticket->falla->servicio && $ticket->falla->servicio->area) {
        //     $agentes = $ticket->falla->servicio->area->users;
        // }
        $agentes = User::where('status', 'Activo')->whereNotIn('permiso_id', [3, 6, 2])->get();
        return view('livewire.tickets.tareas.edit-tarea', compact('agentes'));
    }
}
