<?php

namespace App\Http\Livewire\Sistema\Holiday;

use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class HolidayComponent extends Component
{
    public $holidays;
    public $name;
    public $date;
    public $ModalFestivo=false;

    public function openModal(){
        $this->ModalFestivo=true;
    }

    public function mount()
    {
        $this->holidays = Holiday::all();
    }

    public function createHoliday()
    {
        $this->validate([ // validamos que se ingresen valores en formato fecha
            'name' => 'required',
            'date' => 'required',
        ]);

         // Revisamos si el festivo/inhábil ya esta en el sistema
         $festivoExiste = Holiday::where([
            'name' => $this->name,
            'date' => $this->date,
        ])->first();

        if ($festivoExiste) { // lanzamos advertencia en caso de que el festivo/inhábil ya este registrado y no procede la creación
            Alert::warning('Atención', 'El festivo/inhábil que intentas agregar ya se encuentra registrado en el sistema.');
            return redirect()->route('profile.show'); 
        }

        try { // creacion del festivo/inhábil
            Holiday::create([
                'name' => $this->name,
                'date' => $this->date,
            ]);
    
           Alert::success('Nuevo festivo/inhábil', 'Se ha añadido un nuevo festivo/inhábil de comida');
           return redirect()->route('profile.show'); //volvemos a la ventana Perfil

        } catch (\Exception $e) { //en caso de que ocurra un error 
            Alert::error('ERROR', 'A ocurrido un error al añadir el festivo/inhábil');
            return redirect()->route('profile.show'); 
        }

        $this->holidays = Holiday::all();
    }
    public function render()
    {
        $valid = Auth::user()->permiso->panels->where('id', 24)->first();
        return view('livewire.sistema.holiday.holiday-component',compact('valid'));
    }

    public function deleteFestivo($festivoId)
    {
        try {
            $fest = Holiday::findOrFail($festivoId);//eliminar festivo/inhábil
            $fest->delete();

            Alert::success('Festivo/Inhábil Eliminado', 'Se ha eliminado el festivo/inhábil de comida');
            return redirect()->route('profile.show');
        } catch (\Exception $e) {
            Alert::error('ERROR', 'Ocurrió un error al eliminar el festivo/inhábil de comida');
            return redirect()->route('profile.show');
        }
    }
}
