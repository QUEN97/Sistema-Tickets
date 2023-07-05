<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button wire:click="$set('modal',true)" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            <i class="fa-solid fa-plus"></i>
            {{ __('Añadir falla') }}
            </x-jet-button>
    </div>

    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            {{ __('Nueva falla') }}
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap gap-3 justify-evenly items-center">
                <div>
                    <x-label value="{{ __('Nombre de la falla') }}" for="name" />
                    <x-input wire:model="name" type="text" name="name"
                        id="name" required autofocus autocomplete="name" />
                    <x-input-error for="name"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Servicio requerido') }}" for="serviio"/>
                    <select wire:model="servicio" name="servicio" id="servicio"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar servicio</option>
                        @foreach ($servicios as $servicio)
                            <option value="{{$servicio->id}}">{{$servicio->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="servicio"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Prioridad') }}" for="prioridad"/>
                    <select wire:model="prioridad" name="prioridad" id="prioridad"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar Prioridad</option>
                        @foreach ($tipos as $tipo)
                            @if ($tipo->prioridad->count() > 0)
                                <optgroup label="{{$tipo->name}}">
                                    @foreach ($tipo->prioridad as $prioridad)
                                        <option value="{{$prioridad->id}}">
                                            {{$prioridad->name}} - {{$prioridad->tiempo}}
                                            {{$prioridad->riempo >1 ? 'hrs' : 'hr' }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error for="prioridad"></x-input-error>
                </div> 
            </div>
            
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addFalla" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>