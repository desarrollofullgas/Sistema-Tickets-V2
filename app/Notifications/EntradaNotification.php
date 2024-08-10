<?php

namespace App\Notifications;

use App\Models\FoliosEntrada;
use App\Models\ProductosEntrada;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EntradaNotification extends Notification
{
    use Queueable;
    public $pe;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProductosEntrada $pe)
    {
        $this->pe = $pe;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
         $folio = ProductosEntrada::where('productos_entradas.id', $this->pe->id)
    ->join('entradas', 'productos_entradas.entrada_id', '=', 'entradas.id')
    ->join('folios_entradas', 'entradas.folio_id', '=', 'folios_entradas.id')
    ->select('folios_entradas.*')
    ->first();
    $user = Auth::user();
        
        return [
            'url' => route('folios.entradas'),
            'userid' =>$user,
            'user' => Auth::user()->name,
            'message' =>", ha generado  ENTRADA de productos en el almacén, FOLIO: {$folio->folio}",
        ];
    }


    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([ ]);
    }
}
