<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Exports\ComprasExport;
use App\Models\Compra;
use App\Models\Estacion;
use App\Models\Ticket;
use App\Models\UserArea;
use App\Models\UserZona;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class CompraTable extends Component
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

    public function render()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 4)->first();
        return view('livewire.tickets.compras.compra-table', [
            'compras' => $this->compras,
        ]);
    }

    //Cycle Hooks
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->compras->pluck('id');
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
        $this->checked = $this->comprasQuery->pluck('id');
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
    public function getComprasProperty()
{
    return  $this->getComprasQueryProperty()->orderBy('created_at', 'desc')->paginate($this->perPage);
}

    public function getComprasQueryProperty()
    {
        $user = Auth::user();
        return Compra::search($this->search)
            ->when($user->permiso_id == 1 || $user->permiso_id == 8, function ($query) {
                // Si el usuario es un administrador, no aplicamos restricciones
                return $query;
            }, function ($query) use ($user) {
                if ($user->permiso_id == 2) {
                    // Si el usuario es supervisor, aplicamos restricciones específicas
                    $gerentes = Estacion::where('supervisor_id', $user->id)->pluck('user_id');
                    $gerentes->push($user->id);
                    $tck = Ticket::whereIn('solicitante_id', $gerentes)->pluck('id');
                    $query->whereIn('ticket_id', $tck);
                } elseif ($user->permiso_id == 4) {
                    // Si el usuario es COMPRAS, aplicamos restricciones específicas
                    $personal = UserZona::/*whereNotIn('zona_id', [1])->*/whereIn('zona_id', $user->zonas->pluck('id'))->pluck('user_id');
                    $tck = Ticket::where(function ($q) use ($personal) {
                        $q->whereIn('user_id', $personal)
                            ->orWhereIn('solicitante_id', $personal);
                    })->pluck('id');
                    $query->whereIn('ticket_id', $tck);
                } elseif ($user->permiso_id == 7) {
                    // Si el usuario es JEFE DE ÁREA, aplicamos restricciones específicas
                    $personal = UserArea::whereIn('area_id', $user->areas->pluck('id'))->pluck('user_id');
                    $tck = Ticket::where(function ($q) use ($personal) {
                        $q->whereIn('user_id', $personal)
                            ->orWhereIn('solicitante_id', $personal);
                    })->pluck('id');
                    $query->whereIn('ticket_id', $tck);
                } else {
                    // Si el usuario es un agente/gerente, filtramos por sus estaciones asignadas
                    $tck = Ticket::where(function ($q) use ($user) {
                        $q->where('user_id', $user->id)
                            ->orWhere('solicitante_id', $user->id);
                    })->pluck('id');
                    $query->whereIn('ticket_id', $tck);
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

     //Exportar a excel
     public function exportSelected()
     {
         return Excel::download(new ComprasExport($this->checked), 'REQUISICIONES.xlsx');
     }

    //Eliminación multiple
    public function deleteCompras()
    {
        Compra::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('flash.banner', 'ELIMINADO, la estación ha sido eliminada del sistema.');
        session()->flash('flash.bannerStyle', 'success');
        return redirect(request()->header('Referer'));
    }
}
