<?php

namespace App\Http\Livewire\Productos\Marcas;

use App\Exports\MarcaExport;
use App\Models\Marca;
use Livewire\Component;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class MarcaTable extends Component
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
        $this->valid = Auth::user()->permiso->panels->where('id', 14)->first();
        return view('livewire.productos.marcas.marca-table', [
            'trashed' => Marca::onlyTrashed()->count(),
            'marcas' => $this->marcas,
        ]);
    }

     //Cycle Hooks
     public function updatedSelectPage($value)
     {
         if ($value) {
             $this->checked = $this->marcas->pluck('id');
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
         $this->checked = $this->marcasQuery->pluck('id');
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
     public function getMarcasProperty()
     {
         return  $this->marcasQuery->paginate($this->perPage);
     }
 
     public function getMarcasQueryProperty()
     {
         return Marca::search($this->search)
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
       return Excel::download(new MarcaExport($this->checked), 'MARCAS.xlsx');
   }
 
     //Eliminación multiple
     public function deleteMarcas()
     {
         Marca::whereKey($this->checked)->delete();
         $this->checked = [];
         $this->selectAll = false;
         $this->selectPage = false;
         session()->flash('flash.banner', 'ELIMINADO, la marca  ha sido eliminada del sistema.');
         session()->flash('flash.bannerStyle', 'success');
         return redirect(request()->header('Referer'));
     }
}
