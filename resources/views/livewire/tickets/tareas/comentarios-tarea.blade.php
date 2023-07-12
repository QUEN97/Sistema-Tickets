<div>
    <div class="flex flex-wrap gap-3 justify-evenly items-center">
        <div>
            <x-label value="{{ __('Status de la tarea') }}" for="status" />
            <select wire:model="status" name="status" id="status"
                class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                <option hidden value="" selected>Seleccionar status</option>
                <option value="En Proceso">En Proceso</option>
                <option value="Cerrado">Cerrado</option>
            </select>
            <x-input-error for="status"></x-input-error>
        </div>
    </div>
    <div class="w-full">
        <x-label value="{{ __('Mensaje') }}" for="mensaje" />
        <textarea wire:model="mensaje"
            class="resize-none w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('mensaje') ? 'is-invalid' : '' }} resize-none"
            name="mensaje" required autofocus autocomplete="mensaje">
                </textarea>
        <x-input-error for="mensaje"></x-input-error>
    </div>

    {{-- comentarios de la tarea --}}
    @if ($comentarios->count() > 0)
        <div class="max-h-[200px] overflow-auto mt-4">
            <x-label value="{{ __('Comentarios registrados') }}"
                class="border-b border-gray-400 w-full text-left mb-2" />
            <div class="flex flex-col gap-3 py-2">
                @foreach ($comentarios as $comentario)
                    <div class="relative">
                        <div class="relative border px-2 py-3 dark:border-gray-700">
                            <div>
                                <div class="flex gap-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                                        fill="currentColor">
                                        <path
                                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                    </svg>
                                    {{ $comentario->usuario->name }}
                                </div>
                                <div class="italic text-sm">
                                    "{{ $comentario->comentario }}"
                                </div>
                            </div>
                            <div class="absolute right-1 bottom-0.5">{{ $comentario->created_at }}</div>
                        </div>

                        <button type="button" class="absolute top-2 right-2"
                            wire:click="removeCom({{ $comentario->id }})" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Doble click para Eliminar">
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" data-bs-content="Doble click para Eliminar"
                                data-bs-placement="top">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor"
                                    class="bi bi-trash3-fill w-5 h-5 text-gray-400 hover:text-orange-800 transition duration-300"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <x-danger-button class="mr-2" wire:click="addCom({{ $tareaID }})" wire:loading.attr="disabled">
        Aceptar
    </x-danger-button>
</div>
