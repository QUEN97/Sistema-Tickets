<div>
    <button wire:click="editTarea({{ $tareaID }})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-black">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>
    <x-dialog-modal wire:model="modal" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 p-4 rounded-md text-white text-center">
                {{ __('Editar Tarea') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="max-h-[200px] overflow-auto">
                <div class="flex flex-wrap gap-3 justify-evenly items-center ">
                    <div class="mb-4">
                        <x-label value="{{ __('Agente') }}" for="user_asignado" />
                        <select wire:model="user_asignado" id="user_asignado"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"">
                            <option value="">Seleccionar agente</option>
                            @foreach ($agentes as $agente)
                                <option value="{{ $agente->id }}">{{ $agente->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="user_asignado"></x-input-error>
                    </div>

                    <div class="mb-4">
                        <x-label value="{{ __('Asunto') }}" for="asunto" />
                        <input type="text" wire:model="asunto" id="asunto"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                        <x-input-error for="asunto"></x-input-error>
                    </div>
                    <div class="mb-4">
                        <x-label value="{{ __('Descripción') }}" for="mensaje" />
                        <textarea wire:model="mensaje" id="mensaje"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 resize-none"></textarea>
                        <x-input-error for="mensaje"></x-input-error>
                    </div>
                    <div class="mb-4">
                        <x-label value="{{ __('Status') }}" />
                        <select id="status" wire:model="status"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('status') ? 'is-invalid' : '' }}"
                            name="status" aria-required="true">
                            <option hidden value="">Seleccionar Status</option>
                            <option value="Abierto" @if ($status == 'Abierto') {{ 'selected' }} @endif>
                                Abierto</option>
                            <option value="En Proceso" @if ($status == 'En Proceso') {{ 'selected' }} @endif>
                                En Proceso</option>
                            <option value="Cerrado" @if ($status == 'Cerrado') {{ 'selected' }} @endif>
                                Cerrado</option>
                        </select>
                        <x-input-error for="status"></x-input-error>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button class="mr-2" wire:click="updateTarea({{ $tareaID }})" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
