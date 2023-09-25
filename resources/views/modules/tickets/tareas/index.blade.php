<x-app-layout>
    @section('title', 'Tarea')
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
                    @elseif ($tck->status == 'Vencido')
                        <span class="bg-red-400 p-1 rounded-md text-white">
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
            {{-- Botones acción --}}
            @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 7 || Auth::user()->permiso_id == 4 || Auth::user()->permiso_id == 5)
                <div class="bg-dark-eval-1 dark:bg-dark-eval-2 p-2 rounded-md text-white text-center">
                    {{ __('Ir a:') }}
                </div>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-center mt-5">
                    <div class="flex justify-center rounded-lg" role="group">
                        @if (Auth::user()->permiso_id == 1)
                            <a class="tooltip"
                                href="{{ route('tck.editar', $tck->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-black hover:text-indigo-600 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                <span class="tooltiptext">Editar</span>
                            </a>
                            @livewire('tickets.reasignar', ['ticketID' => $tck->id])
                        @endif
                        <a class=" tooltip"
                            href="{{ route('tck.ver', $tck->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" fill="currentColor"
                                class="w-6 h-6 text-black hover:text-indigo-600 dark:text-white" viewBox="0 0 576 512">
                                <path
                                    d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                            </svg>
                            <span class="tooltiptext">Ver Más</span>
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
            @livewire('tickets.tareas.new-tarea', ['ticketID' => $ticketID])
        </div>
    </div>

    <div class="mt-4 bg-white dark:bg-dark-eval-1 text-gray-800 p-4 rounded-md shadow-lg">
        <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
            {{ __('Tareas del ticket:') }}
        </div>
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-3">
            <span
                class="inline-flex items-center p-1 text-sm font-medium text-center text-white bg-gray-400 rounded-lg">
                Tareas
                <span
                    class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                    {{ $tareas->count() }}
                </span>
            </span>
        </div>
        @forelse ($tareas as $tarea)
            <div @if ($tarea->status == 'Abierto') class="mb-2 bg-teal-100 border-t-4 border-teal-500 rounded-md text-teal-900 px-4 py-3 shadow-md" @endif
                @if ($tarea->status == 'En Proceso') class="mb-2 bg-orange-100 border-t-4 border-orange-500 rounded-md text-orange-900 px-4 py-3 shadow-md" @endif
                @if ($tarea->status == 'Cerrado') class="mb-2 bg-gray-100 border-t-4 border-gray-500 rounded-md text-gray-900 px-4 py-3 shadow-md" @endif
                role="alert">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex">
                        <div class="py-1 flex items-center"> <span
                                @if ($tarea->status == 'Abierto') class="mr-4 bg-teal-500 p-1 rounded-full text-white" @endif
                                @if ($tarea->status == 'En Proceso') class="mr-4 bg-orange-500 p-1 rounded-full text-white" @endif
                                @if ($tarea->status == 'Cerrado') class="mr-4 bg-gray-500 p-1 rounded-full text-white" @endif>#{{ $tarea->id }}</span>
                        </div>
                        <div>
                            <p class="font-bold">{{ $tarea->user->name }}</p>
                            <p class="text-sm"> {{ $tarea->mensaje }}</p>
                        </div>
                    </div>
                    <div class="flex w-full h-4 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700">
                        @if ($tarea->status == 'Abierto')
                            <div class="flex flex-col justify-center overflow-hidden bg-green-500 text-xs text-white text-center"
                                role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                aria-valuemax="100">25%</div>
                        @endif
                        @if ($tarea->status == 'En Proceso')
                            <div class="flex flex-col justify-center overflow-hidden bg-green-500 text-xs text-white text-center"
                                role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                aria-valuemax="100">50%</div>
                        @endif
                        @if ($tarea->status == 'Cerrado')
                            <div class="flex flex-col justify-center overflow-hidden bg-green-500 text-xs text-white text-center"
                                role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                aria-valuemax="100">100%</div>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        @livewire('tickets.tareas.show-tarea', ['tareaID' => $tarea->id])
                        @if ($tarea->status != 'Cerrado' || Auth::user()->permiso_id == 1)
                            @if (Auth::user()->permiso_id == 1)
                                @livewire('tickets.tareas.edit-tarea', ['tareaID' => $tarea->id])
                                @livewire('tickets.tareas.delete-tarea', ['tareaID' => $tarea->id])
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <span class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                Sin tareas actualmente.
            </span>
        @endforelse
    </div>
</x-app-layout>
