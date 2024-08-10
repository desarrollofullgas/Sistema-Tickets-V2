<?php

namespace App\Http\Livewire\Tickets\Tareas;

use App\Models\Tarea;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserArea;
use App\Notifications\TareaAsignadaNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewTarea extends Component
{
    public $ticketID;

    public $modal = false;
    public $asunto;
    public $mensaje;
    public $fecha_cierre;
    public $ticket_id;
    public $user_asignado;

    public function crearTarea()
    {
        $this->validate(
            [
                'asunto' => 'required',
                'mensaje' => 'required',
                'user_asignado' => 'required|exists:users,id',
            ],
            [
                'asunto.required' => 'El campo Asunto es Obligatorio.',
                'mensaje.required' => 'El campo Descripción es Obligatorio',
                'user_asignado.required' => 'El campo Agente es Obligatorio'
            ]
        );

        $ticket = Ticket::find($this->ticketID); // Obtener el ticket correspondiente
        if ($ticket->status === 'Abierto') {
            Alert::warning('Ticket Abierto', 'No se puede crear una tarea para un ticket abierto.');
            return redirect()->route('tck.tarea', ['id' => $ticket->id]); //para redirigir a la pestaña del ticket que se crea la tarea
        } elseif ($ticket->status === 'Cerrado') { // por si admin intenta crear una tarea con ticket cerrado
            Alert::warning('Ticket Cerrado', 'No se puede crear una tarea para un ticket cerrado.');
            return redirect()->route('tck.tarea', ['id' => $ticket->id]);
        }

        // Crear la tarea
        try {
            $tarea = new Tarea();
            $tarea->asunto = $this->asunto;
            $tarea->mensaje = $this->mensaje;
            $tarea->ticket_id = $this->ticketID; // Usar la propiedad $ticketID en lugar de $ticket_id
            $tarea->user_id = Auth::user()->id;
            $tarea->user_asignado = $this->user_asignado;
            $tarea->save();

            $agent = $tarea->user;

            $notification = new TareaAsignadaNotification($tarea);
            $agent->notify($notification);

            // Limpiar los campos del formulario
            $this->asunto = '';
            $this->mensaje = '';
            $this->user_asignado = '';

            // Mostrar mensaje de éxito
            session()->flash('flash.banner', 'La tarea ha sido creada exitosamente.');
            session()->flash('flash.bannerStyle', 'success');
            // Alert::success('Nueva Tarea', 'La tarea ha sido creada exitosamente.');

        } catch (Exception $e) {
            Alert::error('Error', $e->getMessage()); //si hay un eror 
        }

        return redirect()->route('tck.tarea', ['id' => $ticket->id]); //para redirigir a la pestaña del ticket que se crea la tarea
    }

    public function render()
    {
        $ticket = Ticket::find($this->ticketID);
        //$agentes = $ticket->falla->servicio->area->users; // agentes del area que pertenece el ticket
        $agentes = User::where('status', 'Activo')->whereNotIn('permiso_id', [3, 6, 2])->get();
        return view('livewire.tickets.tareas.new-tarea', compact('agentes'));
    }
}
