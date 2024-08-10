<?php

namespace App\Http\Livewire\Correos\Asignados;

use App\Models\Categoria;
use App\Models\CorreosServicio;
use App\Models\CorreosZona;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class AsignadoTable extends Component
{
    use WithPagination;

    public $valid;
    public $search = '';
    public $sortField;
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $from_date = "";
    public $to_date = "";
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;

    public function render()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 23)->first();
        return view('livewire.correos.asignados.asignado-table', [
            'categorias' => $this->categorias,
            'correos' => CorreosZona::all(),
            'servs' => CorreosServicio::all()->count(),
        ]);
    }

   //Cycle Hooks
   public function updatedSelectPage($value)
   {
       if ($value) {
           $this->checked = $this->categorias->pluck('id');
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
       $this->checked = $this->categoriasQuery->pluck('id');
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
   public function getCategoriasProperty()
   {
       return  $this->categoriasQuery->paginate($this->perPage);
   }

   public function getCategoriasQueryProperty()
   {
       return Categoria::search($this->search)
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
