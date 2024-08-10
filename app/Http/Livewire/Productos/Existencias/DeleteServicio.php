<?php

namespace App\Http\Livewire\Productos\Existencias;

use App\Models\TckServicio;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteServicio extends Component
{
    public $servicioID;
    public function deleteServicio(TckServicio $servicio){
        $servicio->delete();
        Alert::warning('Servicio eliminado','El servicio ha sido removido de la base de datos');
        return redirect()->route('serviciosTCK');
    }
    public function render()
    {
        return view('livewire.productos.existencias.delete-servicio');
    }
}
