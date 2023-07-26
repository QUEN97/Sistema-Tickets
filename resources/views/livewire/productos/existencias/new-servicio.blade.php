<div x-data="{ modelOpen: false }">
    <div class="">
        <x-button  @click="modelOpen =!modelOpen" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            <i class="fa-solid fa-plus"></i>
            {{ __('Añadir servicio') }}
            </x-button>
    </div>
    {{-- <button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="reasignar-usuario" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-edit w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
            <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
            <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z"></path>
         </svg>
        <span class="tooltiptext">Reasignar</span>
    </button> --}}

    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:p-0">
            <div x-cloak @click="modelOpen = false" x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-700/75 bg-opacity-75" aria-hidden="true"
            ></div>
            <div x-cloak x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-xl p-6 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl dark:bg-dark-eval-1"
            >
            
                <div class="flex items-center justify-between space-x-4">
                    <h1 class="text-xl font-medium">Nuevo servicio</h1>
                </div>
                <div class="flex flex-col justify-center gap-2 py-3">
                    <div>
                        <x-label value="{{ __('Nombre del servicio') }}" for="name" />
                        <x-input wire:model="name" type="text" name="name"
                            id="name" required autofocus autocomplete="name" class="w-full"/>
                        <x-input-error for="name"></x-input-error>
                    </div>
                    <div>
                        <x-label value="{{ __('Descripción') }}" />
                        <textarea wire:model="descripcion" class="form-control h-52 w-full resize-none rounded-md dark:bg-slate-800" name="descripcion"
                            required autofocus autocomplete="descripcion" cols="30" rows="8"></textarea>
                        <x-input-error for="descripcion"></x-input-error>
                    </div>
                </div>
                <div name="footer" class="d-none text-right mt-1">
                    <x-danger-button class="mr-2" wire:click="addServicio" wire:loading.attr="disabled">
                        Aceptar
                    </x-danger-button>
        
                    <x-secondary-button @click="modelOpen = false" wire:loading.attr="disabled">
                        Cancelar
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>