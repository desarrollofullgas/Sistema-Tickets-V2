<?php

namespace App\Notifications;

use App\Models\ProductosSalida;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class SalidaEditNotification extends Notification
{
    use Queueable;
    public $reg;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProductosSalida $reg)
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
         $folio = ProductosSalida::where('productos_salidas.id', $this->reg->id)
    ->join('salidas', 'productos_salidas.salida_id', '=', 'salidas.id')
    ->join('folios_salidas', 'salidas.folio_id', '=', 'folios_salidas.id')
    ->select('folios_salidas.*')
    ->first();
    $user = Auth::user();
        
        return [
            'url' => route('folios.salidas'),
            'userid' => $user,
            'user' => Auth::user()->name,
            'message' =>", ha actualizado la  SALIDA de productos en el almacén, FOLIO: {$folio->folio}",
        ];
    }


    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([ ]);
    }
}
