<x-app-layout>
    @section('title', 'Ver Ticket')
    <div class="flex flex-col sm:flex-row gap-2">
        <div class="bg-white dark:bg-dark-eval-3 text-gray-800 p-4 rounded-md shadow-lg mb-4 sm:mb-0">
            <ul class="list-style:none">
                <li class="mb-2"><strong class="dark:text-white">Ticket: </strong>
                    <span class="dark:text-white">#{{ $ticketID }}</span>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Status:</strong>
                    @if ($tck->status == 'Abierto')
                        <span class="bg-green-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'En proceso')
                        <span class="bg-orange-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Cerrado')
                        <span class="bg-gray-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @endif
                </li>
                <li class="mb-2"><strong class="dark:text-white">Cliente:</strong>
                    <div class="dark:text-white">
                        {{ $tck->cliente->name }}</div>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Creado:</strong>
                    <div class="dark:text-white">
                        {{ $tck->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}</div>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Vencimiento:</strong>
                    <div class="bg-gray-400 p-1 rounded-md text-white">
                        {{ \Carbon\Carbon::parse($tck->fecha_cierre)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                    </div>
                </li>
                @if ($tck->status == 'Cerrado' && $tck->cerrado != null)
                    <li class="mb-2"><strong class="dark:text-white">Cerrado:</strong>
                        <div class="bg-gray-400 p-1 rounded-md text-white">
                            {{ \Carbon\Carbon::parse($tck->cerrado)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                        </div>
                    </li>
                @endif
            </ul>
        </div>

        <div class="ml-0 sm:ml-16">
            @livewire('tickets.show-ticket', ['ticketID' => $ticketID])
        </div>
    </div>

    <div class="mt-4 bg-white dark:bg-dark-eval-1 text-gray-800 p-4 rounded-md shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-3">
            <span
                class="inline-flex items-center p-1 text-sm font-medium text-center text-white bg-gray-400 rounded-lg">
                Comentarios
                <span
                    class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                    {{ $comentarios->count() }}
                </span>
            </span>
            <div>
                @if ($tck->status != 'Cerrado')
                    @livewire('tickets.comentarios', ['ticketID' => $tck->id])
                @endif
            </div>
        </div>
        @if ($comentarios->count() > 0)
            <ul class="flex flex-col  max-h-[320px] overflow-y-auto">
                @foreach ($comentarios as $comentario)
                    <li>
                        @if ($comentario->archivos->count() > 0)
                            <div class="max-h-[320px] overflow-auto dark:border-gray-700">
                                <details class="w-1/2 float-right">
                                    <summary
                                        class=" bg-gray-100 py-2 px-4 cursor-pointer dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        Click para mostrar/ocultar Evidencias</summary>
                                    {{-- archivos de comentarios --}}
                                    <div>
                                        @if ($comentario->archivos)
                                            <label
                                                class="flex justify-center gap-3 items-center text-white bg-amber-600 p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    width="16" height="16" viewBox="0 0 576 512">
                                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path
                                                        d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z" />
                                                </svg>
                                                {{ __('Archivos Almacenados') }}
                                            </label>
                                            <div class="flex justyfy-venly flex-wrap gap-3 py-2">
                                                @foreach ($comentario->archivos as $antigArch)
                                                    @if ($antigArch->flag_trash == 0)
                                                        <div class="p-1">
                                                            @if (
                                                                $antigArch->mime_type == 'image/png' ||
                                                                    $antigArch->mime_type == 'image/jpg' ||
                                                                    $antigArch->mime_type == 'image/jpeg' ||
                                                                    $antigArch->mime_type == 'image/webp')
                                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                                    target="_blank"
                                                                    data-lightbox="imagenes-edit-{{ $antigArch->repuesto_id }}"
                                                                    data-title="{{ $antigArch->nombre_archivo }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Visualizar" class="text-xs">
                                                                    <figure class="d-inline-block max-w-[90px]"
                                                                        tabindex="0" data-bs-toggle="popover"
                                                                        data-bs-trigger="hover focus"
                                                                        data-bs-content="Presione para visualizar"
                                                                        data-bs-placement="top">
                                                                        <img class="w-full"
                                                                            src="{{ asset('storage/' . $antigArch->archivo_path) }}">
                                                                        <p class="break-all">
                                                                            {{ $antigArch->nombre_archivo }}</p>
                                                                        @if (strlen($antigArch->size) == 4)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 5)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 6)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 7)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 8)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                                            </p>
                                                                        @endif
                                                                    </figure>
                                                                </a>
                                                            @elseif ($antigArch->mime_type == 'application/pdf')
                                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                                    target="_blank" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" title="Visualizar"
                                                                    class="text-xs">
                                                                    <figure class="d-inline-block max-w-[90px]"
                                                                        tabindex="0" data-bs-toggle="popover"
                                                                        data-bs-trigger="hover focus"
                                                                        data-bs-content="Presione para descargar"
                                                                        data-bs-placement="top">
                                                                        <img class="w-100"
                                                                            src="{{ asset('img/icons/pdf.png') }}">
                                                                        <p class="break-all">
                                                                            {{ $antigArch->nombre_archivo }} </p>
                                                                        @if (strlen($antigArch->size) == 4)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 5)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 6)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 7)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 8)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                                            </p>
                                                                        @endif
                                                                    </figure>
                                                                </a>
                                                            @elseif ($antigArch->mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                                    target="_blank" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" title="Visualizar"
                                                                    class="text-xs">
                                                                    <figure class="d-inline-block max-w-[90px]"
                                                                        tabindex="0" data-bs-toggle="popover"
                                                                        data-bs-trigger="hover focus"
                                                                        data-bs-content="Presione para descargar"
                                                                        data-bs-placement="top">
                                                                        <img class="w-100"
                                                                            src="{{ asset('img/icons/word-2019.svg') }}">
                                                                        <p class="break-all">
                                                                            {{ $antigArch->nombre_archivo }} </p>
                                                                        @if (strlen($antigArch->size) == 4)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 5)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 6)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 7)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                                            </p>
                                                                        @elseif (strlen($antigArch->size) == 8)
                                                                            <p>
                                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                                            </p>
                                                                        @endif
                                                                    </figure>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </details>
                            </div>
                        @endif
                        <a
                            class="flex  px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                            <img class="object-cover w-10 h-10 rounded-full"
                                src="{{ asset('img/logo/blank-profile-picture-973460_1280.webp') }}" alt="username" />
                            <div class="w-full pb-2">
                                <div class="flex justify-between">
                                    <div class="flex">
                                        <span
                                            class="block ml-2 font-semibold text-gray-600 dark:text-white">{{ $comentario->usuario->name }}</span>
                                        <span
                                            class="block ml-2 bg-gray-400 p-1 rounded-md text-bold text-white text-xs">{{ $comentario->statustck }}</span>

                                    </div>
                                    <span
                                        class="block ml-2 text-xs text-gray-600 dark:text-white">{{ $comentario->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}</span>
                                </div>
                                <span
                                    class="block ml-2 text-sm text-gray-600 dark:text-white">{{ $comentario->comentario }}</span>

                            </div>
                            <button wire:click="removeCom({{ $comentario->id }})"
                                class="p-2 text-gray-500 hover:text-red-500 ">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 text-red-500">
                                    <path fill-rule="evenodd"
                                        d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </a>

                    </li>
                @endforeach
            </ul>
        @else
        <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                <img src="{{ asset('img/icons/Status update-amico.svg') }}" style="width: 350px" alt="Sin Comentarios">
                <span>No se encontraron comentarios.</span>
            </div>
        @endif
    </div>
</x-app-layout>
