<div>
    <div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div>
            <h2 class="text-center font-bold text-lg">INFORMACIÓN ACTUAL</h2>
        </div>
        <div>
            <div>
                <x-label value="{{ __('Titulo del correo') }}" for="titulo" />
                <x-input wire:model.defer="titulo" type="text" name="titulo"
                    id="titulo" required autofocus autocomplete="titulo" class="w-full"/>
                <x-input-error for="titulo"></x-input-error>
            </div>
            <div>
                <x-label value="{{ __('Problema detectado') }}" />
                <textarea wire:model.defer="problema" class="form-control h-40 w-full resize-none rounded-md dark:bg-slate-800" name="problema"
                    required autofocus autocomplete="problema" cols="30" rows="8"></textarea>
                <x-input-error for="problema"></x-input-error>
            </div>
            <div>
                <x-label value="{{ __('Solución') }}" />
                <textarea wire:model.defer="solucion" class="form-control h-28 w-full resize-none rounded-md dark:bg-slate-800" name="solucion"
                    required autofocus autocomplete="solucion" cols="30" rows="8"></textarea>
                <x-input-error for="solucion"></x-input-error>
            </div>
            {{-- Evidencias en BD --}}
            <div class="my-2">
                @if ($compra->evidencias->count() > 0)
                    <label class="flex justify-center gap-3 items-center text-white bg-amber-600 p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="16" height="16" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z"/>
                        </svg>
                        {{ __('Evidencias registradas') }}
                    </label>
                    <div class="flex flex-wrap gap-3 py-2">
                        @foreach ($compra->evidencias as $antigArch)
                            @if ($antigArch->flag_trash == 0)
                                <div class="p-5 relative max-w-[18rem] border rounded-md shadow-md dark:bg-slate-700 dark:border-slate-700">
                                    @if ($antigArch->mime_type == "image/png" || $antigArch->mime_type == "image/jpg" || $antigArch->mime_type == "image/jpeg" 
                                                            || $antigArch->mime_type == "image/webp")
                                        <a href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank" data-lightbox="imagenes-edit-{{ $antigArch->repuesto_id }}" data-title="{{ $antigArch->nombre_archivo }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                            <figure class="d-inline-block max-w-[160px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para visualizar" data-bs-placement="top">
                                                <img class="w-full" src="{{ asset('storage/'.$antigArch->archivo_path) }}">
                                                <p class="break-all">{{ $antigArch->nombre_archivo }}</p>
                                            </figure>
                                        </a>
                                    @elseif ($antigArch->mime_type == "application/pdf")
                                        <a href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                            <figure class="d-inline-block max-w-[160px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                <img class="w-100" src="{{ asset('img/icons/pdf.png') }}">
                                                <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                            </figure>
                                        </a>
                                    @elseif ($antigArch->mime_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                                        <a  href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                            <figure class="d-inline-block max-w-[160px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                <img class="w-100" src="{{ asset('img/icons/word-2019.svg') }}">
                                                <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                            </figure>
                                        </a>
                                    @endif
                                    <button type="button" class="absolute top-1 right-1" wire:click="deleteEvidencia({{$antigArch->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="Doble click para Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg"  class="bi bi-trash3-fill w-5 h-5 text-gray-400 hover:text-orange-800 transition duration-300"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="max-w-[100px]  icon icon-tabler icon-tabler-folder-off" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M8 4h1l3 3h7a2 2 0 0 1 2 2v8m-2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 1.189 -1.829"></path>
                            <path d="M3 3l18 18"></path>
                        </svg>
                        <span class="text-xl">No se encontraron Evidencias</span>
                    </div>
                @endif
            </div>
            {{-- Productos/servicios registrados --}}
            <div>
                <label class="flex justify-center gap-3 items-center text-white bg-sky-600 p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512" fill="currentColor">
                        <path d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128h2.2z"/>
                    </svg>
                    {{ __('Productos/servicios actuales') }}
                </label>
                <div class="flex flex-wrap p-2 gap-2">
                    @if ($tipo=='prod')    
                        @foreach ($compra->productos as $key =>$pr)
                            <div class=" border flex flex-wrap gap-1 rounded-md justify-center items-center p-2 shadow-md max-w-[18rem] relative dark:bg-slate-700 dark:border-slate-700">
                                <figure class=" w-28 h-28 rounded-full flex justify-center items-center overflow-hidden">
                                    <img src="{{asset('storage/'.$pr->producto->product_photo_path )}}" alt="" class="w-full">
                                </figure>
                                <div>
                                    <div>{{$pr->producto->name}}</div>
                                    {{-- <div><span class=" font-bold">Prioridad: </span>{{$pr->prioridad}}</div> --}}
                                    <div>
                                        <x-label value="{{ __('Cantidad') }}" for="carrito.{{$key}}.cantidad" />
                                        <x-input wire:model.defer="carrito.{{$key}}.cantidad" type="number" name="carrito.{{$key}}.cantidad" min
                                            id="carrito.{{$key}}.cantidad" required autofocus autocomplete="carrito.{{$key}}.cantidad" class="w-full"/>
                                        <x-input-error for="carrito.{{$key}}.cantidad"></x-input-error>
                                    </div>    
                                </div>
                                <button type="button" class="absolute top-1 right-1" wire:click="deleteCarrito({{$pr->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="Doble click para Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg"  class="bi bi-trash3-fill w-5 h-5 text-gray-400 hover:text-orange-800 transition duration-300"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor"></path>
                                        <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @else
                        @foreach ($compra->servicios as $key =>$servicio)
                            <div class=" border flex flex-wrap gap-1 rounded-md justify-center items-center p-2 shadow-md max-w-[18rem] relative dark:bg-slate-700 dark:border-slate-700">
                                <div>
                                    <div>{{$servicio->servicio->name}}</div>
                                    {{-- <div><span class=" font-bold">Prioridad: </span>{{$servicio->prioridad}}</div> --}}
                                    <div>
                                        <x-label value="{{ __('Cantidad') }}" for="carrito.{{$key}}.cantidad" />
                                        <x-input wire:model.defer="carrito.{{$key}}.cantidad" type="number" name="carrito.{{$key}}.cantidad" min
                                            id="carrito.{{$key}}.cantidad" required autofocus autocomplete="carrito.{{$key}}.cantidad" class="w-full"/>
                                        <x-input-error for="carrito.{{$key}}.cantidad"></x-input-error>
                                    </div>    
                                </div>
                                <button type="button" class="absolute top-1 right-1" wire:click="deleteCarrito({{$servicio->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="Doble click para Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg"  class="bi bi-trash3-fill w-5 h-5 text-gray-400 hover:text-orange-800 transition duration-300"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor"></path>
                                        <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div>
            <h2 class="text-center font-bold text-lg">IINGRESAR NUEVA INFORMACIÓN</h2>
        </div>
        <div class="mb-1 col-12 w-full"
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                <h2 class="font-bold text-lg border-b border-gray-400 w-full mb-2">Evidencias</h2>
                <input type="file" wire:model="evidencias" class=" pb-2 flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                multiple name="evidencias" required autocomplete="evidencias" accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                <x-input-error for="evidencias"></x-input-error>

                <!-- Progress Bar -->
                <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-2 dark:bg-gray-700">
                    <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"  x-bind:style="`width:${progress}%`"></div>
                </div>
            </div>
            @if ($tipo=='prod')    
                <div class="flex flex-col gap-2">
                    <h2 class="font-bold text-lg border-b border-gray-400 w-full mb-2">Productos</h2>
                    <div class="flex flex-wrap gap-2 items-end">
                        <div>
                            <x-label value="{{ __('Categoría de producto') }}" />
                            <select id="categoria" wire:model="categoria"
                                    class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('categoria') ? 'is-invalid' : '' }}" 
                                    name="categoria" required aria-required="true">
                                <option hidden value="" selected>{{ __('Seleccionar categoria') }}</option>
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
                    <x-input-error for="newCarrito"></x-input-error>
                    <div>
                        @if ($productos)
                            <div class="py-1 border-b-2 mb-2">
                                <h2>Seleccione sus productos</h2>
                            </div>
                            <div class="flex flex-wrap gap-2 justify-center max-h-80 overflow-auto">
                                @foreach ($productos as $key => $pr)
                                    <div class="flex flex-row items-center gap-0.5 relative">
                                        <input type="checkbox" wire:model.defer="newCarrito.{{$key}}.id" value="{{$pr->id }}" name="newCarrito[]" id="{{$pr->name}}" class="peer absolute top-2 right-2">
                                        <label for="{{$pr->name}}" class="break-all text-start w-full border-2 py-1 px-2 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600">
                                            <div class="flex justify-center items-center">
                                                <figure class="w-[4rem] h-[4rem] overflow-hidden rounded-full flex justify-center items-center">
                                                    <img src="{{ asset('storage/' . $pr->product_photo_path) }}" alt="" class="w-full">
                                                </figure>
                                            </div>
                                            {{$pr->name}}
                                            {{-- <div class="col-12 p-0">
                                                <x-label value="{{ __('Prioridad') }}" />
                                                <select wire:model.defer="newCarrito.{{$key}}.prioridad"
                                                        class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700 " 
                                                        name="newCarrito.{{$key}}.prioridad" required aria-required="true">
                                                        <option hidden value="" selected>{{ __('Seleccionar Prioridad') }}</option>
                                                        <option value="Bajo">{{ __('Bajo') }}</option>
                                                        <option value="Medio">{{ __('Medio') }}</option>
                                                        <option value="Alto">{{ __('Alto') }}</option>
                                                        <option value="Alto crítico">{{ __('Alto crítico') }}</option>
                                                </select>
                                                <x-input-error for="newCarrito.{{$key}}.prioridad"></x-input-error>
                                            </div> --}}
                                            <div>
                                                <x-label value="{{ __('Cantidad') }}" for="newCarrito.{{$key}}.cantidad" />
                                                <x-input wire:model.defer="newCarrito.{{$key}}.cantidad" type="number" name="newCarrito.{{$key}}.cantidad" min
                                                    id="newCarrito.{{$key}}.cantidad" required autofocus autocomplete="newCarrito.{{$key}}.cantidad" class="w-full"/>
                                                <x-input-error for="newCarrito.{{$key}}.cantidad"></x-input-error>
                                            </div>
                                        </label>
                                        
                                    </div>
                                @endforeach
                            </div>    
                        @endif
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-2">
                    <h2 class="font-bold text-lg border-b border-gray-400 w-full mb-2">Servicios</h2>
                    <div>
                        <x-input wire:model.debounce.200ms="searchService" type="search" name="searchService"
                            id="searchService" placeholder="Buscar..." required autofocus autocomplete="searchService" class="w-full"/>
                    </div>
                    <x-input-error for="newCarrito"></x-input-error>
                    <div>
                        @if ($servicios)
                            <div class="py-1 border-b-2 mb-2">
                                <h2>Seleccione los servicios que requiere</h2>
                            </div>
                            <div class="flex flex-wrap gap-2 justify-center max-h-80 overflow-auto">
                                @foreach ($servicios as $key => $pr)
                                    <div class="flex flex-row items-center gap-0.5">
                                        <input type="checkbox" wire:model.defer="newCarrito.{{$key}}.id" value="{{$pr->id }}" name="newCarrito[]" id="{{$pr->name}}" class="peer hidden">
                                        <label for="{{$pr->name}}" class="break-all text-start w-full border-2 py-1 px-2 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600">
                                            {{$pr->name}}
                                            {{-- <div class="col-12 p-0">
                                                <x-label value="{{ __('Prioridad') }}" />
                                                <select wire:model.defer="newCarrito.{{$key}}.prioridad"
                                                        class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700 " 
                                                        name="newCarrito.{{$key}}.prioridad" required aria-required="true">
                                                        <option hidden value="" selected>{{ __('Seleccionar Prioridad') }}</option>
                                                        <option value="Bajo">{{ __('Bajo') }}</option>
                                                        <option value="Medio">{{ __('Medio') }}</option>
                                                        <option value="Alto">{{ __('Alto') }}</option>
                                                        <option value="Alto crítico">{{ __('Alto crítico') }}</option>
                                                </select>
                                                <x-input-error for="newCarrito.{{$key}}.prioridad"></x-input-error>
                                            </div> --}}
                                            <div>
                                                <x-label value="{{ __('Cantidad') }}" for="newCarrito.{{$key}}.cantidad" />
                                                <x-input wire:model.defer="newCarrito.{{$key}}.cantidad" type="number" name="newCarrito.{{$key}}.cantidad" min
                                                    id="newCarrito.{{$key}}.cantidad" required autofocus autocomplete="newCarrito.{{$key}}.cantidad" class="w-full"/>
                                                <x-input-error for="newCarrito.{{$key}}.cantidad"></x-input-error>
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
            <button  type="button" wire:click="updateCompra" class="rounded-md  flex gap-1 items-center px-3 py-1 bg-green-700 text-white hover:bg-green-800 transition duration-300">
                <div role="status" wire:loading wire:target="updateCompra">
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
                Guardar 
            </button>
        </div>
    </div>
</div>
