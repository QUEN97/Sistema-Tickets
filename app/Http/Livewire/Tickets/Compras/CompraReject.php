<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\Compra;
use App\Models\ComentariosCompra;
use Illuminate\Support\Facades\Auth;
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
        $comentario=new ComentariosCompra();
        $comentario->compra_id=$compra->id;
        $comentario->user_id=Auth::user()->id;
        $comentario->comentario=$this->observacion;
        $comentario->status=$compra->status;
        $comentario->save();
        $compra->status='Rechazado';
        $compra->save();
        Alert::warning('Compra rechazada','El status de la compra ha sido actualizada');
        return redirect()->route('requisiciones');
    }
    public function render()
    {
        return view('livewire.tickets.compras.compra-reject');
    }
}
