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
            <li class="flex w-full items-center ">
                <div @if ($step == 1)
                class="flex items-center justify-center w-10 h-10 bg-gray-300 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0"
                @else
                class="flex items-center justify-center w-10 h-10 bg-sky-700 rounded-full lg:h-12 lg:w-12  shrink-0 text-white"
                @endif>
                    2
                </div>
                <div class="w-full bg-gray-300 dark:bg-gray-700 h-1">
                    @if ($step >=2)
                        <div style="width: {{$w2}}%" class="h-1 border-b border-sky-700 border-4 transition-[width] duration-500"></div>
                    @endif
                </div>
            </li>
            <li class="flex items-center ">
                <div @if ($step <= 2)
                class="flex items-center justify-center w-10 h-10 bg-gray-300 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0"
                @else
                class="flex items-center justify-center w-10 h-10 bg-sky-700 rounded-full lg:h-12 lg:w-12  shrink-0 text-white"
                @endif>
                    3
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
    @elseif($step ==2)
        <div class="flex justify-center gap-2">
            <div>
                <input wire:model="tipo" type="radio" name="tipo" id="Producto" value="Producto" class="peer/producto hidden">
                <label for="Producto" class="cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/producto:bg-amber-600 hover:bg-amber-500 text-white px-3 py-1 rounded-md transition duration-300">
                    Producto
                </label>
            </div>
            <div>
                <input wire:model="tipo" type="radio" name="tipo" id="Servicio" value="Servicio" class=" peer/producto hidden">
                <label for="Servicio" class="cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/producto:bg-amber-600 hover:bg-amber-500 text-white px-3 py-1 rounded-md transition duration-300">
                    Servicio
                </label>
            </div>
        </div>
        @if ($tipo == "Producto")    
            <div class="flex flex-col gap-2">
                <div class="flex flex-wrap gap-2 items-end">
                    <div>
                        <x-label value="{{ __('Categoría de producto') }}" />
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
                        <div class="flex flex-wrap gap-3 justify-center max-h-80 overflow-auto">
                            @foreach ($productos as $key => $pr)
                                <div class="flex flex-row items-center gap-0.5 relative max-w-[20rem]">
                                    <input type="checkbox" wire:model="carrito.{{$key}}.id" value="{{$pr->id }}" name="carrito[]" id="{{$pr->name}}" class="peer absolute top-2 right-2">
                                    <label for="{{$pr->name}}" class="break-all w-full text-center border-2 py-2 px-3 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600">
                                        <div class="flex justify-center items-center">
                                            <figure class="w-[8rem] h-[8rem] overflow-hidden rounded-full flex justify-center items-center">
                                                <img src="{{ asset('storage/' . $pr->product_photo_path) }}" alt="" class="w-full">
                                            </figure>
                                        </div>
                                        {{$pr->name}}
                                        {{-- <div class="col-12 p-0">
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
                                        </div> --}}
                                    </label>
                                </div>
                            @endforeach
                        </div>    
                    @endif
                </div>
            </div>
        @elseif ($tipo == "Servicio")
            <div>
                <x-input wire:model.debounce.200ms="searchService" type="search" name="searchService"
                    id="searchService" placeholder="Buscar..." required autofocus autocomplete="searchService" class="w-full"/>
            </div>
            <x-input-error for="carrito"></x-input-error>
            <div>
                @if ($servicios)
                    <div class="py-1 border-b-2 mb-2">
                        <h2>Seleccione los servicios que requiere</h2>
                    </div>
                    <div class="flex flex-wrap gap-3 justify-evenly max-h-80 overflow-auto">
                        @foreach ($servicios as $key => $pr)
                            <div class="flex flex-row items-center gap-0.5 relative ">
                                <input type="checkbox" wire:model="carrito.{{$key}}.id" value="{{$pr->id }}" name="carrito[]" id="{{$pr->name}}" class="hidden peer absolute top-2 right-2">
                                <label for="{{$pr->name}}" class="break-all w-full text-center border-2 py-2 px-3 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600">
                                    {{$pr->name}}               
                                </label>
                            </div>
                        @endforeach
                    </div>    
                @endif
            </div>
        @endif
    @else
    {{-- step #3 --}}
    <div class="flex flex-col gap-2">
        <div>
            @if ($tipo=="Producto")    
                @if ($productos)
                    <div class="py-1 border-b-2 mb-2">
                        <h2>Ingrese la información de sus productos</h2>
                    </div>
                    <div class="flex flex-wrap gap-2 justify-center max-h-80 overflow-auto">
                        @foreach ($productos as $key => $pr)
                            @foreach ($carrito as $produc)
                                @if ($produc['id'] == $pr->id)
                                <div class="flex flex-row items-center gap-0.5">
                                    <div class="break-all text-start w-full border-2 py-1 px-2 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600">
                                        <x-input-error for="carrito.{{$key}}"></x-input-error>
                                        <div class="flex justify-center items-center">
                                            <figure class="w-[4rem] h-[4rem] overflow-hidden rounded-full flex justify-center items-center">
                                                <img src="{{ asset('storage/' . $pr->product_photo_path) }}" alt="" class="w-full">
                                            </figure>
                                        </div>
                                        {{$pr->name}}
                                        {{-- <div class="col-12 p-0">
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
                                        </div> --}}
                                        <div>
                                            <x-label value="{{ __('Cantidad') }}" for="carrito.{{$key}}.cantidad" />
                                            <x-input wire:model="carrito.{{$key}}.cantidad" type="number" name="carrito.{{$key}}.cantidad" min
                                                id="carrito.{{$key}}.cantidad" required autofocus autocomplete="carrito.{{$key}}.cantidad" class="w-full"/>
                                            <x-input-error for="carrito.{{$key}}.cantidad"></x-input-error>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>    
                @endif
            @elseif($tipo=="Servicio")
            <div class="py-1 border-b-2 mb-2">
                <h2>Complete la siguiente información</h2>
            </div>
            <div class="flex flex-wrap gap-2 justify-center max-h-80 overflow-auto">
                @foreach ($servicios as $key => $pr)
                    @foreach ($carrito as $produc)
                        @if ($produc['id'] == $pr->id)
                        <div class="flex flex-row items-center gap-0.5">
                            <div class="break-all text-start w-full border-2 py-1 px-2 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600">
                                <x-input-error for="carrito.{{$key}}"></x-input-error>
                                <h2>{{$pr->name}}</h2>
                                {{-- <div class="col-12 p-0">
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
                                </div> --}}
                                <div>
                                    <x-label value="{{ __('Cantidad') }}" for="carrito.{{$key}}.cantidad" />
                                    <x-input wire:model="carrito.{{$key}}.cantidad" type="number" name="carrito.{{$key}}.cantidad" min
                                        id="carrito.{{$key}}.cantidad" required autofocus autocomplete="carrito.{{$key}}.cantidad" class="w-full"/>
                                    <x-input-error for="carrito.{{$key}}.cantidad"></x-input-error>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
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
        @elseif($step==2)
            <button  type="button" wire:click="previusStep" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="currentColor">
                    <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
                </svg>
                Regresar
            </button>
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
            @if (count($carrito) > 0)    
                <button  type="button" wire:click="addCompra" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-green-600 text-white hover:bg-green-700 transition duration-300">
                    <div role="status" wire:loading wire:target="addCompra">
                        <svg aria-hidden="true"
                            class="inline w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-white"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    Enviar
                </button>
            @endif
        @endif
    </div>
    
    
</div>