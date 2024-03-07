<?php

namespace App\Http\Livewire\Visitas;

use App\Models\Estacion;
use App\Models\Falla;
use App\Models\User;
use App\Models\UserZona;
use App\Models\Visita;
use App\Notifications\NotifiNewVisita;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class NewVisita extends Component
{
    public $usuario, $motivo, $fecha, $estacion;
    public $users, $estacions, $estas, $superEsta, $fallas, $fallasList;

    public $modal = false;

    public function mount()
    {
        // $this->users = User::where('status','Activo')->whereNotIn('permiso_id',[3,6])->get();
        $this->estacions = Estacion::where('status', 'Activo')->orderBy('name')->get();
        $this->superEsta = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->get();
        $this->fallas = Falla::where('status', 'Activo')->where('servicio_id', 23)->get();
    }

    public function programarVisita()
    {
        if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $agente = User::where('permiso_id', 5)->pluck('id');
            $Agents = User::where('status', 'Activo')->whereHas('tickets', function ($query) use ($agente) {
                $query->whereNotIn('status', ['Por abrir', 'Cerrado'])
                    ->whereIn('user_id', $agente);
            })->get();
            $this->validate(
                [
                    'estacion' => ['required'],
                    'motivo' => ['required'],
                    'fecha' => ['required', 'not_in:0'],
                ],
                [
                    'estacion.required' => 'El campo Estación es obligatorio',
                    'motivo.required' => 'El campo Motivo es obligatorio',
                    'fecha.required' => 'El campo Fecha es obligatorio',
                ]
            );

            $visita = (Visita::create([
                'estacion_id' => $this->estacion,
                'solicita_id' => Auth::user()->id,
                'motivo_visita' =>  $this->motivo,
                'fecha_programada' => $this->fecha,
            ]));
            $visita->fallas()->sync($this->fallasList);

            Notification::send($Agents, new NotifiNewVisita($visita));
        } elseif (Auth::user()->permiso_id == 3) {
            $agente = User::where('permiso_id', 5)->pluck('id');
            $Agents = User::where('status', 'Activo')->whereHas('tickets', function ($query) use ($agente) {
                $query->whereNotIn('status', ['Por abrir', 'Cerrado'])
                    ->whereIn('user_id', $agente);
            })->get();
            $this->estas = Estacion::where('user_id', auth()->user()->id)->first()->id; //Obtenemos el ID de la estacion perteneciente al usuario "Gerente"
            //dd($this->estas);
            $this->validate(
                [
                    'motivo' => ['required'],
                    'fecha' => ['required', 'not_in:0'],
                ],
                [
                    'motivo.required' => 'El campo Motivo es obligatorio',
                    'fecha.required' => 'El campo Fecha es obligatorio',
                ]
            );

            $visita = (Visita::create([
                'estacion_id' => $this->estas,
                'solicita_id' => Auth::user()->id,
                'motivo_visita' =>  $this->motivo,
                'fecha_programada' => $this->fecha,
            ]));
            $visita->fallas()->sync($this->fallasList);

            Notification::send($Agents, new NotifiNewVisita($visita));
        } elseif (Auth::user()->permiso_id == 2) {
            $agente = User::where('permiso_id', 5)->pluck('id');
            $Agents = User::where('status', 'Activo')->whereHas('tickets', function ($query) use ($agente) {
                $query->whereNotIn('status', ['Por abrir', 'Cerrado'])
                    ->whereIn('user_id', $agente);
            })->get();
            $this->validate(
                [
                    'estacion' => ['required'],
                    'motivo' => ['required'],
                    'fecha' => ['required', 'not_in:0'],
                ],
                [
                    'estacion.required' => 'El campo Estación es obligatorio',
                    'motivo.required' => 'El campo Motivo es obligatorio',
                    'fecha.required' => 'El campo Fecha es obligatorio',
                ]
            );

            $visita = (Visita::create([
                'estacion_id' => $this->estacion,
                'solicita_id' => Auth::user()->id,
                'motivo_visita' =>  $this->motivo,
                'fecha_programada' => $this->fecha,
            ]));
            $visita->fallas()->sync($this->fallasList);
            Notification::send($Agents, new NotifiNewVisita($visita));
        }


        session()->flash('flash.banner', 'Nueva Visita, la visita  ha sido registrada en el sistema.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.visita');
    }

    public function render()
    {
        return view('livewire.visitas.new-visita');
    }
}
