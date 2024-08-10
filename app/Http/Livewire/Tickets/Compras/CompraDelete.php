<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\Compra;
use App\Models\User;
use App\Notifications\DeletedCompraNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CompraDelete extends Component
{
    public $compraID,$modal=false;
    public function deleteCompra(Compra $compra){
        $Admins = User::where('permiso_id',1)->where('id','!=',auth()->id())->get();
        $Compras = User::where('permiso_id',4)->where('id','!=',auth()->id())->get();
        //Storage::disk('public')->delete($compra->documento);
         /*if ($compra->evidencias->isNotEmpty()) {
        	foreach ($compra->evidencias as $evidencia) {
            Storage::disk('public')->delete($evidencia->archivo_path);
        	}
    	}*/
        $compra->delete();
        //Notification::send($Admins, new DeletedCompraNotification($compra));
        //Notification::send($Compras, new DeletedCompraNotification($compra));
        session()->flash('flash.banner', 'La requisicion ha sido eliminada');
        session()->flash('flash.bannerStyle', 'success');
    }
    public function render()
    {
        return view('livewire.tickets.compras.compra-delete');
    }
}
