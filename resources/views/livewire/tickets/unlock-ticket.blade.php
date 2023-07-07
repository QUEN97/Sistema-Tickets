<div>
    <button wire:click="$set('modal',true)" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock-open h-6 w-6 text-gray-400 hover:text-indigo-500 transition duration-300" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
            <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
            <path d="M8 11v-5a4 4 0 0 1 8 0"></path>
         </svg>         
        <span class="tooltiptext">Abrir ticket</span>
    </button>
    <x-dialog-modal wire:model="modal" class="flex items-center">
        <x-slot name="title">
        </x-slot>
        <x-slot name="content" class="relative">
            <div>
                <div class="flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-20 h-20 text-yellow-500 bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </div>
                <span>¿Está seguro que quiere abrir el ticket #<i>{{$ticketID}}</i> ?</span>
            </div>
        </x-slot>
        <x-slot name="footer" >
            <div class="w-full flex justify-center gap-3">
                <x-danger-button class="mr-2" wire:click="unlockTicket({{$ticketID}})" wire:loading.attr="disabled">
                    Aceptar
                </x-danger-button>
                <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                    Cancelar
                </x-secondary-button>
            </div>
           
        </x-slot>
    </x-dialog-modal>
</div>
