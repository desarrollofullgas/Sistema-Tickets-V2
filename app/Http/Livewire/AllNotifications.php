<?php

namespace App\Http\Livewire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AllNotifications extends Component
{
    use WithPagination;

    public function render(Request $request)
    {
       if ($request->query('search')!=null){
           $notifications = auth()->user()->readNotifications()->where('data','LIKE','%'.$request->query('search').'%')
            ->paginate(50); // Cambia 10 por el número de notificaciones leídas que desees mostrar por página
       }else{
            $notifications = auth()->user()->readNotifications()->paginate(50);
       }

        return view('livewire.all-notifications', [
            'notifications' => $notifications
        ]);
    }

    public function readNotification($id)
    {
        auth()->user()->notifications->find($id)->markAsRead();
    }
}
