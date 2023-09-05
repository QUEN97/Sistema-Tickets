<?php

namespace App\Http\Livewire\Usuarios\Guardias;

use App\Models\Guardia;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class EditOrden extends Component
{
    public $guardias, $backupData, $arrSave = [], $edit = false;
    public function mount()
    {
        $this->guardias = Guardia::select('id', 'user_id', 'status', 'orden')->orderBy('orden', 'ASC')->get();
        //guardamos los datos en caso que el usuario decida no guardar los cambios
        $this->backupData = $this->guardias;
        $this->respaldar();
    }
    //respaldamos la información en un array 
    //(esto sirve para el SELECT en caso que se haya editado el status de algún registro)
    public function respaldar()
    {
        foreach ($this->guardias as $key => $user) {
            $this->arrSave[$key] = ['user' => $user->user_id, 'status' => $user->status];
        }
    }
    /* public function updatedArrSave($val){
        foreach($this->arrSave as $respaldo){
            foreach ($this->guardias as $user){
                if($respaldo['user']==$user->user_id && $respaldo['status']!=$user->status){
                    $dato=Guardia::find($user->id);
                    $dato->status=$respaldo['status'];
                    $dato->save();
                    exit;
                }
            }
        }
    } */
    public function change()
    {
        foreach ($this->arrSave as $respaldo) {
            foreach ($this->guardias as $user) {
                if ($respaldo['user'] == $user->user_id && $respaldo['status'] != $user->status) {
                    $dato = Guardia::find($user->id);
                    $dato->status = $respaldo['status'];
                    $dato->save();
                }
            }
        }
        $this->respaldar();
    }
    public function updateList($list)
    {
        //dd($list,$this->guardias);
        $ordenado = new Collection();
        foreach ($list as $item) {
            foreach ($this->guardias as $user) {
                if ($item['value'] == $user->user_id) {
                    $dato = Guardia::find($user->id);
                    $dato->orden = $item['order'];
                    $dato->save();
                }
            }
        }
        $this->respaldar();
        //dd($ordenado,$this->guardias);
    }
    public function update()
    {
        dd($this->guardias);
    }
    public function render()
    {
        $this->guardias = Guardia::select('id', 'user_id', 'status', 'orden')->orderBy('orden', 'ASC')->get();
        $this->respaldar();
        return view('livewire.usuarios.guardias.edit-orden');
    }
}
