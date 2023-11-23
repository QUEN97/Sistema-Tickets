<?php

namespace App\Http\Livewire\Productos\Almacen;

use App\Models\AlmacenCi;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditAlmacen extends Component
{
    public $idAlma,$stock,$base,$name;
    public function mount(){
        $p=AlmacenCi::find($this->idAlma);
        $this->stock=$p->stock;
        $this->base=$p->stock_base;
        $this->name=$p->producto->name;
    }
    public function updateAlmacen(AlmacenCi $reg){
        $this->validate([
            'stock'=>['required','gt:0'],
            'base'=>['required','gt:0'],
        ],[
            'stock.required'=>'Ingrese el stock actual del producto',
            'stock.gt'=>'El stock actual debe ser mayor a cero',
            'base.required'=>'Ingrese el stock base del producto',
            'base.gt'=>'El stock base debe ser mayor a cero'
        ]);
        $reg->stock=$this->stock;
        $reg->stock_base=$this->base;
        $reg->save();

        session()->flash('flash.banner', 'la información  del producto ha sido actualizada');
        session()->flash('flash.bannerStyle', 'success');

        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.productos.almacen.edit-almacen');
    }
}
