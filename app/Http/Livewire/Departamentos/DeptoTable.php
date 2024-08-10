<?php

namespace App\Http\Livewire\Departamentos;

use App\Exports\DeptoExport;
use App\Models\Departamento;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class DeptoTable extends Component
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
        $this->valid = Auth::user()->permiso->panels->where('id', 7)->first();

        return view('livewire.departamentos.depto-table', [
            'trashed' => Departamento::onlyTrashed()->count(),
            'departamentos' => $this->departamentos,
        ]);
    }

      //Cycle Hooks
      public function updatedSelectPage($value)
      {
          if ($value) {
              $this->checked = $this->departamentos->pluck('id');
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
          $this->checked = $this->departamentosQuery->pluck('id');
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
      public function getDepartamentosProperty()
      {
          return  $this->departamentosQuery->paginate($this->perPage);
      }
  
      public function getDepartamentosQueryProperty()
      {
          return Departamento::search($this->search)
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
         return Excel::download(new DeptoExport($this->checked), 'DEPARTAMENTOS.xlsx');
     }
  
      //Eliminación multiple
      public function deleteDeptos()
      {
          Departamento::whereKey($this->checked)->delete();
          $this->checked = [];
          $this->selectAll = false;
          $this->selectPage = false;
          session()->flash('flash.banner', 'ELIMINADO, el departamento  ha sido eliminada del sistema.');
          session()->flash('flash.bannerStyle', 'success');
          return redirect(request()->header('Referer'));
      }
}
