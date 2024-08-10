<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AtencionGuardia extends Component
{
    public $showPopup = false; // Variable que determina si el modal debe mostrarse

    public function mount()
    {
        $this->checkPopupVisibility(); // Verifica si el modal debe mostrarse
    }

    /**
     * Verifica la visibilidad del popup según el día y la hora actual.
     */
    public function checkPopupVisibility()
    {
        $currentDay = now()->dayOfWeek; // Obtiene el día de la semana actual
        $currentTime = now()->format('H:i'); // Obtiene la hora actual en formato HH:MM

        // Condiciones para mostrar el popup:
        // Si es sabado (6) entre las 13:00 y las 22:00
        // o si es domingo (0) entre las 9:00 y las 22:00
        if (($currentDay == 6 && $currentTime >= '13:00' && $currentTime <= '22:00') ||
            ($currentDay == 0 && $currentTime >= '09:00' && $currentTime <= '22:00')) {
            $this->showPopup = true; // Muestra el popup
        } else {
            $this->showPopup = false; // Oculta el popup
        }
    }

    /**
     * Cierra y vuelve a abrir el popup.
     */
    public function togglePopup()
    {
        $this->showPopup = false; // Cierra el popup
        $this->emit('togglePopup'); // Emite un evento para abrir el popup nuevamente
    }

    public function render()
    {
        return view('livewire.atencion-guardia');
    }
}

