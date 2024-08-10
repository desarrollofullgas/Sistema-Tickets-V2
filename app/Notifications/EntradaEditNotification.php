<?php

namespace App\Notifications;

use App\Models\ProductosEntrada;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EntradaEditNotification extends Notification
{
    use Queueable;
    public $reg;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProductosEntrada $reg)
    {
        $this->reg = $reg;
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
        $folio = ProductosEntrada::where('productos_entradas.id', $this->reg->id)
    ->join('entradas', 'productos_entradas.entrada_id', '=', 'entradas.id')
    ->join('folios_entradas', 'entradas.folio_id', '=', 'folios_entradas.id')
    ->select('folios_entradas.*')
    ->first();
    $user = Auth::user();
        
        return [
            'url' => route('folios.entradas'),
            'userid' =>$user,
            'user' => Auth::user()->name,
            'message' =>", ha actualizado la  ENTRADA de productos en el almacén, FOLIO: {$folio->folio}",
        ];
    }


    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([ ]);
    }
}
