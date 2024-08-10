<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\Compra;
use App\Models\ComentariosCompra;
use App\Models\ComentarioTarea;
use App\Notifications\RechazoCompraNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class CompraReject extends Component
{
    public $compraID,$observacion,$modal=false;
    public function rechazo(Compra $compra){
        $this->validate([
            'observacion' =>'required',
        ],[
            'observacion.required' => 'Ingrese el motivo del rechazo',
        ]);
        $comentario=new ComentariosCompra();
        $comentario->compra_id=$compra->id;
        $comentario->user_id=Auth::user()->id;
        $comentario->comentario=$this->observacion;
        $comentario->status=$compra->status;
        $comentario->save();
        $compra->status='Rechazado';
        $compra->save();
		
		$catPS = $compra->productos->count() > 0 ? 'Producto' : 'Servicio';
        $statPS = $compra->productos->count() > 0 ? 'Rechazado' : 'Rechazado';

        $tarea = $compra->tareas->first();
        if ($tarea) {
        $tarea->status = 'Cerrado';
        $tarea->fecha_cierre = Carbon::now();
        $tarea->save();
        $comt = new ComentarioTarea();
        $comt->tarea_id = $tarea->id;
        $comt->user_id = Auth::user()->id;
        $comt->comentario = $catPS.' '.$statPS.','.' '. $this->observacion;
        $comt->statustarea = $tarea->status;
        $comt->save();
        }
        
        $agent = $compra->ticket->agente;
        //dd($agent);
        $agent->notify(new RechazoCompraNotification($compra));
        // Alert::warning('Compra rechazada','El status de la compra ha sido actualizada');
        session()->flash('flash.banner', 'La requisición ha sido rechazada');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('requisiciones');
    }
    public function render()
    {
        return view('livewire.tickets.compras.compra-reject');
    }
}
