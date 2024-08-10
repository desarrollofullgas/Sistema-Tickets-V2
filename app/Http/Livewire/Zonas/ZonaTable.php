<?php

namespace App\Http\Livewire\Zonas;

use App\Exports\ZonaExport;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Zona;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ZonaTable extends Component
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


    //protected $queryString = ['sortField', 'sortDirection'];
    public function render()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 12)->first();

        //$trashed = Zona::onlyTrashed()->count();
        return view('livewire.zonas.zona-table', [
            'trashed' => Zona::onlyTrashed()->count(),
            'zonas' => $this->zonas,
        ]);
    }

    //Cycle Hooks
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->zonas->pluck('id');
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
        $this->checked = $this->zonasQuery->pluck('id');
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
    public function getZonasProperty()
    {
        return  $this->zonasQuery->paginate($this->perPage);
    }

    public function getZonasQueryProperty()
    {
        $user = Auth::user();

        return Zona::search($this->search)
            ->when($user->permiso_id == 1 || $user->permiso_id == 5, function ($query) {
                // Si el usuario es un administrador, no aplicamos restricciones
                return $query;
            }, function ($query) use ($user) {
                // Si el usuario es un supervisor, filtramos por sus zonas asignadas
                $zones = $user->zonas->pluck('id')->toArray();
                return $query->whereIn('zonas.id', $zones);
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
        return Excel::download(new ZonaExport($this->checked), 'ZONAS.xlsx');
    }

    //Eliminación multiple
    public function deleteZonas()
    {
        Zona::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('flash.banner', 'ELIMINADO, la zona  ha sido eliminada del sistema.');
        session()->flash('flash.bannerStyle', 'success');
        return redirect(request()->header('Referer'));
    }
}
