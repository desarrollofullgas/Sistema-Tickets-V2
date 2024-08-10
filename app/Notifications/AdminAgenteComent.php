<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminAgenteComent extends Notification
{
    use Queueable;
    public $ticket;

    /**
    * Create a new notification instance.
    *
    * @return void
    */
   public function __construct(Ticket $ticket)
   {
       $this->ticket = $ticket;
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
       return [
           'url' => route('tck.ver', $this->ticket->id),
           'userid' =>  $this->ticket->agente->toArray(),
           'user' => $this->ticket->agente->name,
           'message' => ", ha realizado un nuevo comentario para el ticket 
           #{$this->ticket->id}, ESTADO: {$this->ticket->status}." 
       ];
   }

   public function toBroadcast(object $notifiable): BroadcastMessage
   {
       return new BroadcastMessage([ ]);
   }
}
