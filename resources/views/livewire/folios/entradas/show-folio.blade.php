<div x-data="{ modelOpen: true }">
    <button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="ver servicio" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300"
            viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path
                d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>
    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:p-0">
            <div x-cloak @click="modelOpen = false" x-show="modelOpen"
                x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-700/75 bg-opacity-75"
                aria-hidden="true"></div>
            <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-xl p-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl dark:bg-dark-eval-1">

                <div class="mb-1">
                    <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
                        <div>{{ __('Folio:') }} {{ $folio->folio }}</div>
                        {{-- <div> {{ __('Fecha:') }} {{ $folio->created_at }}</div> --}}
                    </div>
                </div>
                <div>
                    @if ($folio->entradas->count() > 0)
                        <div class="w-full py-2 text-lg">
                            <h1>Historial</h1>
                        </div>
                        <ul class="flex flex-col  max-h-[320px] overflow-y-auto">
                            @foreach ($folio->entradas as $entrada)
                                <li>
                                    <a
                                        class="flex  px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">

                                        @if ($entrada->usuario->profile_photo_path)
                                            <div
                                                onclick="window.location.href='{{ asset('/storage/' . $entrada->usuario->profile_photo_path) }}'">
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="/storage/{{ $entrada->usuario->profile_photo_path }}"
                                                    alt="{{ $entrada->usuario->name }}" />
                                            </div>
                                        @else
                                            <div
                                                onclick="window.location.href='{{ asset($entrada->usuario->profile_photo_url) }}'">
                                                <img class="object-cover w-10 h-10 rounded-full"
                                                    src="{{ $entrada->usuario->profile_photo_url }}"
                                                    alt="{{ $entrada->usuario->name }}" />
                                            </div>
                                        @endif
                                        <div class="w-full pb-2">
                                            <div class="flex justify-between">
                                                <div class="flex gap-2">
                                                    <span
                                                        class="block ml-2 font-semibold text-gray-600 dark:text-white">{{ $entrada->usuario->name }}</span>
                                                    <div class="float-right"> {{ __('Fecha:') }}
                                                        {{ $entrada->created_at }}</div>
                                                    @if ($entrada->editable == 1)
                                                        <div class="ml-6" style="display: flex; justify-content: center;">
                                                            <div class="flex gap-1">
                                                                <button onclick="window.location.href = '{{ route('entrada.edit', $entrada->id) }}'"
                                                                    title="Editar">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        class="w-4 h-4 text-gray-400 hover:text-indigo-500 transition duration-300">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                    </svg>
                                                                </button>
                                                                @livewire('folios.entradas.lock', ['entradaID' => $entrada->id])
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <span class="block ml-2 "></span>
                                            </div>
                                            <div class="flex items-center"> <!-- Agregado el contenedor flex -->
                                                <span
                                                    class="block ml-2 text-sm text-gray-600 dark:text-white">{{ $entrada->motivo }}</span>
                                            </div>
                                            <div
                                                class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                                                <details>
                                                    <summary class="bg-gray-200 py-2 px-4 cursor-pointer">Click para
                                                        mostrar/ocultar
                                                        productos</summary>
                                                    <table class="table-auto w-full">
                                                        <thead>
                                                            <tr>
                                                                <th class="px-4 py-2">Imagen</th>
                                                                <th class="px-4 py-2">Producto</th>
                                                                <th class="px-4 py-2">Cantidad</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($entrada->productos as $producto)
                                                                <tr>
                                                                    <td
                                                                        class="border px-4 py-2 w-[4rem] h-[4rem] overflow-hidden rounded-full flex justify-center items-center">
                                                                        <img src="{{ asset('storage/' . $producto->producto->product_photo_path) }}"
                                                                            alt="" class="w-full">
                                                                    </td>
                                                                    <td
                                                                        class="w-full lg:w-auto p-3 text-center border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                                                        <span
                                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Nombre</span>
                                                                        <div class="text-sm">
                                                                            <div
                                                                                class="font-medium text-gray-700 dark:text-gray-400">
                                                                                {{ $producto->producto->name }}</div>
                                                                            <div
                                                                                class="text-gray-400 dark:text-gray-400">
                                                                                @if (isset($producto->serie->serie))
                                                                                    {{ $producto->serie->serie }}
                                                                                @endif

                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="border px-4 py-2">
                                                                        <span class="text-xs text-center">
                                                                            {{ $producto->cantidad }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="border px-4 py-2" colspan="3">Sin
                                                                        datos.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </details>
                                            </div>
                                        </div>
                                        <button
                                            onclick="window.open('{{ asset('Storage/' . $entrada->pdf) }}', '_blank')">
                                            <svg class="w-12 h-12" viewBox="0 0 32 32"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill="#909090"
                                                    d="m24.1 2.072l5.564 5.8v22.056H8.879V30h20.856V7.945L24.1 2.072" />
                                                <path fill="#f4f4f4" d="M24.031 2H8.808v27.928h20.856V7.873L24.03 2" />
                                                <path fill="#7a7b7c" d="M8.655 3.5h-6.39v6.827h20.1V3.5H8.655" />
                                                <path fill="#dd2025" d="M22.472 10.211H2.395V3.379h20.077v6.832" />
                                                <path fill="#464648"
                                                    d="M9.052 4.534H7.745v4.8h1.028V7.715L9 7.728a2.042 2.042 0 0 0 .647-.117a1.427 1.427 0 0 0 .493-.291a1.224 1.224 0 0 0 .335-.454a2.13 2.13 0 0 0 .105-.908a2.237 2.237 0 0 0-.114-.644a1.173 1.173 0 0 0-.687-.65a2.149 2.149 0 0 0-.409-.104a2.232 2.232 0 0 0-.319-.026m-.189 2.294h-.089v-1.48h.193a.57.57 0 0 1 .459.181a.92.92 0 0 1 .183.558c0 .246 0 .469-.222.626a.942.942 0 0 1-.524.114m3.671-2.306c-.111 0-.219.008-.295.011L12 4.538h-.78v4.8h.918a2.677 2.677 0 0 0 1.028-.175a1.71 1.71 0 0 0 .68-.491a1.939 1.939 0 0 0 .373-.749a3.728 3.728 0 0 0 .114-.949a4.416 4.416 0 0 0-.087-1.127a1.777 1.777 0 0 0-.4-.733a1.63 1.63 0 0 0-.535-.4a2.413 2.413 0 0 0-.549-.178a1.282 1.282 0 0 0-.228-.017m-.182 3.937h-.1V5.392h.013a1.062 1.062 0 0 1 .6.107a1.2 1.2 0 0 1 .324.4a1.3 1.3 0 0 1 .142.526c.009.22 0 .4 0 .549a2.926 2.926 0 0 1-.033.513a1.756 1.756 0 0 1-.169.5a1.13 1.13 0 0 1-.363.36a.673.673 0 0 1-.416.106m5.08-3.915H15v4.8h1.028V7.434h1.3v-.892h-1.3V5.43h1.4v-.892" />
                                                <path fill="#dd2025"
                                                    d="M21.781 20.255s3.188-.578 3.188.511s-1.975.646-3.188-.511Zm-2.357.083a7.543 7.543 0 0 0-1.473.489l.4-.9c.4-.9.815-2.127.815-2.127a14.216 14.216 0 0 0 1.658 2.252a13.033 13.033 0 0 0-1.4.288Zm-1.262-6.5c0-.949.307-1.208.546-1.208s.508.115.517.939a10.787 10.787 0 0 1-.517 2.434a4.426 4.426 0 0 1-.547-2.162Zm-4.649 10.516c-.978-.585 2.051-2.386 2.6-2.444c-.003.001-1.576 3.056-2.6 2.444ZM25.9 20.895c-.01-.1-.1-1.207-2.07-1.16a14.228 14.228 0 0 0-2.453.173a12.542 12.542 0 0 1-2.012-2.655a11.76 11.76 0 0 0 .623-3.1c-.029-1.2-.316-1.888-1.236-1.878s-1.054.815-.933 2.013a9.309 9.309 0 0 0 .665 2.338s-.425 1.323-.987 2.639s-.946 2.006-.946 2.006a9.622 9.622 0 0 0-2.725 1.4c-.824.767-1.159 1.356-.725 1.945c.374.508 1.683.623 2.853-.91a22.549 22.549 0 0 0 1.7-2.492s1.784-.489 2.339-.623s1.226-.24 1.226-.24s1.629 1.639 3.2 1.581s1.495-.939 1.485-1.035" />
                                                <path fill="#909090" d="M23.954 2.077V7.95h5.633l-5.633-5.873Z" />
                                                <path fill="#f4f4f4" d="M24.031 2v5.873h5.633L24.031 2Z" />
                                                <path fill="#fff"
                                                    d="M8.975 4.457H7.668v4.8H8.7V7.639l.228.013a2.042 2.042 0 0 0 .647-.117a1.428 1.428 0 0 0 .493-.291a1.224 1.224 0 0 0 .332-.454a2.13 2.13 0 0 0 .105-.908a2.237 2.237 0 0 0-.114-.644a1.173 1.173 0 0 0-.687-.65a2.149 2.149 0 0 0-.411-.105a2.232 2.232 0 0 0-.319-.026m-.189 2.294h-.089v-1.48h.194a.57.57 0 0 1 .459.181a.92.92 0 0 1 .183.558c0 .246 0 .469-.222.626a.942.942 0 0 1-.524.114m3.67-2.306c-.111 0-.219.008-.295.011l-.235.006h-.78v4.8h.918a2.677 2.677 0 0 0 1.028-.175a1.71 1.71 0 0 0 .68-.491a1.939 1.939 0 0 0 .373-.749a3.728 3.728 0 0 0 .114-.949a4.416 4.416 0 0 0-.087-1.127a1.777 1.777 0 0 0-.4-.733a1.63 1.63 0 0 0-.535-.4a2.413 2.413 0 0 0-.549-.178a1.282 1.282 0 0 0-.228-.017m-.182 3.937h-.1V5.315h.013a1.062 1.062 0 0 1 .6.107a1.2 1.2 0 0 1 .324.4a1.3 1.3 0 0 1 .142.526c.009.22 0 .4 0 .549a2.926 2.926 0 0 1-.033.513a1.756 1.756 0 0 1-.169.5a1.13 1.13 0 0 1-.363.36a.673.673 0 0 1-.416.106m5.077-3.915h-2.43v4.8h1.028V7.357h1.3v-.892h-1.3V5.353h1.4v-.892" />
                                            </svg>
                                        </button>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="max-w-[150px] bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                            <span class="text-lg">Sin folios de entrada registrados</span>
                        </div>
                    @endif
                </div>
                <div class="mt-3 float-right">
                    <x-secondary-button @click="modelOpen = false" wire:loading.attr="disabled">
                        Cerrar
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>
