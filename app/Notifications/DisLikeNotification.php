<?php

namespace App\Notifications;

use App\Models\Like;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class DisLikeNotification extends Notification
{
    use Queueable;
    public $dislike;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Like $dislike)
    {
        $this->dislike = $dislike;
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
        $user = Auth::user();
        return [
            'url' => route('tck.ver', $this->dislike->comentario->ticket->id),
            'userid' =>  $user,
            'user' => Auth::user()->name,
            'message' => ", ha reaccionado con No Me Gusta al comentario en el ticket #{$this->dislike->comentario->ticket->id}: {$this->dislike->comentario->comentario}"
        ];
    }


    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([ ]);
    }
}
