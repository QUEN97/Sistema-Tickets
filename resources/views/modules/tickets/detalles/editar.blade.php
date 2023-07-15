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
            @livewire('tickets.edit-ticket', ['ticketID' => $ticketID])
        </div>
    </div>

    <div class="mt-4 bg-white dark:bg-dark-eval-1 text-gray-800 p-4 rounded-md shadow-lg">
        <span class="bg-gray-400 p-1 rounded-md text-white text-bold">Evidencias: </span>
        {{-- Evidencias en BD --}}
        <div class="max-h-[150px] overflow-auto">
            @if ($evidenciaArc)
                @if ($evidenciaArc->count() > 0)
                    <label class="flex justify-center gap-3 items-center text-white bg-pink-600 p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="16" height="16"
                            viewBox="0 0 576 512">
                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z" />
                        </svg>
                        {{ __('Archivos Almacenados') }}
                    </label>
                    <div class="flex justyfy-venly flex-wrap gap-3 py-2">
                        @foreach ($evidenciaArc as $antigArch)
                            @if ($antigArch->flag_trash == 0)
                                <div class="relative p-1">
                                    @if (
                                        $antigArch->mime_type == 'image/png' ||
                                            $antigArch->mime_type == 'image/jpg' ||
                                            $antigArch->mime_type == 'image/jpeg' ||
                                            $antigArch->mime_type == 'image/webp')
                                        <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                            data-lightbox="imagenes-edit-{{ $antigArch->repuesto_id }}"
                                            data-title="{{ $antigArch->nombre_archivo }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Visualizar" class="text-xs">
                                            <figure class="d-inline-block max-w-[90px]" tabindex="0"
                                                data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                data-bs-content="Presione para visualizar" data-bs-placement="top">
                                                <img class="w-full"
                                                    src="{{ asset('storage/' . $antigArch->archivo_path) }}">
                                                <p class="break-all">{{ $antigArch->nombre_archivo }}</p>
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
                                        <a href="{{ asset('storage/' . $antigArch->archivo_path) }}" download=""
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"
                                            class="text-xs">
                                            <figure class="d-inline-block max-w-[90px]" tabindex="0"
                                                data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                data-bs-content="Presione para descargar" data-bs-placement="top">
                                                <img class="w-100" src="{{ asset('img/icons/pdf.png') }}">
                                                <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
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
                                        <a href="{{ asset('storage/' . $antigArch->archivo_path) }}" download=""
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"
                                            class="text-xs">
                                            <figure class="d-inline-block max-w-[90px]" tabindex="0"
                                                data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                data-bs-content="Presione para descargar" data-bs-placement="top">
                                                <img class="w-100" src="{{ asset('img/icons/word-2019.svg') }}">
                                                <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
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
                                    <form action="{{ route('tck.destroy', ['id' => $antigArch->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-500 hover:text-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill w-5 h-5 text-gray-400 hover:text-orange-800 transition duration-300" viewBox="0 0 16 16">
                                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                        <p style="display: flex; justify-content: center;"><img
                            src="{{ asset('img/logo/emptystate.svg') }}" style="width:500px;"
                            alt="Buzón Vacío"></p>
                            No se encontraron archivos.
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
