<?php

namespace App\Http\Livewire\Permisos;

use Livewire\Component;
use App\Models\Permiso;
use App\Models\PanelPermiso;
use App\Models\Panel;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class NewPermiso extends Component
{
    public $newgPermiso;
    public $titulo_permiso, $descripcion;

    public function mount()
    {
        $this->newgPermiso = false;
    }

    public function showModalFormPermiso()
    {
        $this->newgPermiso=true;
    }

    public function addPermiso()
    {
        $this->validate( [
            'titulo_permiso' => ['required', 'string', 'max:250'],
            'descripcion' => ['required', 'string', 'max:250'],
        ],
        [
            'titulo_permiso.required' => 'El campo Nombre del Rol es obligatorio',
            'titulo_permiso.max' => 'El campo Nombre del Rol no debe ser mayor a 250 caracteres',
            'descripcion.required' => 'El campo Descripción es obligatorio',
            'descripcion.max' => 'El campo Descripción no debe ser mayor a 250 caracteres',
        ]);

        DB::transaction(function () {
            return tap(Permiso::create([
                'titulo_permiso' => Str::title($this->titulo_permiso),
                'descripcion' => Str::ucfirst($this->descripcion),
                'flag_trash' => 0,
            ]));
        });

        DB::transaction(function (){
            $ultid = Permiso::latest('id')->first();

            for ($i = 1; $i <= 29; $i++) { 
                PanelPermiso::create([
                    'permiso_id' => $ultid->id,
                    'panel_id' => $i,
                    'wr' => 0,
                    're' => 0,
                    'ed' => 0,
                    'de' => 0,
                    'vermas' => 0,
                    'verpap' => 0,
                    'restpap' => 0,
                    'vermaspap' => 0,
                ]);
            }
        });
            
        $this->mount();

        Alert::success('Nuevo Permiso', "El Permiso". ' '.$this->titulo_permiso. ' '. "ha sido agregado al sistema");

        return redirect()->route('roles');
    }

    public function render()
    {
        return view('livewire.permisos.new-permiso');
    }
}
