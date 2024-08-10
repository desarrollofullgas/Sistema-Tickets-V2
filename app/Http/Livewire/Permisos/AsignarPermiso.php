<?php

namespace App\Http\Livewire\Permisos;

use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Permiso;
use App\Models\PanelPermiso;
use App\Models\Panel;

class AsignarPermiso extends Component
{
    public $AsigPermiso, $name, $le, $check;
    public $permiso_asig_id, $perm, $permission, $permiso_asig_name;

    public $titulo_permiso, $descripcion;

    public $leer = [];
    public $crear = [];
    public $editar = [];

    public function mount()
    {
        $this->AsigPermiso = false;
    }

    public function confirmPermisoAsig(int $id)
    {
        $permiso = Permiso::where('id', $id)->first();

        $this->permiso_asig_id = $id;
        $this->permiso_asig_name = $permiso->titulo_permiso;
        $this->titulo_permiso = $permiso->titulo_permiso;
        $this->descripcion = $permiso->descripcion;
        //dd($this->permiso_asig_id);
        $this->AsigPermiso = true;
    }

    public function AsignarPermiso($id, Request $request)
    {
        $this->validate([
            'titulo_permiso' => ['required', 'string'],
            'descripcion' => ['required', 'string'],
        ],
        [
            'titulo_permiso.required' => 'El campo Nombre de Rol es obligatorio',
            'descripcion.required' => 'El campo Descripción es obligatorio',
        ]);

        for ($i=1; $i <= count(Panel::all()); $i++) { 
            foreach ($this->leer as $key => $value) {
                $permi = PanelPermiso::where('permiso_id', $id)->where('panel_id', $i)->first();
                $permi->forceFill([ 
                    're' => $value['valer'],
                ])->save();
            }
        }
        $this->AsigPermiso = false;

        Alert::success('Permisos Actualizados', "El Rol". ' '.$this->titulo_permiso. ' '. "ha actualizado sus permisos en el sistema");

        return redirect()->route('roles');
    }

    public function render()
    {
        //$this->permission = Permiso::where('id', $this->permiso_asig_id)->first();

        $this->permission = Panel::all()->take(31);
//dd($this->permission);
        $this->perm = PanelPermiso::where('permiso_id', $this->permiso_asig_id)->get();
        //dd($this->perm);
        return view('livewire.permisos.asignar-permiso');
    }
}
