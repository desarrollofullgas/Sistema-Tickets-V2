<?php

namespace App\Http\Livewire\Sistema\Meals;

use App\Models\Meals;
use App\Models\MealUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class MealAsignment extends Component
{
    public $selectedMealSchedule;
    public $selectedUser;
    public $AsignacionHorario=false;

    public $usuariosAsignados=[];

    public function openModalA(){
        $this->AsignacionHorario=true;
    }

    public function render()
    {
        // $this->updateUserStatus();
        $valid = Auth::user()->permiso->panels->where('id', 24)->first();
        
        $mealSchedules = Meals::all();
        $users = User::where('status','Activo')->whereNotIn('permiso_id',[2,3,6])->orderBy('name','asc')->get();
        $horarios=MealUsers::all();
        return view('livewire.sistema.meals.meal-asignment', ['users' => $users,
         'mealSchedules' => $mealSchedules,
        'horarios' => $horarios, 'valid'=>$valid]);
    }

    public function assignMealSchedule()
    {
        $this->validate([ //validacion para la asignación
            'selectedMealSchedule' => 'required',
            'selectedUser' => 'required',
        ]);

        $meal = Meals::find($this->selectedMealSchedule);

        if (!$meal) {//en caso de que no exista el horario
            Alert::error('ERROR', 'No se encontró el horario seleccionado');
            return redirect()->route('horarios'); 
        }

        $user = User::find($this->selectedUser);

        if (!$user) {// en caso de que no exista el usuario
            Alert::error('ERROR', 'No se encontró el usuario seleccionado');
            return redirect()->route('horarios'); 
        }

        // Validamos si el horario y el usuario ya estan asignados
        $existe = MealUsers::where([
            'user_id' => $user->id,
        ])->first();

        if ($existe) { //si ya existe no procede
            Alert::warning('Atención', 'El usuario ya tiene un horario asignado.');
            return redirect()->route('horarios'); 
        }

        // Creamos la asignación 
        try {
            MealUsers::create([
                'meal_id' => $meal->id,
                'user_id' => $user->id,
            ]);
            Alert::success('Horario Asignado', 'Se ha asignado el horario');
            return redirect()->route('horarios');
        } catch (\Exception $e) {
            Alert::error('ERROR', 'A ocurrido un error al asignar el horario');
            return redirect()->route('horarios');
        }
    }

    // public function updateUserStatus()
    // {
    //     $now = Carbon::now();
    //     $assignedMeals = MealUsers::with('meal', 'user')->get();

    //     foreach ($assignedMeals as $assignment) {
    //         $startTime = Carbon::parse($assignment->meal->start_time);
    //         $endTime = Carbon::parse($assignment->meal->end_time);

    //         if ($now->between($startTime, $endTime)) {
    //             $assignment->user->status = 'Hora Comida';
    //             $assignment->user->save();
    //         }
    //     }
    // }

    public function deleteMealAssignment($assignmentId)
    {
        try { // eliminar asignación
            $assignment = MealUsers::findOrFail($assignmentId);
            $assignment->delete();

            Alert::success('Asignación Eliminada', 'Se ha eliminado la asignación del horario');
        } catch (\Exception $e) {
            Alert::error('ERROR', 'Ocurrió un error al eliminar la asignación del horario');
        }

        return redirect()->route('horarios');
    }
}
