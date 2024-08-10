<?php

namespace App\Http\Livewire\Sistema\Meals;

use App\Models\Meals;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class MealScheduleCreate extends Component
{
    public $inicio;
    public $fin;
    public $ModalHorario=false;

    public function openModal(){
        $this->ModalHorario=true;
    }

    public function render()
    {
        $valid = Auth::user()->permiso->panels->where('id', 24)->first();
        $mealSchedules = Meals::all();//llamado a los horarios en el sistema
        return view('livewire.sistema.meals.meal-schedule-create', ['mealSchedules' => $mealSchedules, 'valid'=>$valid]);
    }

    public function save()
    {
        $this->validate([ // validamos que se ingresen valores en formato hora
            'inicio' => 'required|date_format:H:i',
            'fin' => 'required|date_format:H:i|after:start_time',
        ]);

         // Revisamos si el horario ya esta en el sistema
         $horarioExiste = Meals::where([
            'start_time' => $this->inicio,
            'end_time' => $this->fin,
        ])->first();

        if ($horarioExiste) { // lanzamos advertencia en caso de que el horario ya este registrado y no procede la creación
            Alert::warning('Atención', 'El horario que intentas agregar ya se encuentra registrado en el sistema.');
            return redirect()->route('horarios'); 
        }

        try { // creacion del horario
            Meals::create([
                'start_time' => $this->inicio,
                'end_time' => $this->fin,
            ]);
    
            $this->reset(['inicio', 'fin']);//reinicia los campos
           Alert::success('Nuevo horario', 'Se ha añadido un nuevo horario de comida');
           return redirect()->route('horarios'); //volvemos a la ventana Perfil

        } catch (\Exception $e) { //en caso de que ocurra un error 
            Alert::error('ERROR', 'A ocurrido un error al añadir el horario');
            return redirect()->route('horarios'); 
        }
    }

    public function deleteMealSchedule($mealId)
    {
        try {
            $meal = Meals::findOrFail($mealId);//eliminar horario
            $meal->delete();

            Alert::success('Horario Eliminado', 'Se ha eliminado el horario de comida');
            return redirect()->route('horarios');
        } catch (\Exception $e) {
            Alert::error('ERROR', 'Ocurrió un error al eliminar el horario de comida');
            return redirect()->route('horarios');
        }
    }

}
