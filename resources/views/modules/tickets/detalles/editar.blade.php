<x-app-layout>
    @section('title', 'EditarTicket')

    <div class="flex flex-col items-center sm:flex-row gap-2">
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
                    @elseif ($tck->status == 'Vencido')
                        <span class="bg-red-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Cerrado')
                        <span class="bg-gray-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Por abrir')
                        <span class="bg-indigo-400 p-1 rounded-md text-white">
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

            {{-- Botones acción --}}
            @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 7 || Auth::user()->permiso_id == 4)
                <div class="bg-dark-eval-1 dark:bg-dark-eval-2 p-2 rounded-md text-white text-center">
                    {{ __('Ir a:') }}
                </div>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-center mt-5">
                    <div class="flex justify-center rounded-lg" role="group">
                        <a class=" tooltip"
                            href="{{ route('tck.ver', $tck->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" fill="currentColor"
                                class="w-6 h-6 text-black hover:text-indigo-600 dark:text-white" viewBox="0 0 576 512">
                                <path
                                    d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                            </svg>
                            <span class="tooltiptext">Ver Más</span>
                        </a>
                        @if (Auth::user()->permiso_id == 1)
                            @livewire('tickets.reasignar', ['ticketID' => $tck->id])
                        @endif
                        <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                            href="{{ route('tck.tarea', $tck->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 text-black hover:text-indigo-600 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                            <span class="tooltiptext">Tareas</span>
                        </a>
                        @livewire('tickets.compras.show-compras', ['ticketID' => $tck->id])

                        @if (Auth::user()->permiso_id == 1 && $tck->status == 'Cerrado')
                            @livewire('tickets.unlock-ticket', ['ticketID' => $tck->id])
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="ml-0 sm:ml-16">
            @livewire('tickets.edit-ticket', ['ticketID' => $ticketID])
        </div>
    </div>

    <div class="mt-4 bg-white dark:bg-dark-eval-1 text-gray-800 p-4 rounded-md shadow-lg">
        <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
            {{ __('Evidencias del ticket:') }}
        </div>
        {{-- Evidencias en BD --}}
        <div class="max-h-[150px] overflow-auto">
            @if ($evidenciaArc)
                    <div class="flex justify-evenly flex-wrap gap-3 py-2">
                        @forelse ($evidenciaArc as $antigArch)
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
                                    @elseif ($antigArch->mime_type == 'video/mp4')
                                        <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                            data-title="{{ $antigArch->nombre_archivo }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Visualizar" class="text-xs">
                                            <figure class="d-inline-block max-w-[90px]" tabindex="0">
                                                <img class="w-100"
                                                    src="{{ asset('img/icons/videos_video_media_cinema_1725.png') }}">
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
                                                <img class="w-100" src="{{ asset('img/icons/file-type-pdf2.svg') }}">
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
                                                <img class="w-100"
                                                    src="{{ asset('img/icons/file-type-word.svg') }}">
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
                                    <form action="{{ route('tck.destroy', ['id' => $antigArch->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 rounded-lg p-1 text-sm text-white">
                                            Eliminar archivo
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @empty
                                sin registros
                        @endforelse
                    </div>
            @endif
        </div>
    </div>
</x-app-layout>
