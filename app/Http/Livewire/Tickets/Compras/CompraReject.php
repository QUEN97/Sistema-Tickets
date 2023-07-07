<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\Compra;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class CompraReject extends Component
{
    public $compraID,$observacion,$modal=false;
    public function rechazo(Compra $compra){
        $this->validate([
            'observacion' =>'required',
        ],[
            'observacion.required' => 'Ingrese el motivo del rechazo',
        ]);
        $compra->status='Rechazado';
        $compra->com_rev=$this->observacion;
        $compra->save();
        Alert::warning('Compra rechazada','El status de la compra ha sido actualizada');
        return redirect()->route('requisiciones');
    }
    public function render()
    {
        return view('livewire.tickets.compras.compra-reject');
    }
}
