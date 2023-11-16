<?php

namespace App\Http\Livewire\Visitas;

use App\Models\User;
use App\Models\Visita;
use Livewire\Component;

use function Ramsey\Uuid\v1;

class BarcodeScanner extends Component
{
    public $barcode;
    public $usuario, $asignado,$visitaID,$status;

    // public function mount(){
    //     $vta =  Visita::findOrFail($this->visitaID);
    //     $this->id=$vta->id;
    // }

    public function buscarUsuario()
    {
        $this->usuario = User::where('username', $this->barcode)->first();
    }
    public function updateVisita(Visita $visita)
    {
        $this->asignado = $this->usuario->id;

        $visita->user_id = $this->asignado;
        $visita->status = 'En proceso';
        $visita->save();
    }
    public function render()
    {
        return view('livewire.visitas.barcode-scanner');
    }
}
