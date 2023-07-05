<div>
    <button wire:click="confirmSolicitudEdit({{ $solicitud_id }})" wire:loading.attr="disabled" class="tooltip"
        data-target="EditSolicitud{{ $solicitud_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar Solicitud</span>
    </button>

    <x-dialog-modal wire:model="EditSolicitud" id="EditSolicitud{{ $solicitud_id }}" class="flex items-center">
        <x-slot name="title">
            <span class="dark:text-white">{{ __('Editar Solicitud') }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-wrap">
                <div class="mb-3 mr-2 ">
                    <x-label value="{{ __('Producto') }}" />
                    <select id="producto" wire:model="producto"
                        class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto') ? 'is-invalid' : '' }}"
                        name="producto" required aria-required="true">
                        <option hidden value="" selected>Seleccionar producto</option>
                        @foreach ($productos as $producto)
                            @if ($producto->status == 'Activo')
                                <option value="{{ $producto->id }}">{{ $producto->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error for="producto"></x-input-error>
                </div>
                <div class="mb-3 mr-2 ">
                    <x-label value="{{ __('Proveedor') }}" />
                    <select id="proveedor" wire:model="proveedor"
                        class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('proveedor') ? 'is-invalid' : '' }}"
                        name="proveedor" required aria-required="true">
                        <option hidden value="" selected>Seleccionar proveedor</option>
                        @foreach ($proveedores as $provee)
                            @if ($provee->flag_trash == 0)
                                <option value="{{ $provee->id }}">{{ $provee->titulo_proveedor }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error for="proveedor"></x-input-error>
                </div>
                <div class="mb-3 mr-2 ">
                    <x-label value="{{ __('Cantidad') }}" />
                    <x-input wire:model="cantidad"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
                        type="text" name="cantidad" :value="old('cantidad')" required autofocus autocomplete="cantidad"
                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                    <x-input-error for="cantidad"></x-input-error>
                </div>
                <div class="mb-3 mr-2 ">
                    <x-label value="{{ __('Motivo') }}" />
                    <x-input wire:model="motivo"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('motivo') ? 'is-invalid' : '' }}"
                        type="text" name="motivo" :value="old('motivo')" required autofocus autocomplete="motivo" />
                    <x-input-error for="motivo"></x-input-error>
                </div>
                <div class="mb-3 mr-2 ">
                    <a type="button" wire:click="EditarSolicitud({{ $solicitud_id }})"
                        class="cursor-pointer bg-green-100 hover:bg-green-200 text-green-800 text-base font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Nuevo</a>

                </div>
                <!--Vista productos solicitados -->
                <div class="grid grid-cols-4 gap-4">
                    @if ($solicitudEs)
                        {{-- <span class=" text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">{{ __('Productos Solicitados:') }}</span> --}}
                        @foreach ($solicitudEs->productos as $prod)
                            @if ($solicitudEs->deleted_at == null)
                                @if ($prod->status == 'Activo')
                                    <div class="mt-2 p-4 max-h-[320px] overflow-y-auto">
                                        <span class="inline justify-center">
                                            @if ($prod->product_photo_path == null)
                                                <img name="photo" class="rounded-full"
                                                    src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                    style="height: 4rem;" />
                                            @else
                                                <img name="photo" class="rounded-full"
                                                    src="{{ asset('storage/' . $prod->product_photo_path) }}"
                                                    style="height: 4rem;" />
                                            @endif
                                            <p class="text-xs dark:text-white">{{ $prod->name }}</p>
                                            <p>
                                                <span
                                                    class="text-xs bg-purple-100  text-purple-800  font-medium mr-2 px-2.5 py-0.5 rounded  dark:text-purple-800">
                                                    {{ __('Cantidad:') }}</span> <br>
                                                <button type="button"
                                                    class="bg-red-600 hover:bg-red-300 text-white text-xs font-semibold mr-2 px-0.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400"
                                                    wire:click="minusProduc({{ $prod->pivot->id }}, {{ $prod->id }})"
                                                    @if ($prod->pivot->cantidad == 0) {{ 'disabled' }} @endif>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M18 12H6" />
                                                    </svg>
                                                </button>
                                                <span
                                                    class="text-center dark:text-white ">{{ $prod->pivot->cantidad }}</span>
                                                <button type="button"
                                                    class="bg-green-600 hover:bg-green-300 text-white text-xs font-semibold mr-2 px-0.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400"
                                                    wire:click="moreProduc({{ $prod->pivot->id }}, {{ $prod->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6v12m6-6H6" />
                                                    </svg>
                                                </button>
                                            </p>
                                        </span>

                                        <button type="button"
                                            class="bg-red-600 hover:bg-red-300 text-white text-xs font-semibold mr-2 px-0.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400"
                                            wire:click="removeProduc({{ $prod->pivot->id }})">
                                            {{ __('Eliminar') }}
                                        </button>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </div>
                {{-- Lista de productos sugeridos --}}
                <div class="w-full">
                    @if ($sugerencias)
                        @if ($sugerencias->count() > 0)
                            <h2 class="border-b py-1 text-lg">Sugerencias</h2>
                        @endif
                        <div class="flex gap-2 items-stretch w-full overflow-auto py-3">
                            @foreach ($sugerencias as $ps)
                                <div class="flex flex-col items-center gap-2 p-2 border w-[320px]" wire:ignore>
                                    @if (isset($ps->product_photo_path))
                                        <figure class="w-28 h-28 rounded-full overflow-hidden">
                                            @if ($ps->product_photo_path == null)
                                                <img name="photo" class="w-full"
                                                    src="{{ asset('storage/product-photos/imagedefault.jpg') }}" />
                                            @else
                                                <img name="photo" class="w-full"
                                                    src="{{ asset('storage/' . $prod->product_photo_path) }}" />
                                            @endif
                                        </figure>
                                    @endif
                                    <div class=" font-bold">
                                        @if (isset($ps->name))
                                            {{ $ps->name }}
                                        @endif
                                    </div>
                                    <div class="w-full bg-amber-300 p-1 ">
                                        @if (isset($ps->stock) && isset($ps->stock_fijo))
                                            <p>En almacén: {{ $ps->stock }}</p>
                                            <p>Stock sugerido: {{ $ps->stock_fijo }}</p>
                                        @endif

                                    </div>
                                    @if (isset($ps->ps_id))
                                        <button type="button"
                                            wire:click="addSugerencia({{ $ps->ps_id }},{{ $solicitud_id }})"
                                            class="flex gap-1  justify-center items-center w-full p-2 rounded-md bg-green-600 text-white hover:bg-green-500 transition duration-300">
                                            {{ __('Añadir') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                class="w-3 h-3" fill="currentColor">
                                                <path
                                                    d="M246.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 109.3V320c0 17.7 14.3 32 32 32s32-14.3 32-32V109.3l73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 53 43 96 96 96H352c53 0 96-43 96-96V352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V352z" />
                                            </svg>
                                        </button>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="GenPDF({{ $solicitud_id }})" wire:loading.attr="disabled">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                {{ __('Actualizar y Generar PDF') }}
            </x-danger-button>
            <x-secondary-button wire:click="$toggle('EditSolicitud')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
