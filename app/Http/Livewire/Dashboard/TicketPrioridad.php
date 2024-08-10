<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Prioridad;
use App\Models\UserZona;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TicketPrioridad extends Component
{
    public $mes, $data = [], $labels = [];
    public function mount()
    {
        $userId = Auth::user();

        $minions = UserZona::whereIn('zona_id', $userId->zonas->pluck('id'))->pluck('user_id'); //para los jefes de zona
        $prioridades = DB::table('tickets')
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
            ->join('fallas', 'tickets.falla_id', 'fallas.id')
            ->join('prioridades', 'fallas.prioridad_id', 'prioridades.id')
            ->join('tipos', 'prioridades.tipo_id', 'tipos.id')
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, prioridades.name as prioridad, tipos.name as tipo')
            ->groupBy('fallas.id', 'prioridades.name', 'tipos.name')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->get();
        foreach ($prioridades as $prioridad) {
            $cont = $prioridad->tcks;
            if ($cont > 0) {
                array_push($this->labels, $prioridad->prioridad . '-' . $prioridad->tipo);
                array_push($this->data, $cont);
            }
        }
    }
    public function render()
    {
        return view('livewire.dashboard.ticket-prioridad');
    }
}
