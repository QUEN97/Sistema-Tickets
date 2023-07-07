<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\Compra;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class AcepCompra extends Component
{
    public $compraID,$status;
    //aprobar requisición
    public function aprobar(Compra $compra){
        $compra->status='Aprobado';
        $compra->save();
        Alert::success('Aprobado','La requisición ha sido aprobada');
        return redirect()->route('requisiciones');
    }
    //enviar a compras
    public function enviar(Compra $compra){
        $compra->status='Enviado a compras';
        $compra->save();
        Alert::success('Enviado','La requisición ha sido enviada al departamento de compras');
        return redirect()->route('requisiciones');
    }
    //finalizar compra
    public function finish(Compra $compra){
        $compra->status='Completado';
        $compra->save();
        Alert::success('Enviado','La requisición ha sido enviada al departamento de compras');
        return redirect()->route('requisiciones');
    }
    public function render()
    {
        return view('livewire.tickets.compras.acep-compra');
    }
}
