<?php

namespace App\Http\Livewire\Servicios;

use App\Models\Departamento;
use App\Models\Servicio;
use App\Models\Tipo;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditServicio extends Component
{
    public $servicioID,$prioridad,$area,$name,$status,$modal=false;
    public function editServicio(Servicio $dato){
        $this->name=$dato->name;
        $this->area=$dato->area_id;
        $this->status=$dato->status;
        $this->modal=true;
    }
    public function updateServicio(Servicio $dato){
        $dato->name=$this->name;
        $dato->area_id=$this->area;
        $dato->status=$this->status;
        $dato->save();
        Alert::success('Actualización realizada','Los datos del registro se actualizaron con éxito');
        // return redirect()->route('servicios');
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        $deptos=Departamento::all()->where('status','Activo');
        return view('livewire.servicios.edit-servicio',compact('deptos'));
    }
}