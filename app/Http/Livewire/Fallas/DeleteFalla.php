<?php

namespace App\Http\Livewire\Fallas;

use App\Models\Falla;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteFalla extends Component
{
    public $fallaID,$name,$modal=false;
    public function ConfirmDelete(Falla $falla){
        $this->name = $falla->name;
        $this->modal=true;
    }
    public function deleteFalla(Falla $falla){
        $falla->status="Inactivo";
        $falla->delete();
        $falla->save();
        Alert::success("Eliminado","La falla '".$falla->name."' ha sido eliminada");
        return redirect()->route('fallas');
    }
    public function render()
    {
        return view('livewire.fallas.delete-falla');
    }
}