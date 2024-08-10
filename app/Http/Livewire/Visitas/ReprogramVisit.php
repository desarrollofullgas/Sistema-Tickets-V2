<?php

namespace App\Http\Livewire\Visitas;

use App\Models\Visita;
use Livewire\Component;

class ReprogramVisit extends Component
{
    public $visitaID, $estacion,$fecha;

    public function mount()
    {
        $visita = Visita::find($this->visitaID);
        $this->estacion = $visita->estacion->name;
        $this->fecha = $visita->fecha_programada;
    }
    public function reproVisita(Visita $visita)
    {
        $visita->fecha_programada = $this->fecha;
        $visita->status = 'Pendiente';
        $visita->save();

        // $reg = new Comentario();
        // $reg->ticket_id = $tck->id;
        // $reg->user_id = Auth::user()->id;
        // $reg->tipo='Reasignacion';
        // $reg->comentario = $this->mensaje;
        // $reg->statustck = $tck->status;
        // $reg->save();
        // $tck->status = $tck->status;
        // $tck->save();

        // $agent = $tck->agente;

        // $notification = new TicketReasignadoNotification($tck);
        // $agent->notify($notification);

        session()->flash('flash.banner', 'Visita Reprogramada, la visita  ha sido actualizada en el sistema.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.visitas.reprogram-visit');
    }
}
