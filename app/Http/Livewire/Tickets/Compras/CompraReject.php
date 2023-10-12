<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\Compra;
use App\Models\ComentariosCompra;
use App\Notifications\RechazoCompraNotification;
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
        
        $agent = $compra->ticket->agente;
        //dd($agent);
        $agent->notify(new RechazoCompraNotification($compra));
        // Alert::warning('Compra rechazada','El status de la compra ha sido actualizada');
        session()->flash('flash.banner', 'La requisición ha sido rechazada');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('requisiciones');
    }
    public function render()
    {
        return view('livewire.tickets.compras.compra-reject');
    }
}
