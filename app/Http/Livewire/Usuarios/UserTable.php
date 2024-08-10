<?php

namespace App\Http\Livewire\Usuarios;

use App\Exports\UserExport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class UserTable extends Component
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
        $this->valid = Auth::user()->permiso->panels->where('id', 11)->first();

        return view('livewire.usuarios.user-table', [
            'trashed' => User::onlyTrashed()->count(),
            'usuarios' => $this->usuarios,
        ]);
    }
     //Cycle Hooks
     public function updatedSelectPage($value)
     {
         if ($value) {
             $this->checked = $this->usuarios->pluck('id');
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
         $this->checked = $this->usuariosQuery->pluck('id');
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
      public function getUsuariosProperty()
     {
         return  $this->getUsuariosQueryProperty()->orderBy('created_at','desc')->where('id','!=',1)->paginate($this->perPage);
     }
 
     public function getUsuariosQueryProperty()
{
    $user = Auth::user();

    return User::search($this->search)
        ->when($user->permiso_id == 1 || $user->permiso_id == 5 || $user->permiso_id == 8,  function ($query) {
            // Si el usuario es un administrador, no aplicamos restricciones
            return $query;
        },function ($query) use ($user) {
            // Si el usuario no es un administrador, filtramos por usuarios que compartan zonas
            $userZonas = $user->zonas->pluck('id')->toArray();
            return $query->whereHas('zonas', function ($subQuery) use ($userZonas) {
                $subQuery->whereIn('zonas.id', $userZonas);
            })->where('users.id', '<>', $user->id);
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
         return Excel::download(new UserExport($this->checked), 'USUARIOS.xlsx');
     }
 
     //Eliminación multiple
     public function deleteUsuarios()
     {
         User::whereKey($this->checked)->delete();
         $this->checked = [];
         $this->selectAll = false;
         $this->selectPage = false;
         session()->flash('flash.banner', 'ELIMINADO, la estación ha sido eliminada del sistema.');
         session()->flash('flash.bannerStyle', 'success');
         return redirect(request()->header('Referer'));
     }
}
