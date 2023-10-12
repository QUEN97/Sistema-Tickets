<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button wire:click="$set('modal',true)" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            <i class="fa-solid fa-plus"></i>
            {{ __('Asignar correo') }}
            </x-jet-button>
    </div>

    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            {{ __('Nueva asignación') }}
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap gap-3 justify-evenly items-center py-2">
                <div>
                    <x-label value="{{ __('Categoria de compra') }}" for="tipo"/>
                    <select wire:model.defer="categoria" name="tipo" id="tipo"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar categoria</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="clase"></x-input-error>
                </div>
                <div class="w-full">
                    <x-label value="{{ __('Correo') }}" for="correo"/>
                    <select wire:model.defer="correos" name="correo[]" id="correo" multiple="multiple" style="width: 100%"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        @foreach ($emails as $email)
                            <option value="{{$email->id}}">{{$email->correo}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="correos"></x-input-error>
                </div>
                <div class="w-full">
                    <x-label value="{{ __('Zonas') }}" for="zonas"/>
                    <select wire:model.defer="zonasAsignadas" name="zonas[]" id="zonas" multiple="multiple" style="width: 100%"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        @foreach ($zonas as $zonas)
                            <option value="{{$zonas->id}}">{{$zonas->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="zonasAsignadas"></x-input-error>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addCorreo" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    @push('scripts')
        <script>
            document.addEventListener('livewire:load',()=>{
                Livewire.hook('message.processed',(message,component)=>{
                    $('#correo').select2({
                        placeholder: "Seleccionar correo(s)...",
                        allowClear: true,
                    }).on('change', function() {
                        @this.set('correos', $(this).val());
                    });
                    
                    $('#zonas').select2({
                        placeholder: "Seleccionar zonas(s)...",
                        allowClear: true
                    }).on('change', function() {
                        @this.set('zonasAsignadas', $(this).val());
                    });
                });
            });
            
        </script>
    @endpush
</div>