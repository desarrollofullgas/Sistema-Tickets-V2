<?php

namespace App\Http\Livewire\Visitas;

use App\Models\ArchivosVisita;
use App\Models\User;
use App\Models\Visita;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowVisita extends Component
{
    public $visitaID;
    public $modal = false;
    public $usuario, $user, $areas, $areasNombres, $horas, $minutos, $segundos;
    public $mostrarCompleto = false;

    public function mostrarMas()
    {
        $this->mostrarCompleto = true;
    }
    public function mostrarMenos()
    {
        $this->mostrarCompleto = false;
    }
    public function showVisita()
    {
        $this->modal = true;

        $visita = Visita::find($this->visitaID);
        $users = $visita->usuario; // Obtener todos los usuarios asociados a la visita

        // Convertir las horas de llegada y retirada a objetos DateTime
        $horaLlegada = new DateTime($visita->llegada);
        $horaRetirada = new DateTime($visita->retirada);
        // Calcular la diferencia entre las horas
        $diferencia = $horaLlegada->diff($horaRetirada);
        // Calcular el tiempo total en horas, minutos y segundos
        $this->horas = $diferencia->h + ($diferencia->days * 24);
        $this->minutos = $diferencia->i;
        $this->segundos = $diferencia->s;

        $this->usuario = []; // Inicializar el arreglo de usuarios y sus áreas

        foreach ($users as $user) {
            $userDetails = User::where('id', $user->id)->first();

            $arraycollectID = [];
            $areasArray = DB::table('user_areas')->select('area_id')->where('user_id', $user->id)->get();
            foreach ($areasArray as $area) {
                $arraycollectID[] = $area->area_id;
            }

            $areasNombres = DB::table('areas')->whereIn('id', $arraycollectID)->pluck('name');

            $this->usuario[] = [
                'user' => $userDetails,
                'areasNombres' => $areasNombres,
                'permiso' => $userDetails->permiso->titulo_permiso ?? null // Asegúrate de manejar el caso en el que no haya permiso
            ];
        }
    }

    public function render()
    {
        $visita = Visita::find($this->visitaID);
        $evidenciaArc = ArchivosVisita::where('visita_id', $this->visitaID)->where('flag_trash', 0)->get();
        return view('livewire.visitas.show-visita', ['visita' => $visita, 'evidenciaArc' => $evidenciaArc]);
    }
}
