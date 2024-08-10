<?php

namespace App\Http\Livewire\Usuarios\Guardias;

use App\Models\Guardia;
use App\Models\User;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewUserGuardia extends Component
{
    public $personal,$usuario,$modal=false,$falla;
    public function mount(){
        $registrados=Guardia::all()->pluck('user_id');
        $this->personal=User::whereNotIn('id',$registrados)->whereNotIn('permiso_id',[1,2,3,4,6,8])->orderBy('name', 'ASC')->get();
    }
    public function addGuardia(){
        $this->validate([
            'usuario'=>['required'],
        ],[
            'usuario.required'=>'Seleccione un usuario'
        ]);
        $orden=(Guardia::all()->count())+1;
        $guardia=new Guardia();
        $guardia->user_id=$this->usuario;
        $guardia->orden=$orden;
        $guardia->save();
        Alert::success('Usuario asignado','El usuario ha sido registrado');
        return redirect()->route('guardias.home');
    }
    public function render()
    {
        return view('livewire.usuarios.guardias.new-user-guardia');
    }
}
