<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\Compra;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CompraDelete extends Component
{
    public $compraID,$modal=false;
    public function deleteCompra(Compra $compra){
        Storage::disk('public')->delete($compra->documento);
        foreach($compra->evidencias as $evidencia)
        {
            Storage::disk('public')->delete($evidencia->archivo_path);
        }
        $compra->delete();
    }
    public function render()
    {
        return view('livewire.tickets.compras.compra-delete');
    }
}
