<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class NewNotifications extends Component
{
    use WithPagination;
    public function render(Request $request)
    {
        if($request->query('search')!=null){
            $notificationsNew = auth()->user()->unreadNotifications()->where('data','LIKE','%'.$request->query('search').'%')
            ->paginate(50)->withQueryString();
        }else{
            $notificationsNew = auth()->user()->unreadNotifications()
                ->paginate(50)->withQueryString(); // Cambia 10 por el número de notificaciones no leídas que desees mostrar por página
        }
        return view('livewire.new-notifications', [
            'notificationsNew' => $notificationsNew
        ]);
    }
    public function readNotification($id)
    {
        auth()->user()->notifications->find($id)->markAsRead();
		return redirect(request()->header('Referer'));
    }
}
