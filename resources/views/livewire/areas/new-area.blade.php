
<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button wire:click="$set('modal',true)" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            <i class="fa-solid fa-plus"></i>
            {{ __('Añadir Área') }}
            </x-jet-button>
    </div>

    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            {{ __('Nueva área') }}
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap gap-3 justify-evenly items-center">
                <div>
                    <x-label value="{{ __('Nombre del área') }}" for="area" />
                    <x-input wire:model="area" type="text" name="area"
                        id="area" required autofocus autocomplete="area" />
                    <x-input-error for="area"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Departamento') }}" for="banco"/>
                    <select wire:model="depto" name="depto" id="depto"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar Despartamento</option>
                        @foreach ($departamentos as $dep)
                            <option value="{{$dep->id}}">{{$dep->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="depto"></x-input-error>
                </div>
            </div>
            
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addArea" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>