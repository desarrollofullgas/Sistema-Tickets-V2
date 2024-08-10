<?php

namespace App\Http\Livewire\Correos\Lista;

use App\Models\CorreosCompra;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteCorreo extends Component
{
    public $mailID,$correo;
    
    public function mount(){
        $this->correo=CorreosCompra::find($this->mailID)->correo;
    }
    public function deleteCorreo(CorreosCompra $email){
        $email->delete();
        Alert::success('Eliminado','El correo ha sido removido del sistema');
        return redirect()->route('correos');
    }
    public function render()
    {
        return view('livewire.correos.lista.delete-correo');
    }
}