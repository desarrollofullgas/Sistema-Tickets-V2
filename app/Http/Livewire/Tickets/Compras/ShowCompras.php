<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\Compra;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ShowCompras extends Component
{
    public $ticketID,$compras,$modal=false,$comprasCount;
    public function mount(){
        $this->compras=Compra::where('ticket_id',$this->ticketID)->orderBy('id', 'desc')->get();
		$this->comprasCount=Compra::where('ticket_id',$this->ticketID)->count();
		foreach ($this->compras as $compra) {
            $compra->documentoNombre = basename($compra->documento);
        }
    }
    public function deleteCompra($id){
        $compra=Compra::find($id);
        //dd($compra->evidencias);
        Storage::disk('public')->delete($compra->documento);
         if ($compra->evidencias->isNotEmpty()) {
            foreach ($compra->evidencias as $evidencia) {
                Storage::disk('public')->delete($evidencia->archivo_path);
            }
        }
        $compra->delete();
        Alert::warning('Eliminado','La requisición ha sido eliminada permanentemente');
        return redirect()->route('tickets');
    }
    public function render()
    {
        return view('livewire.tickets.compras.show-compras');
    }
}
