<?php

namespace App\Http\Livewire\Usuarios;

use Livewire\Component;

class UserStatus extends Component
{
    public $userStatus;

    public function mount()
    {
        if (auth()->check()) {
            $this->userStatus = auth()->user()->status;
        }
    }

    public function toggleStatus()
    {
        if ($this->userStatus === 'Activo') {
            $this->userStatus = 'Hora Comida';
        } else {
            $this->userStatus = 'Activo';
        }

        if (auth()->check()) {
            $user = auth()->user();
            $user->status = $this->userStatus;
            $user->save();
        }
    }
    public function render()
    {
        return view('livewire.usuarios.user-status');
    }
}
