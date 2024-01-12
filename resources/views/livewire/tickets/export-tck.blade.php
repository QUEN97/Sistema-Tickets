<div x-data="{ modelOpen: false, dates:false }">
    <button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="añadir tipo" class=" text-gray-400 border rounded-md p-1.5 w-fit transition duration-300 hover:bg-gray-400 hover:text-white dark:bg-dark-eval-0 dark:border-dark-eval-0 dark:hover:bg-dark-eval-2 dark:hover:border-gray-500">
        <svg width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <path fill="#20744a" fill-rule="evenodd"
                d="M28.781 4.405h-10.13V2.018L2 4.588v22.527l16.651 2.868v-3.538h10.13A1.162 1.162 0 0 0 30 25.349V5.5a1.162 1.162 0 0 0-1.219-1.095Zm.16 21.126H18.617l-.017-1.889h2.487v-2.2h-2.506l-.012-1.3h2.518v-2.2H18.55l-.012-1.3h2.549v-2.2H18.53v-1.3h2.557v-2.2H18.53v-1.3h2.557v-2.2H18.53v-2h10.411Z" />
            <path fill="#20744a"
                d="M22.487 7.439h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323z" />
            <path fill="#fff" fill-rule="evenodd"
                d="m6.347 10.673l2.146-.123l1.349 3.709l1.594-3.862l2.146-.123l-2.606 5.266l2.606 5.279l-2.269-.153l-1.532-4.024l-1.533 3.871l-2.085-.184l2.422-4.663l-2.238-4.993z" />
        </svg>
    </button>
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
                class="inline-block w-full max-w-xl p-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl dark:bg-dark-eval-1"
            >      
                <div class="flex items-center justify-between space-x-4">
                    <h1 class="text-xl font-medium">{{ __('Exportar Tickets') }}</h1>
                </div>
                <div>
                    <div class="flex flex-wrap gap-2 items-center py-2">
                        <div class="text-center m-auto border-b">
                            <x-label value="{{ __('Seleccione un tipo de exportación') }}" for="tipo" />
                            <div class="flex gap-2 justify-center items-stretch py-3">
                                <div id="tipo">
                                    <input type="radio" name="tipo" id="entrada" value="gral" wire:model.defer="tipo" class="peer/entrada hidden">
                                    <label for="entrada" class="h-full flex items-center justify-center gap-1 cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/entrada:bg-amber-600 hover:bg-amber-500 text-white px-4 py-2 rounded-md transition duration-300" @click="dates=false">
                                        General
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" name="tipo" id="salida" value="date" wire:model.defer="tipo" class="peer/salida hidden">
                                    <label for="salida" class="h-full flex items-center justify-center gap-1 cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/salida:bg-amber-600 hover:bg-amber-500 text-white px-4 py-2 rounded-md transition duration-300" @click="dates=true">
                                        Rango de fechas
                                    </label>
                                </div>
                            </div>
                            <x-input-error for="tipo"></x-input-error>
                        </div>
                        <div class="w-full flex flex-wrap justify-center gap-3" x-show="dates" x-cloack x-collapse>
                            <div>
                                <x-label value="{{ __('Fecha de inicio') }}" for="dateIn" />
                                <x-input wire:model.defer="dateIn" type="date" name="dateIn"
                                    id="dateIn" required autofocus autocomplete="dateIn" />
                                <x-input-error for="dateIn"></x-input-error>
                            </div>
                            <div>
                                <x-label value="{{ __('Fecha de termino') }}" for="dateEnd" />
                                <x-input wire:model.defer="dateEnd" type="date" name="dateEnd"
                                    id="dateEnd" required autofocus autocomplete="dateEnd" />
                                <x-input-error for="dateEnd"></x-input-error>
                            </div>
                        </div>
                    </div>
                    <div name="footer" class="d-none text-right mt-2">
                        <x-danger-button class="mr-2" wire:click="generarArchivo()" wire:loading.attr="disabled">
                            Generar
                        </x-danger-button>
            
                        <x-secondary-button @click="modelOpen = false" wire:loading.attr="disabled">
                            Cancelar
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
