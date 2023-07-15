<div>
    <div class="">
        <button wire:click="showTarea({{ $tareaID }})" class="tooltip">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-black">
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
                <div class=" bg-white shadow-lg dark:bg-dark-eval-0 p-2 rounded-md max-h-[100px] overflow-y-auto" style="min-width: 300px; max-width: 300px;">
                    <ul class="list-style:none">
                        <li class="text-black dark:text-white"><div class="bg-gray-400 p-1 rounded-md text-white text-bold">Ticket </div> #{{ $this->idticket }}</li>
                        <li class="text-black dark:text-white"> <div class="bg-gray-400 p-1 rounded-md text-white text-bold">Vence: </div> {{ $this->vencetck }}</li>
                        <li class="text-black dark:text-white"> <div class="bg-gray-400 p-1 rounded-md text-white text-bold"> Cliente : </div> {{ $this->solicitatck }}</li>
                        <li class="text-black dark:text-white"><div class="bg-gray-400 p-1 rounded-md text-white text-bold"> Asunto : </div>  {{ $this->asuntotck }}</li>
                        <li class="text-black dark:text-white"><div class="bg-gray-400 p-1 rounded-md text-white text-bold"> Descripción : </div> {{ $this->mensajetck }}</li>
                    </ul>
                </div>
                <div class="bg-white shadow-lg dark:bg-dark-eval-0 p-2 rounded-md max-h-[100px] overflow-y-auto" style="min-width: 300px; max-width: 300px;">
                    <ul class="list-style:none">
                        <li class="text-black dark:text-white"><div class="bg-gray-400 p-1 rounded-md text-white text-bold">Tarea </div>  # {{ $this->tareaID }}</li>
                        <li class="text-black dark:text-white"> <div class="bg-gray-400 p-1 rounded-md text-white text-bold"> Agente : </div> {{ $this->user_asignado }}</li>
                        <li class="text-black dark:text-white"><div class="bg-gray-400 p-1 rounded-md text-white text-bold"> Asunto : </div> {{ $this->asunto }}</li>
                        <li class="text-black dark:text-white"><div class="bg-gray-400 p-1 rounded-md text-white text-bold"> Descripción : </div> {{ $this->mensaje }}</li>
                    </ul>
                </div>
            </div>
            <div class="dark:bg-dark-eval-0 p-2 rounded-md mt-2">
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
