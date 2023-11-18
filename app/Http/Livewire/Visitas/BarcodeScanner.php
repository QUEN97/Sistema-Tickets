<?php

namespace App\Http\Livewire\Visitas;

use App\Models\User;
use App\Models\Visita;
use Livewire\Component;
class BarcodeScanner extends Component
{
    public $barcode;
    public $usuario, $asignado,$visitaID,$visita,$status;

    public function buscarUsuario()
    {
        $this->usuario = User::where('username', $this->barcode)->first();
        $this->visita =  Visita::findOrFail($this->visitaID);
    }
    public function updateVisita(Visita $visita)
    {
        $this->asignado = $this->usuario->id;

        $visita->user_id = $this->asignado;
        $visita->status = 'En proceso';
        $visita->save();
        session()->flash('flash.banner', 'Usuario Asignado, la visita ha sido actualizada en el sistema.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.visitas.barcode-scanner');
    }
}
