<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\UserZona;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TicketEstado extends Component
{
    public $mes, $data = [], $labels = [];
    public function mount()
    {
        $userId = Auth::user();

        $minions = UserZona::whereIn('zona_id', $userId->zonas->pluck('id'))->pluck('user_id'); //para los jefes de zona
        $estados = DB::table('tickets')
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
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, tickets.status as nombre')
            ->groupBy('nombre')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->get();
        foreach ($estados as $estado) {
            $cont = $estado->tcks;
            if ($cont > 0) {
                array_push($this->labels, $estado->nombre);
                array_push($this->data, $cont);
            }
        }
    }
    public function render()
    {
        return view('livewire.dashboard.ticket-estado');
    }
}
