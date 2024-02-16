<div>
    <div class="">
        <button wire:click="showTarea({{ $tareaID }})" class="tooltip">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="tooltiptext">Ver Más</span>
        </button>
    </div>

    <x-dialog-modal wire:model="modal" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-dark-eval-3 p-2 rounded-md text-white text-center">
                {{ __('Detalles de la Tarea') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class=" justify-center content-center max-h-[220px] overflow-y-auto">
                <div class="rounded-lg overflow-hidden mb-1">
                    <details>
                        <summary class="bg-gray-100 dark:bg-dark-eval-2 py-2 px-4 cursor-pointer text-center">
                            Info. Ticket #{{ $this->idticket }}
                        </summary>
                        <table class="table-auto w-full">
                            <thead class="bg-gray-50 dark:bg-dark-eval-2">
                                <tr>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                        Vence</th>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                        Cliente</th>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                        Asunto</th>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                        Descripción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr>
                                    <td
                                        class="w-full lg:w-auto p-3   dark:text-white text-center border border-b  block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                        {{ $this->vencetck }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3   dark:text-white text-center border border-b  block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                        {{ $this->solicitatck }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3   dark:text-white text-center border border-b  block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                        {{ $this->asuntotck }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3   dark:text-white text-center border border-b  block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                        {{ $this->mensajetck }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </details>
                </div>
                <hr>
                <div class="rounded-lg overflow-hidden mt-1">
                    <details>
                        <summary class="bg-gray-100 dark:bg-dark-eval-2 py-2 px-4 cursor-pointer text-center">
                            Info. Tarea #{{ $this->tareaID; }}
                        </summary>
                        <table class="table-auto w-full">
                            <thead class="bg-gray-50 dark:bg-dark-eval-2">
                                <tr>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                        Agente</th>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                        Asunto</th>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                        Descripción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr>
                                    <td
                                        class="w-full lg:w-auto p-3   dark:text-white text-center border border-b  block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                        {{ $this->user_asignado }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3   dark:text-white text-center border border-b  block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                        {{ $this->asunto }}
                                    </td>
                                    <td
                                        class="w-full lg:w-auto p-3   dark:text-white text-center border border-b  block lg:table-cell relative lg:static">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                        {{ $this->mensaje }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </details>
                </div>
            </div>
            <div class="dark:bg-dark-eval-0 p-2 rounded-md mt-2">
                @livewire('tickets.tareas.comentarios-tarea', ['tareaID' => $tareaID], key('comentarios'.$tareaID))
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
