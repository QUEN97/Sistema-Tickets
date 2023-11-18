<div>
    <button wire:click="ConfirmVisita({{$visitaID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
          </svg>
                 
          <span class="tooltiptext">Finalizar</span>
    </button>
    <x-dialog-modal wire:model="modal" class="flex items-center">
        <x-slot name="title">
        </x-slot>
        <x-slot name="content" class="relative">
            <div>
                <div class="flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                      </svg>
                </div>
                <p>Estas por finalizar la visita para la estación <i>"{{$visitaEstacion}}"</i>, 
                   <strong>Por favor</strong> comentanos si el motivo de la visita fue debidamente resuelto o ha quedado
                   algún detalle por resolver.
                </p>
                <div>
                    <x-label value="{{ __('Observación') }}" />
                    <textarea wire:model="observacion" class="rounded-md w-full " name="observacion" required autofocus></textarea>
                    <x-input-error for="observacion"></x-input-error>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer" >
            <div class="w-full flex justify-center gap-3">
                <x-danger-button class="mr-2" wire:click="FinalVisita({{$visitaID}})" wire:loading.attr="disabled">
                    Aceptar
                </x-danger-button>
                <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                    Cancelar
                </x-secondary-button>
            </div>
           
        </x-slot>
    </x-dialog-modal>
</div>