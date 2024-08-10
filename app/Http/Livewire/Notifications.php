<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Notifications extends Component
{
	public $count = 5;

   public function getListeners(){
       return [
           'echo-notification:App.Models.User.' . auth()->id() . ',TicketAsignadoNotificacion' => 'render',
       ];
   }

 	 public function getNotificationsProperty(){// De aqui obtenemos la propiedad computada $this->notifications
        return auth()->user()->notifications->take($this->count);//truncamos el limite de notificaciones a mostrar basandonos en el count
   }
	
    public function readNotification($id)
    {
        auth()->user()->notifications->find($id)->markAsRead();
        // DB::table('notifications')->where('id', $notification['id'])->update(['read_at' =>now()]);

    }
    public function readAllNotification($notifiable_id)
    {
        // auth()->user()->unreadNotifications->markAsRead();
        DB::table('notifications')->where('notifiable_id', $notifiable_id)->update(['read_at' =>now()]);

    }
    public function render()
    {
        return view('livewire.notifications');
    }
}
