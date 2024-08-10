<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use App\Models\User;
use App\Models\UserZona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PorAbrir extends Component
{
    use WithPagination;

    public $valid;
    public $search = '';
    public $sortField;
    public $sortDirection = 'asc';
    public $perPage = 5;
    public $from_date = "";
    public $to_date = "";
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    public $comprasCount, $tareasCount;

    public function render()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 2)->first();
        return view('livewire.tickets.por-abrir', [
            'tickets' => $this->tickets,
        ]);
    }
    //Cycle Hooks
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->tickets->pluck('id');
        } else {
            $this->checked = [];
        }
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->ticketsQuery->pluck('id');
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function clearDateFilters()
    {
        $this->from_date = '';
        $this->to_date = '';
        $this->resetPage(); // Opcional: reinicia la paginación si es necesario
    }

    //Obtener los datos y paginación
    public function getTicketsProperty()
    {
        return  $this->getTicketsQueryProperty()->orderBy('created_at', 'desc')->paginate($this->perPage);
    }

    public function getTicketsQueryProperty()
    {
        $user = Auth::user();

        $query = Ticket::query();
        // Excluir los tickets a excepcion de los de status 'Por abrir'  en todos los casos
        $query->whereNotIn('status', ['Cerrado', 'En proceso', 'Abierto']);

        if ($this->search) {
            // Aplicar la búsqueda después de excluir los tickets cerrados, pendientes y abiertos
            $query->search($this->search);
        }

        return $query
            ->when($user->permiso_id == 1 || $user->permiso_id == 8, function ($query) {
                // Si el usuario es Administrador, no aplicamos restricciones
                return $query;
            }, function ($query) use ($user) {
                if ($user->permiso_id == 4) {
                    // ISi el usuario es Compras solo ve sus tickets y el de sus estaciones por zonas asignadas
                    $minions = UserZona::/*whereNotIn('zona_id',[1])->*/whereIn('zona_id', $user->zonas->pluck('id'))->pluck('user_id');
                    //dd($minions);
                    $tck = Ticket::whereIn('solicitante_id', $minions)->pluck('id');
                    $query->where(function ($query) use ($minions,$user) {
                        $query->where('user_id', $user->id)
                            ->orWhereIn('solicitante_id', $minions);
                    });
                    return $query;
                    //$query->whereIn('solicitante_id', $minions)->orWhereIn('user_id', $minions);
                } 
            })
            ->when($this->sortField, function ($query) {
                return $query->orderBy($this->sortField, $this->sortDirection);
            })
            ->when($this->from_date && $this->to_date, function ($query) {
                return $query->whereBetween('created_at', [$this->from_date, $this->to_date . " 23:59:59"]);
            });
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc' : 'asc';

        $this->sortField = $field;
    }
}
