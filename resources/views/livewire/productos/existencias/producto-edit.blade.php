<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <button wire:click="editProducto({{ $productoID }})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>

    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 p-2 rounded-md text-white text-center">
                {{ __('Editar Producto') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div>
                <div>
                    <div class="col-12 p-0">
                        <x-label value="{{ __('Categoría') }}" />
                        <select id="categoria" wire:model="categoria"
                            class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('categoria') ? 'is-invalid' : '' }}"
                            name="categoria" required aria-required="true">
                            <option hidden value="" selected>{{ __('Seleccionar categoría') }}</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="categoria"></x-input-error>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <div>
                            <x-label value="{{ __('Nombre') }}" for="name" />
                            <x-input wire:model="name" type="text" name="name" id="name" required autofocus
                                autocomplete="name" />
                            <x-input-error for="name"></x-input-error>
                        </div>
                        <div class="col-12 p-0">
                            <x-label value="{{ __('Marca') }}" />
                            <select id="marca" wire:model="marca"
                                class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('marca') ? 'is-invalid' : '' }}"
                                name="marca" required aria-required="true">
                                <option hidden value="" selected>{{ __('Seleccionar marca') }}</option>
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="marca"></x-input-error>
                        </div>
                    </div>

                    <div>
                        <x-label value="{{ __('Descripción') }}" />
                        <textarea wire:model="descripcion" class="form-control  w-full resize-none rounded-md dark:bg-slate-800"
                            name="descripcion" required autofocus autocomplete="descripcion"></textarea>

                        <x-input-error for="descripcion"></x-input-error>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <div class="col-12 p-0">
                        <x-label value="{{ __('Unidad de medida') }}" />

                        <select id="unidad" wire:model="unidad"
                            class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('unidad') ? 'is-invalid' : '' }}"
                            name="unidad" required aria-required="true">
                            <option hidden value="">{{ __('Seleccionar Unidad') }}</option>
                            <option value="Centimetro" @if ($unidad == 'Centimetro') {{ 'selected' }} @endif>
                                Centimetro</option>
                            <option value="Metro" @if ($unidad == 'Metro') {{ 'selected' }} @endif>
                                Metro</option>
                            <option value="Paquete" @if ($unidad == 'Paquete') {{ 'selected' }} @endif>
                                Paquete</option>
                            <option value="Pieza" @if ($unidad == 'Pieza') {{ 'selected' }} @endif>
                                Pieza</option>
                            <option value="Servicios" @if ($unidad == 'Servicios') {{ 'selected' }} @endif>
                                Servicios</option>
                        </select>
                        <x-input-error for="unidad"></x-input-error>
                    </div>
                    <div>
                        <x-label value="{{ __('Modelo') }}" for="modelo" />
                        <x-input wire:model="modelo" type="text" name="modelo" id="modelo" required autofocus
                            autocomplete="modelo" />
                        <x-input-error for="modelo"></x-input-error>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-12 w-full flex flex-col gap-2" x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">

                <x-label value="{{ __('Imagen') }}" class="border-b border-gray-400 w-full text-left mb-2" />
                <input type="file" wire:model="imagen"
                    class="flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                    name="imagen" required autocomplete="imagen" accept="image/*">
                <x-input-error for="imagen"></x-input-error>

                <!-- Progress Bar -->
                <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                    <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"
                        x-bind:style="`width:${progress}%`"></div>
                </div>
            </div>

        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="updateProducto({{ $productoID }})"
                wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
