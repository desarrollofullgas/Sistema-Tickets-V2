<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Comentario;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DisLikeNotification;
use App\Notifications\LikeNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeDislike extends Component
{
    //propiedad, Una instancia del modelo Comentario que representa el comentario con el que se relacionan los me gusta y los no me gusta
    public $comentario;

    //metodo, Inicializa el componente con una instancia de Comentario dada.
    public function mount(Comentario $comentario)
    {
        $this->comentario = $comentario;
    }

    //metodo, Maneja las reacciones like o dislike segun se seleccione
    public function toggleLike($type)
    {
        // Validamos el tipo de reaccion es like o dislike
        if (!in_array($type, ['like', 'dislike'])) {
            return;
        }

        //Comprueba si al usuario autenticado (Auth::id()) ya le ha gustado o no le ha gustado el comentario.
        $existingLike = Like::where('comentario_id', $this->comentario->id)
            ->where('user_id', Auth::id())
            ->first();

        $typeString = $type; // Simplificamos el tipo a asignar

        $admins = User::where('permiso_id', 1)->where('status', 'Activo')->get();// Llamamos a los usuarios administradores activos

        if ($existingLike) {
            if ($existingLike->type === $typeString) {
                $existingLike->delete(); // eliminamos la reaccion like/dislike
            } else {
                $existingLike->type = $typeString; // actualizamos la reaccion like/dislike
                $existingLike->save();

                if ($typeString === 'dislike') {
                    Notification::send($this->comentario->usuario, new DisLikeNotification($existingLike)); // Enviar notificación de dislike
                } else {
                    Notification::send($admins, new LikeNotification($existingLike));
                }
            }
        } else {
            $newLike = new Like();
            $newLike->comentario_id = $this->comentario->id;
            $newLike->user_id = Auth::id();
            $newLike->type = $typeString; // establecemos la nueva reaccion
            $newLike->save();

            if ($typeString === 'like') {
                Notification::send($this->comentario->usuario, new LikeNotification($newLike));
            } else {
                Notification::send($admins, new DisLikeNotification($newLike));
            }
        }

        $this->comentario->load('likes'); // recargamos la relacion
    }


    public function render()
    {
        return view('livewire.tickets.like-dislike');
    }
}
