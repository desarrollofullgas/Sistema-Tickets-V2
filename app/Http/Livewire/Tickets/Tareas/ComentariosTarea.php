<?php

namespace App\Http\Livewire\Tickets\Tareas;

use App\Models\Comentario;
use App\Models\ComentarioTarea;
use App\Models\Tarea;
use App\Models\Ticket;
use App\Notifications\TareaComentarioNotification;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ComentariosTarea extends Component
{
    public $tareaID, $tarea_id, $user_id,
        $comentario, $status, $mensaje, $tarea, $statustarea, $asignado;

    public function mount()
    {
        $tarea = Tarea::find($this->tareaID);
        $this->status = $tarea->status;
        $this->asignado = $tarea->user;
            //dd($this->asignado);
    }

    public function addCom(Tarea $tarea)
    {
        $this->validate([
            'status' => ['required', 'not_in:0'],
            'mensaje' => ['required']
        ], [
            'status.required' => 'Seleccione el status',
            'mensaje.required' => 'Ingrese el contenido del comentario'
        ]);

        try {
            $reg = new ComentarioTarea();
            $reg->tarea_id = $this->tareaID;
            $reg->user_id = Auth::user()->id;
            $reg->comentario = $this->mensaje;
            $reg->statustarea = $this->status;
            $reg->save();
            $tarea->status = $this->status;
            $tarea->save();
            if ($tarea->status == 'Cerrado') {
                $tarea->fecha_cierre  = now();
                $tarea->save();
            }


            $ticketId = $reg->tarea->ticket_id;

            $agent = $tarea->usercrea;

            $notification = new TareaComentarioNotification($tarea);
            $agent->notify($notification);

            // Alert::success('Tarea Actualizada', 'Se ha actualizado la información de la tarea');
            session()->flash('flash.banner', 'Se ha actualizado la información de la tarea');
            session()->flash('flash.bannerStyle', 'success');
        } catch (Exception $e) {
            Alert::error('ERROR', $e->getMessage());
        }

        if (Auth::id() == $this->asignado->id){
            return redirect()->route('tareas');
        }else{
            return redirect()->route('tck.tarea', ['id' => $ticketId]); //para redirigir a la pestaña del ticket que se crea el comentario de la tarea usuario Agente
        }
        
    }
    public function removeCom(ComentarioTarea $dato)
    {
        $dato->delete();
    }
    public function render()
    {
        $comentarios = ComentarioTarea::where('tarea_id', $this->tareaID)->orderBy('id', 'desc')->get();
        return view('livewire.tickets.tareas.comentarios-tarea', compact('comentarios'));
    }
}
