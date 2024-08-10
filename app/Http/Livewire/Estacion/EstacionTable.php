<?php

namespace App\Http\Livewire\Estacion;

use App\Exports\EstacionExport;
use App\Models\Estacion;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class EstacionTable extends Component
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
        $this->valid = Auth::user()->permiso->panels->where('id', 8)->first();
        return view('livewire.estacion.estacion-table', [
            'trashed' => Estacion::onlyTrashed()->count(),
            'estaciones' => $this->estaciones,
        ]);
    }

    //Cycle Hooks
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->estaciones->pluck('id');
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
        $this->checked = $this->estacionesQuery->pluck('id');
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
    public function getEstacionesProperty()
    {
        return  $this->estacionesQuery->paginate($this->perPage);
    }

    public function getEstacionesQueryProperty()
    {
        $user = Auth::user();
        return Estacion::search($this->search)
            ->when($user->permiso_id == 1  || $user->permiso_id == 5 || $user->permiso_id == 8, function ($query) {
                // Si el usuario es un administrador, no aplicamos restricciones
                return $query;
            }, function ($query) use ($user) {
                if ($user->permiso_id == 4) {
                    // Si el usuario es compras, aplicamos restricciones específicas
                    $zones = $user->zonas->pluck('id')->toArray();
                    $query->whereIn('zona_id', $zones);
                } else {
                    // Si el usuario es un supervisor/gerente, filtramos por sus estaciones asignadas
                    $query->where(function ($subQuery) use ($user) {
                        $subQuery->where('supervisor_id', $user->id)
                            ->orWhere('user_id', $user->id);
                    });
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
           return Excel::download(new EstacionExport($this->checked), 'ESTACIONES.xlsx');
       }

    //Eliminación multiple
    public function deleteEstaciones()
    {
        Estacion::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('flash.banner', 'ELIMINADO, la estación ha sido eliminada del sistema.');
        session()->flash('flash.bannerStyle', 'success');
        return redirect(request()->header('Referer'));
    }
}
