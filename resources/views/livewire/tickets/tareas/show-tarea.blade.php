<div>
    <div class="">
        <button wire:click="showTarea({{ $tareaID }})" class="tooltip">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
             <span class="tooltiptext">Ver Más</span>
        </button>
    </div>

    <x-dialog-modal wire:model="modal"  class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-dark-eval-3 p-4 rounded-md text-white text-center">
                {{ __('Detalles de la Tarea') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="flex gap-2 justify-center content-center">
                <div class="bg-gray-300 dark:bg-dark-eval-0 p-2 rounded-md max-h-[100px] overflow-y-auto" style="max-width: 300px;">
                    <ul class="list-style:none">
                        <li><div>Ticket # {{ $this->idticket }}</div></li>
                        <li> <div>{{ $this->vencetck }}</div></li>
                        <li> <div> Cliente : {{ $this->solicitatck }}</div></li>
                        <li><div> Asunto : {{ $this->asuntotck }}</div></li>
                        <li><div> Descripción : {{ $this->mensajetck }}</div></li>
                    </ul>
                </div>
                <div class="bg-gray-300 dark:bg-dark-eval-0 p-2 rounded-md max-h-[100px] overflow-y-auto" style="max-width: 300px;">
                    <ul class="list-style:none">
                        <li><div>Tarea # {{ $this->tareaID }}</div></li>
                        <li> <div>{{ $this->vencetck }}</div></li>
                        <li> <div> Agente : {{ $this->user_asignado }}</div></li>
                        <li><div> Asunto : {{ $this->asunto }}</div></li>
                        <li><div> Descripción : {{ $this->mensaje }}</div></li>
                    </ul>
                </div>
            </div>
            <div class="bg-gray-300 dark:bg-dark-eval-0 p-2 rounded-md mt-2">
                Comentarios:
                  @livewire('tickets.tareas.comentarios-tarea',['tareaID'=>$tareaID])  
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
