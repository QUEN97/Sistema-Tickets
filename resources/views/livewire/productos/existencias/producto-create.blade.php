<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button wire:click="$set('modal',true)" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            <i class="fa-solid fa-plus"></i>
            {{ __('Añadir Producto') }}
            </x-jet-button>
    </div>

    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 p-2 rounded-md text-white text-center">
                {{ __('Nuevo Producto') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div>
                <div>
                    <div class="col-12 p-0">
                        <x-label value="{{ __('Categoría') }}" />
                        <select id="unidad" wire:model="categoria"
                                class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('unidad') ? 'is-invalid' : '' }}" 
                                name="unidad" required aria-required="true">
                                <option hidden value="" selected>{{ __('Seleccionar Categoría') }}</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{$categoria->id}}">{{$categoria->name}}</option>
                                @endforeach
                        </select>
                        <x-input-error for="categoria"></x-input-error>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <div>
                            <x-label value="{{ __('Nombre') }}" for="name" />
                            <x-input wire:model="name" type="text" name="name"
                                id="name" required autofocus autocomplete="name" />
                            <x-input-error for="name"></x-input-error>
                        </div>
                        <div class="col-12 p-0">
                            <x-label value="{{ __('Marca') }}" />
                            <select id="unidad" wire:model="marca"
                                    class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('unidad') ? 'is-invalid' : '' }}" 
                                    name="unidad" required aria-required="true">
                                    <option hidden value="" selected>{{ __('Seleccionar marca') }}</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{$marca->id}}">{{$marca->name}}</option>
                                    @endforeach
                            </select>
                            <x-input-error for="marca"></x-input-error>
                        </div>
                    </div>
                    
                    <div>
                        <x-label value="{{ __('Descripción') }}" />
                        <textarea wire:model="descripcion" class="form-control w-full resize-none rounded-md dark:bg-slate-800" name="descripcion"
                            required autofocus autocomplete="descripcion"></textarea>
                        <x-input-error for="descripcion"></x-input-error>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <div class="col-12 p-0">
                        <x-label value="{{ __('Unidad de medida') }}" />

                        <select id="unidad" wire:model="unidad"
                                class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('unidad') ? 'is-invalid' : '' }}" 
                                name="unidad" required aria-required="true">
                                <option hidden value="" selected>{{ __('Seleccionar Unidad') }}</option>
                                <option value="CENTIMETRO">{{ __('CENTIMETRO') }}</option>
                                <option value="METRO">{{ __('METRO') }}</option>
                                <option value="PAQUETE">{{ __('PAQUETE') }}</option>
                                <option value="PIEZA">{{ __('PIEZA') }}</option>
                                <option value="SERVICIOS">{{ __('SERVICIOS') }}</option>
                        </select>
                        <x-input-error for="unidad"></x-input-error>
                    </div>
                    <div>
                        <x-label value="{{ __('Modelo') }}" for="modelo" />
                        <x-input wire:model="modelo" type="text" name="modelo"
                            id="modelo" required autofocus autocomplete="modelo" />
                        <x-input-error for="modelo"></x-input-error>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-12 w-full flex flex-col gap-2"
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                    <x-label value="{{ __('Imagen') }}" class="border-b border-gray-400 w-full text-left mb-2"/>
                    <input type="file" wire:model="imagen" class="flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                    name="imagen" required autocomplete="imagen" accept="image/*">
                    <x-input-error for="imagen"></x-input-error>

                    <!-- Progress Bar -->
                    <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                        <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"  x-bind:style="`width:${progress}%`"></div>
                    </div>
            </div>
            
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addProducto" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>