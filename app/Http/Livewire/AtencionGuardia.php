<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AtencionGuardia extends Component
{
    public $showPopup = false; // definimos en false la variable que define si esta o no abierto el modal

    public function mount()
    {
        $this->checkPopupVisibility(); //la función mount validara que se cumpla la instrucción
    }

    public function checkPopupVisibility() // instrucción
    {
        $currentDay = now()->dayOfWeek; // definimos la variable para saber el dia
        $currentTime = now()->format('H:i'); // defnimos la variable para saber la hora

        // Esta es nuestra condición =  si el dia es igual a sabado(6) y el horario esta entre la 1 de la tarde y 10 de la noche o si el 
        // dia es domingo(0) y el horario esta entre las 9 de la mañana y 10 de la noche
        // entonces la instrucción se ejecuta, de lo contrario no se ejecuta
        if (($currentDay == 6 && $currentTime >= '13:00' && $currentTime <= '22:00') || ($currentDay == 0 && $currentTime >= '09:00' && $currentTime <= '22:00')) {
            $this->showPopup = true;
        } else {
            $this->showPopup = false;
        }
    }

    public function closePopup() // funcion para cerrar el modal 
    {
        $this->showPopup = false;
    }

    public function render()
    {
        return view('livewire.atencion-guardia');
    }
}
