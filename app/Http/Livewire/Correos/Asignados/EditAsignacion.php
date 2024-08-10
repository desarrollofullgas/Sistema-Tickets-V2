<?php

namespace App\Http\Livewire\Correos\Asignados;

use App\Models\Categoria;
use App\Models\CorreosCompra;
use App\Models\CorreosZona;
use App\Models\Zona;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditAsignacion extends Component
{
    public $categoriaID,$categoria,$mailsDelete=[],$zonas,$correos;
    public function mount(){
        $this->categoria=Categoria::find($this->categoriaID);
        $this->correos=$this->categoria->correos;
        $this->zonas=$this->categoria->zonas;
    }
    public function updateAsignacion(){
        CorreosZona::destroy($this->mailsDelete);
        //Alert::success('Lista actualizada', 'Los correos para la categoría "'.$this->categoria->name.'" han sido actualizados');
        session()->flash('flash.banner', 'Lista actualizada, los correos para la categoría "'.$this->categoria->name.'" han sido actualizados');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('correos.asignados');
    }
    public function render()
    {
        return view('livewire.correos.asignados.edit-asignacion');
    }
}