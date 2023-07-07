<div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div>
        <ol class="flex items-center w-full mb-4 sm:mb-5">
            <li class="flex w-full items-center text-white">
                <div class="flex items-center justify-center w-10 h-10 bg-sky-700 rounded-full lg:h-12 lg:w-12  shrink-0">
                    1
                </div>
                <div class="w-full bg-gray-300 dark:bg-gray-700">
                    <div style="width: {{$w}}%" class="h-1 border-b border-sky-700 border-4 transition-[width] duration-500"></div>
                </div>
            </li>
            <li class="flex items-center ">
                <div @if ($step == 1)
                class="flex items-center justify-center w-10 h-10 bg-gray-300 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0"
                @else
                class="flex items-center justify-center w-10 h-10 bg-sky-700 rounded-full lg:h-12 lg:w-12  shrink-0 text-white"
                @endif>
                    2
                </div>
            </li>
        </ol>
    </div>
    @if ($step == 1)
        <div>
            <div>
                <x-label value="{{ __('Titulo del correo') }}" for="titulo" />
                <x-input wire:model="titulo" type="text" name="titulo"
                    id="titulo" required autofocus autocomplete="titulo" class="w-full"/>
                <x-input-error for="titulo"></x-input-error>
            </div>
            <div>
                <x-label value="{{ __('Problema detectado') }}" />
                <textarea wire:model="problema" class="form-control h-40 w-full resize-none rounded-md dark:bg-slate-800" name="problema"
                    required autofocus autocomplete="problema" cols="30" rows="8"></textarea>
                <x-input-error for="problema"></x-input-error>
            </div>
            <div>
                <x-label value="{{ __('Solución') }}" />
                <textarea wire:model="solucion" class="form-control h-28 w-full resize-none rounded-md dark:bg-slate-800" name="solucion"
                    required autofocus autocomplete="solucion" cols="30" rows="8"></textarea>
                <x-input-error for="solucion"></x-input-error>
            </div>
            <div class="mb-1 col-12 w-full"
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                <x-label value="{{ __('Evidencias') }}" class="border-b border-gray-400 w-full text-left mb-2"/>
                <input type="file" wire:model="evidencias" class=" pb-2 flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                multiple name="evidencias" required autocomplete="evidencias" accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                <x-input-error for="evidencias"></x-input-error>

                <!-- Progress Bar -->
                <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-2 dark:bg-gray-700">
                    <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"  x-bind:style="`width:${progress}%`"></div>
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col gap-2">
            <div class="flex flex-wrap gap-2 items-end">
                <div>
                    <x-label value="{{ __('Categoría') }}" />
                    <select id="categoria" wire:model="categoria"
                            class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('categoria') ? 'is-invalid' : '' }}" 
                            name="categoria" required aria-required="true">
                        <option hidden value="" selected>{{ __('Seleccionar categoría') }}</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{$categoria->id}}">{{$categoria->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="categoria"></x-input-error>
                </div>
                @if ($productos)
                    <div>
                        <x-input wire:model="search" type="search" name="search"
                            id="search" placeholder="Buscar..." required autofocus autocomplete="search" class="w-full"/>
                    </div>
                @endif
            </div>
            <x-input-error for="carrito"></x-input-error>
            <div>
                @if ($productos)
                    <div class="py-1 border-b-2 mb-2">
                        <h2>Seleccione sus productos</h2>
                    </div>
                    <div class="flex flex-wrap gap-2 justify-center max-h-80 overflow-auto">
                        @foreach ($productos as $key => $pr)
                            <div class="flex flex-row items-center gap-0.5 relative">
                                <input type="checkbox" wire:model="carrito.{{$key}}.id" value="{{$pr->id }}" name="carrito[]" id="{{$pr->name}}" class="peer absolute top-2 right-2">
                                <label for="{{$pr->name}}" class="break-all text-start w-full border-2 py-1 px-2 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600">
                                    <div class="flex justify-center items-center">
                                        <figure class="w-[4rem] h-[4rem] overflow-hidden rounded-full flex justify-center items-center">
                                            <img src="{{ asset('storage/' . $pr->archivo_path) }}" alt="" class="w-full">
                                        </figure>
                                    </div>
                                    {{$pr->name}}
                                    <div class="col-12 p-0">
                                        <x-label value="{{ __('Prioridad') }}" />
                                        <select wire:model="carrito.{{$key}}.prioridad"
                                                class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700 " 
                                                name="carrito.{{$key}}.prioridad" required aria-required="true">
                                                <option hidden value="" selected>{{ __('Seleccionar Prioridad') }}</option>
                                                <option value="Bajo">{{ __('Bajo') }}</option>
                                                <option value="Medio">{{ __('Medio') }}</option>
                                                <option value="Alto">{{ __('Alto') }}</option>
                                                <option value="Alto crítico">{{ __('Alto crítico') }}</option>
                                        </select>
                                        <x-input-error for="carrito.{{$key}}.prioridad"></x-input-error>
                                    </div>
                                    <div>
                                        <x-label value="{{ __('Cantidad') }}" for="carrito.{{$key}}.cantidad" />
                                        <x-input wire:model="carrito.{{$key}}.cantidad" type="number" name="carrito.{{$key}}.cantidad" min
                                            id="carrito.{{$key}}.cantidad" required autofocus autocomplete="carrito.{{$key}}.cantidad" class="w-full"/>
                                        <x-input-error for="carrito.{{$key}}.cantidad"></x-input-error>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>    
                @endif
            </div>
        </div>
    @endif
    <div class="flex flex-wrap gap-3 justify-center">
        @if ($step == 1)
            <button  type="button" wire:click="nextStep" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 transition duration-300">
                Siguiente
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="currentColor">
                    <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
                </svg>
            </button>
        @else
            <button  type="button" wire:click="previusStep" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="currentColor">
                    <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
                </svg>
                Regresar
            </button>
            <button  type="button" wire:click="addCompra" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-green-600 text-white hover:bg-green-700 transition duration-300">
                Enviar
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-forward h-6 w-6"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5"></path>
                    <path d="M3 6l9 6l9 -6"></path>
                    <path d="M15 18h6"></path>
                    <path d="M18 15l3 3l-3 3"></path>
                 </svg>
            </button>
        @endif
    </div>
</div>