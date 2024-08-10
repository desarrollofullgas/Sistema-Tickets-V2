<?php

namespace App\Http\Livewire\TopTickets;

use Carbon\Carbon;
use App\Models\UserZona;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListAbiertos extends Component
{
    protected $listeners = ['ticketCreated' => 'render'];
    public $isDetailsOpen = false;

    public function toggleDetailsA()
    {
        $this->isDetailsOpen = !$this->isDetailsOpen;
    }

    public function render()
    {
        //Listado ultimos 5 tickets por status
        $mesEnCurso = Carbon::now()->monthName; //Obtenemos el nombre del mes en curso
        $mesActual = Carbon::now()->month; //Obtenemos el mes en curso para cotejar en la condicion de visibilidad de los tickets
        $userId = Auth::user(); // Obtenemos al usuario Auntenticado
        $minions = UserZona::whereIn('zona_id', $userId->zonas->pluck('id'))->pluck('user_id'); //para los jefes de zona


        //Obtenemos los ultimos 5 registros del mes en curso y separados según status
        //Definimos la función "Si es usuario Administrador, permite ver todos" de lo contrario solo los que pertenezcan al usuario
        $ultimosAbiertos = DB::table('tickets')
            ->join('fallas', 'tickets.falla_id', '=', 'fallas.id')
            ->join('users', 'tickets.solicitante_id', '=', 'users.id')  // Agregar join con la tabla 'users'
            ->select('tickets.*', 'fallas.name as nombre_falla', 'tickets.id as tck', 'users.name as solicitante_name')
            ->where('tickets.status', 'Abierto')
            ->where(function ($query) use ($userId, $minions) {
                if ($userId->permiso_id !== 1 && $userId->permiso_id !== 7  && $userId->permiso_id !== 4) {
                    $query->where('tickets.user_id', $userId->id)
                        ->orWhere('tickets.solicitante_id', $userId->id);
                } elseif ($userId->permiso_id === 7) {
                    $query->where('tickets.user_id', $userId->id)
                        ->orWhereIn('tickets.solicitante_id', $minions);
                }elseif ($userId->permiso_id === 4) {
                    $query->where('tickets.user_id', $userId->id)
                        ->orWhereIn('tickets.solicitante_id', $minions);
                }
            })
            ->whereMonth('tickets.created_at', $mesActual)
            ->orderBy('tickets.id', 'desc')
            ->take(5)
            ->get();
            
        return view('livewire.top-tickets.list-abiertos', [
            'ultimosAbiertos' => $ultimosAbiertos,
            'mesEnCurso' => $mesEnCurso,
        ]);
    }
}
