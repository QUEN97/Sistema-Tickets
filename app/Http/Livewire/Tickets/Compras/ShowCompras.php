<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\Compra;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ShowCompras extends Component
{
    public $ticketID,$compras,$modal=false;
    public function mount(){
        $this->compras=Compra::where('ticket_id',$this->ticketID)->orderBy('id', 'desc')->get();
    }
    public function deleteCompra(Compra $compra){
        //dd($compra->evidencias);
        Storage::disk('public')->delete($compra->documento);
        foreach($compra->evidencias as $ev){
            Storage::disk('public')->delete($ev->product_photo_path);
        }
        $compra->delete();
        Alert::warning('Eliminado','La requisición ha sido eliminada permanentemente');
        return redirect()->route('tickets');
    }
    public function render()
    {
        return view('livewire.tickets.compras.show-compras');
    }
}
