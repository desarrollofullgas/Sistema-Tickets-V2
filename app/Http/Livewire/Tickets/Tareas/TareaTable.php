<?php

namespace App\Http\Livewire\Tickets\Tareas;

use App\Exports\TareasExport;
use App\Models\Tarea;
use App\Models\Ticket;
use App\Models\UserArea;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TareaTable extends Component
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
        $this->valid = Auth::user()->permiso->panels->where('id', 3)->first();
        return view('livewire.tickets.tareas.tarea-table', [
            'tareas' => $this->tareas,
        ]);
    }

     //Cycle Hooks
     public function updatedSelectPage($value)
     {
         if ($value) {
             $this->checked = $this->tareas->pluck('id');
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
         $this->checked = $this->tareasQuery->pluck('id');
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
     public function getTareasProperty()
     {
         return  $this->getTareasQueryProperty()->orderBy('created_at', 'desc')->paginate($this->perPage);
     }
 
     public function getTareasQueryProperty()
     {
         $user = Auth::user();
         return Tarea::search($this->search)
             ->when($user->permiso_id == 1 || $user->permiso_id == 8, function ($query) {
                 // Si el usuario es un administrador, no aplicamos restricciones
                 return $query;
             }, function ($query) use ($user) {
                 if ($user->permiso_id == 2) {
                     // Si el usuario es supervisor, aplicamos restricciones específicas
                     $userId = Auth::user()->id;
                     $query->where('user_id', $userId)->orWhere('user_asignado',$userId);
                 } elseif ($user->permiso_id == 4) {
                    //Compras
                    $userId = Auth::user()->id;
                     $query->where(function($query) use ($userId) {
    				$query->where('user_id', $userId)
       				->orWhere('user_asignado', $userId);
					});
					 return $query;
                 } elseif ($user->permiso_id == 7) {
                     // Si el usuario es jefe de área, aplicamos restricciones específicas
                     $userId = Auth::user()->id;
                     $personal=UserArea::whereIn('area_id',$user->areas->pluck('id'))->pluck('user_id');
                     $query->whereIn('user_asignado', [$userId, $personal]);
                 } else {
                      // Si el usuario es un agente, filtramos por sus tareas asignadas
                    $userId = Auth::user()->id;
                    $tck = Ticket::where('user_id', $userId)->orWhere('solicitante_id', $userId)->pluck('id');
                    $query->where(function ($query) use ($userId, $tck) {
                        $query->where('user_id', $userId)
                            ->orWhere('user_asignado', $userId)
                            ->orWhereIn('ticket_id', $tck); // Mostramos las tareas de los tickets del agente
                    });
                    return $query;
                    //$query->where('user_id', $userId)->orWhere('user_asignado',$userId);
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
         return Excel::download(new TareasExport($this->checked), 'TAREAS.xlsx');
     }
 
     //Eliminación multiple
     public function deleteTareas()
     {
         Tarea::whereKey($this->checked)->delete();
         $this->checked = [];
         $this->selectAll = false;
         $this->selectPage = false;
         session()->flash('flash.banner', 'ELIMINADO, la tarea ha sido eliminada del sistema.');
         session()->flash('flash.bannerStyle', 'success');
         return redirect(request()->header('Referer'));
     }
}
