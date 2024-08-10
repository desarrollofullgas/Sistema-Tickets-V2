<?php

namespace App\Notifications;

use App\Models\Compra;
use App\Models\Tarea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TareaRequisicionNotification extends Notification
{
    use Queueable;
    
    public $tarea, $compraID;

    /**
     * Create a new notification instance.
     */
    public function __construct(Tarea $tarea,  $compraID)
    {
        $this->tarea = $tarea;
        $this->compraID = $compraID;
    }
/**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'url' => route('tck.ver', $this->tarea->ticket->id),
            'message' => "Hola {$this->tarea->user->name}, se ha aprobado la requisición # {$this->compraID}, con el ticket #{$this->tarea->ticket->id}, por lo que se te ha creado una tarea
             para llevar un debido seguimiento de la misma"
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
        ]);
    }
}
