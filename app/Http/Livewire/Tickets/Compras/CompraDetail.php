<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\Compra;
use Livewire\Component;

class CompraDetail extends Component
{
    public $compraID,$compra,$modal=false;
    public function showCompra(Compra $compra){
        $this->compra = $compra;
        $this->modal=true;
    }
    public function render()
    {
        return view('livewire.tickets.compras.compra-detail');
    }
}
