<?php

namespace App\Http\Livewire\Correos\Asignados;

use App\Models\CorreosServicio;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditCorreosServicio extends Component
{
    public $correos,$zonas,$mailsDelete=[];
    public function mount(){
        $this->correos=CorreosServicio::all();
        $this->zonas=CorreosServicio::select('zona_id')->groupBy('zona_id')->get();
    }
    public function updateAsignacion(){
        CorreosServicio::destroy($this->mailsDelete);
        Alert::success('Lista actualizada', 'Los correos para los servicios han sido actualizados');
        return redirect()->route('correos.asignados');
    }
    public function render()
    {
        return view('livewire.correos.asignados.edit-correos-servicio');
    }
}