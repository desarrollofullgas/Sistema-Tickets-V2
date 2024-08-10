<?php

namespace App\Http\Livewire\Visitas;

use App\Models\ArchivosVisita;
use App\Models\User;
use App\Models\UserVisita;
use App\Models\Visita;
use Carbon\Carbon;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class BarcodeScanner extends Component
{
    public $barcode, $visitaID, $visita, $asignado;
    public $usuarios = []; // Lista para almacenar los usuarios escaneados

    public function buscarUsuario()
    {
        $usuario = User::where('status', 'Activo')->where('username', $this->barcode)->first();
        if ($usuario && !in_array($usuario, $this->usuarios, true) && !$this->usuarioEstaEnLista($usuario)) {
            $this->usuarios[] = $usuario; // Agregar usuario a la lista si no existe
        }
        //dd($this->usuarios);
        $this->barcode = ''; // reseteamos el input luego de escanear

        $this->visita = Visita::findOrFail($this->visitaID);
    }
    private function usuarioEstaEnLista($usuario)
    { //realiza un recorrido en el array y ubica al usuario, para no agregarlo dos veces en una misma visita
        return collect($this->usuarios)->contains('id', $usuario->id);
    }
    public function limpiarListaUsuarios()
    {
        $this->usuarios = []; // Vaciar la lista de usuarios
    }

    public function updateVisita(Visita $visita)
    {
        foreach ($this->usuarios as $usuario) {
            $asignado = new UserVisita();
            $asignado->visita_id = $this->visitaID;
            $asignado->user_id = is_array($usuario) ? ($usuario['id'] ?? null) : ($usuario->id ?? null);

            $asignado->save();
        } //el operador null-safe (??) se utiliza para proporcionar un valor por defecto (null) si la propiedad o clave "id" no está presente ni en la matriz ni en el objeto

        $visita =  Visita::findOrFail($this->visitaID);
        $visita->status = 'En proceso';
        $visita->llegada = Carbon::now();
        $visita->save();

        // Restablecer la lista de usuarios después de registrar las visitas
        $this->usuarios = [];

        session()->flash('flash.banner', 'Asignación Realizada, la visita ha sido actualizada en el sistema.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.visitas.barcode-scanner');
    }
}
