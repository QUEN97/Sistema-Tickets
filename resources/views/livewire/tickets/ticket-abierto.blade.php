<div>
    <div class="py-4 space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <!--Tickets por Estado-->
            <div>
                <div x-data="{ isOpen: false }" class="relative mr-3 w-full md:w-auto">
                    <!-- Botón para abrir/cerrar el menú -->
                    <button @click="isOpen = !isOpen" class="focus:outline-none flex">
                        <!-- Icono de flecha hacia abajo cuando está cerrado, hacia arriba cuando está abierto -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                            :class="{ 'transform rotate-180': isOpen }" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 12a.75.75 0 0 0 .53-.22l3.25-3.25a.75.75 0 0 0-1.06-1.06L10 10.94 7.28 8.22a.75.75 0 1 0-1.06 1.06l3.75 3.75a.75.75 0 0 0 .53.22z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-bold">Tickets por Estado</span>
                    </button>

                    <!-- Menú desplegable -->
                    <div x-show="isOpen" @click.away="isOpen = false"
                        class="absolute z-10 w-48 bg-gray-200 dark:bg-slate-800 rounded-md overflow-hidden shadow-xl">
                        <!-- Opciones del menú -->
                        <div class="flex flex-col justify-center items-center">
                            <a class="inline-flex items-center px-2 py-1 text-sm  text-center   font-bold"
                                href="{{ route('tickets.process') }}">
                                EN PROCESO
                                @if ($enproceso > 0)
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 ml-2 text-xs font-semibold text-black bg-gray-100 rounded-full">
                                        {{ $enproceso }}
                                    </span>
                                @endif
                            </a>
                            <a class="inline-flex items-center px-2 py-1 text-sm  text-center   font-bold"
                                href="{{ route('tickets.closed') }}">
                                CERRADOS
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Barra de Busqueda --}}
            <div>
                <x-input wire:model="search" type="text" class="w-full md:w-auto" placeholder="Buscar tickets..." />
            </div>

            {{-- Filtro de Fechas --}}
            <div class="hidden md:flex items-center justify-center overflow-auto">
                {{-- Exportar Excel Tickets General y Rango de fechas --}}
                <div class="mr-3">
                    @livewire('tickets.export-tck')
                </div>
                <div class="relative mb-2 md:mb-0 md:mr-4">
                    <input type="date" name="start" id="from_date" wire:model="from_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <span class="mx-4 text-gray-500">a</span>
                <div class="relative">
                    <input type="date" name="end" id="to_date" wire:model="to_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <button wire:click="clearDateFilters" class="mx-2 md:mx-4 text-gray-500">x</button>
            </div>
        </div>

        {{-- Vista Tabla --}}
        <div class="overflow-auto rounded-lg shadow hidden md:block">
            {{-- Componente tabla --}}
            <x-table>
                <x-slot name="head">
                    {{-- Componente Heading  --}}
                    <x-heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">ID</x-heading>
                    <x-heading sortable wire:click="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">ESTADO</x-heading>
                    <x-heading sortable wire:click="sortBy('falla_id')" :direction="$sortField === 'falla_id' ? $sortDirection : null">FALLA</x-heading>
                    <x-heading sortable wire:click="sortBy('solicitante_id')" :direction="$sortField === 'solicitante_id' ? $sortDirection : null">CLIENTE</x-heading>
                    <x-heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">AGENTE</x-heading>
                    <x-heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">CREADO</x-heading>
                    <x-heading sortable wire:click="sortBy('fecha_cierre')" :direction="$sortField === 'fecha_cierre' ? $sortDirection : null">VENCE</x-heading>
                    <x-heading sortable>PRIORIDAD</x-heading>
                    <x-heading></x-heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($tickets as $ticket)
                        {{-- Componente Row --}}
                        <x-row wire:loading.class.delay="opacity-75">
                            {{-- Componente Column --}}
                            <x-cell><span class="font-bold">#{{ $ticket->id }}</span></x-cell>
                            <x-cell>
                                <div
                                    @if ($ticket->status != 'Cerrado' && $ticket->vencido != 1) class="rounded bg-{{ $ticket->status_color }}-200 py-1 px-3 text-center text-xs text-{{ $ticket->status_color }}-500 font-bold" @elseif($ticket->status != 'Cerrado' && $ticket->vencido == 1)  class="rounded bg-red-200 py-1 px-3 text-xs text-center text-red-500 font-bold" @else class="rounded bg-gray-200 py-1 px-3 text-xs text-center text-gray-500 font-bold" @endif>
                                    {{ $ticket->status }}
                                </div>
                            </x-cell>
                            <x-cell class="font-bold">{{ $ticket->falla->name }} </x-cell>
                            <x-cell>{{ $ticket->cliente->name }} </x-cell>
                            <x-cell>{{ $ticket->agente->name }} </x-cell>
                            <x-cell>
                                {{ $ticket->created_at->locale('es')->isoFormat('D  MMMM  YYYY H:mm:ss a') }}</x-cell>
                            <x-cell>
                                {{ \Carbon\Carbon::parse($ticket->fecha_cierre)->locale('es')->isoFormat('D  MMMM YYYY H:mm:ss a') }}
                            </x-cell>
                            <x-cell>
                                <div @if ($ticket->falla->prioridad->name == 'Bajo') class="bg-green-400 text-white p-1 rounded w-auto text-center" @endif
                                    @if ($ticket->falla->prioridad->name == 'Medio') class="bg-yellow-400 text-white p-1 rounded w-auto text-center" @endif
                                    @if ($ticket->falla->prioridad->name == 'Alto') class="bg-orange-400 text-white p-1 rounded w-auto text-center" @endif
                                    @if ($ticket->falla->prioridad->name == 'Crítico') class="bg-red-400 text-white p-1 rounded w-auto text-center" @endif
                                    @if ($ticket->falla->prioridad->name == 'Alto Crítico') class="bg-red-700 text-white p-1 rounded w-auto text-center" @endif>
                                    {{ $ticket->falla->prioridad->name }}
                                </div>
                            </x-cell>
                            <x-cell>
                                <div x-data="{ isOpen: false }" class="relative">
                                    <!-- Botón para abrir/cerrar el menú -->
                                    <button @click="isOpen = !isOpen" class="focus:outline-none">
                                        <!-- Icono de flecha hacia abajo cuando está cerrado, hacia arriba cuando está abierto -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                            :class="{ 'transform rotate-180': isOpen }" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 12a.75.75 0 0 0 .53-.22l3.25-3.25a.75.75 0 0 0-1.06-1.06L10 10.94 7.28 8.22a.75.75 0 1 0-1.06 1.06l3.75 3.75a.75.75 0 0 0 .53.22z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        @if (Auth::user()->permiso_id !== 2 && Auth::user()->permiso_id !== 3 && Auth::user()->permiso_id !== 6)
                                            @if ($ticket->compras->count() || $ticket->tareas->count())
                                                <span
                                                    class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full"></span>
                                            @endif
                                        @endif
                                    </button>

                                    <!-- Menú desplegable -->
                                    <div x-show="isOpen" @click.away="isOpen = false"
                                        class="absolute z-10 w-48 bg-gray-200 rounded-md overflow-hidden shadow-xl"
                                        style="top: calc(-100% - 0.5rem); right: 2rem;">
                                        <!-- Opciones del menú -->
                                        <div class="flex flex-col justify-center items-center">
                                            @if ($ticket->status != 'Cerrado')
                                                @if (Auth::user()->permiso_id == 1)
                                                    <div class="flex gap-1">
                                                        <a href="{{ route('tck.editar', $ticket->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor"
                                                                class="w-6 h-6 text-black hover:text-gray-600 dark:text-gray-400">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                            </svg>
                                                        </a>
                                                        <span class="font-bold text-base text-black">Editar</span>
                                                    </div>

                                                    <div class="flex gap-1">
                                                        @livewire('tickets.reasignar', ['ticketID' => $ticket->id], key('reasignar' . $ticket->id))
                                                        <span class="font-bold text-base text-black">Reasignar</span>
                                                    </div>
                                                @endif
                                                <div class="flex gap-1">
                                                    <a href="{{ route('tck.ver', $ticket->id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                            height="15" fill="currentColor"
                                                            class="w-6 h-6 text-black hover:text-gray-600 dark:text-gray-400"
                                                            viewBox="0 0 576 512">
                                                            <path
                                                                d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                        </svg>
                                                    </a>
                                                    <span class="font-bold text-base text-black">Ver Más</span>
                                                </div>
                                                @if (!in_array(Auth::user()->permiso_id, [2, 3, 6]))
                                                    <div class="flex gap-1">
                                                        @livewire('tickets.compras.show-compras', ['ticketID' => $ticket->id], key('compra' . $ticket->id))
                                                        <span
                                                            class="font-bold text-base text-black">Requisiciones</span>
                                                    </div>
                                                    <div class="flex gap-1">
                                                        <a href="{{ route('tck.tarea', $ticket->id) }}">
                                                            @if ($ticket->tareas->count())
                                                                <div class="relative">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        class="w-6 h-6 text-black hover:text-gray-600 dark:text-gray-400">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                                    </svg>
                                                                    <span
                                                                        class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full">
                                                                    </span>
                                                                </div>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor"
                                                                    class="w-6 h-6 text-black hover:text-gray-600 dark:text-gray-400">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                                </svg>
                                                            @endif
                                                        </a>
                                                        <span class="font-bold text-base text-black">Tareas</span>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="flex gap-1">
                                                    @livewire('tickets.details-tck', ['ticketID' => $ticket->id], key('cerrado' . $ticket->id))
                                                    <span class="font-bold text-base text-black">Ver más</span>
                                                </div>
                                            @endif
                                            @if (Auth::user()->permiso_id == 1 && $ticket->status == 'Cerrado')
                                                <div class="flex gap-1">
                                                    @livewire('tickets.unlock-ticket', ['ticketID' => $ticket->id], key('unlock' . $ticket->id))
                                                    <span class="font-bold text-base text-black">Abrir</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </x-cell>
                        </x-row>
                    @empty
                        <x-row>
                            <x-cell colspan="10">
                                <div class="flex justify-center items-center space-x-2">
                                    <x-icons.inbox class="w-8 h-8 text-gray-300" />
                                    <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron
                                        resultados...</span>
                                </div>
                            </x-cell>
                        </x-row>
                    @endforelse
                </x-slot>
            </x-table>
            {{-- Paginación y contenido por página --}}
            <div class="py-4 px-3">
                <div class="flex space-x-4 items-center mb3">
                    <x-label class="text-sm font-medium text-gray-600">Mostrar</x-label>
                    <select wire:model.live="perPage"
                        class="bg-gray-100 dark:bg-slate-800 border border-gray-400 text-gray-500 text-sm rounded-lg focus:ring-indigo-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $tickets->links() }}
            </div>
        </div>
        {{-- Vista Mobil  Usando Grids --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
            @forelse($tickets as $ticket)
                <div class="bg-white dark:bg-dark-eval-3 space-y-3 p-4 rounded-lg shadow">
                    <div class="flex float-right">
                        <div x-data="{ isOpen: false }" class="relative">
                            <!-- Botón para abrir/cerrar el menú -->
                            <button @click="isOpen = !isOpen" class="focus:outline-none">
                                <!-- Icono de flecha hacia abajo cuando está cerrado, hacia arriba cuando está abierto -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                    :class="{ 'transform rotate-180': isOpen }" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 12a.75.75 0 0 0 .53-.22l3.25-3.25a.75.75 0 0 0-1.06-1.06L10 10.94 7.28 8.22a.75.75 0 1 0-1.06 1.06l3.75 3.75a.75.75 0 0 0 .53.22z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Menú desplegable -->
                            <div x-show="isOpen" @click.away="isOpen = false"
                                class="absolute z-10 w-48 bg-gray-200 rounded-md overflow-hidden shadow-xl"
                                style="top: calc(-100% - 0.5rem); right: 2rem;">
                                <!-- Opciones del menú -->
                                <div class="flex flex-col justify-center items-center">
                                    @if ($ticket->status != 'Cerrado')
                                        @if (Auth::user()->permiso_id == 1)
                                            <div class="flex gap-1">
                                                <a href="{{ route('tck.editar', $ticket->id) }}"
                                                    :key="'edittck-'.$ticket - > id">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-black hover:text-gray-600 dark:text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </a>
                                                <span class="font-bold text-base text-black">Editar</span>
                                            </div>

                                            <div class="flex gap-1">
                                                @livewire('tickets.reasignar', ['ticketID' => $ticket->id], key('reasignartck' . $ticket->id))
                                                <span class="font-bold text-base text-black">Reasignar</span>
                                            </div>
                                        @endif
                                        <div class="flex gap-1">
                                            <a href="{{ route('tck.ver', $ticket->id) }}"
                                                :key="'vertck-'.$ticket - > id">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                    fill="currentColor"
                                                    class="w-6 h-6 text-black hover:text-gray-600 dark:text-gray-400"
                                                    viewBox="0 0 576 512">
                                                    <path
                                                        d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                </svg>
                                            </a>
                                            <span class="font-bold text-base text-black">Ver Más</span>
                                        </div>
                                        @if (!in_array(Auth::user()->permiso_id, [2, 3, 6]))
                                            <div class="flex gap-1">
                                                @livewire('tickets.compras.show-compras', ['ticketID' => $ticket->id], key('compratck' . $ticket->id))
                                                <span class="font-bold text-base text-black">Requisiciones</span>
                                            </div>
                                            <div class="flex gap-1">
                                                <a href="{{ route('tck.tarea', $ticket->id) }}"
                                                    :key="'tareatck-'.$ticket - > id">
                                                    @if ($ticket->tareas->count())
                                                        <div class="relative">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor"
                                                                class="w-6 h-6 text-black hover:text-gray-600 dark:text-gray-400">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                            </svg>
                                                            <span
                                                                class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full">
                                                            </span>
                                                        </div>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-6 h-6 text-black hover:text-gray-600 dark:text-gray-400">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                        </svg>
                                                    @endif
                                                </a>
                                                <span class="font-bold text-base text-black">Tareas</span>
                                            </div>
                                        @endif
                                    @else
                                        <div class="flex gap-1">
                                            @livewire('tickets.details-tck', ['ticketID' => $ticket->id], key('cerradotck' . $ticket->id))
                                            <span class="font-bold text-base text-black">Ver más</span>
                                        </div>
                                    @endif
                                    @if (Auth::user()->permiso_id == 1 && $ticket->status == 'Cerrado')
                                        <div class="flex gap-1">
                                            @livewire('tickets.unlock-ticket', ['ticketID' => $ticket->id], key('unlocktck' . $ticket->id))
                                            <span class="font-bold text-base text-black">Abrir</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 text-sm">
                        <div class="font-bold">#{{ $ticket->id }}</div>
                        <div class="text-gray-500 truncate">
                            {{ $ticket->falla->name }}
                        </div>
                    </div>
                    <div class="flex gap-4 justify-center items-center md:flex-row md:items-center md:justify-center ">
                        <div>
                            {{ $ticket->cliente->name }}
                        </div>
                        <div>
                            {{ $ticket->agente->name }}
                        </div>
                    </div>
                    <div class="flex gap-4 justify-center items-center md:flex-row md:items-center md:justify-center ">
                        <div
                            @if ($ticket->vencido == 0) class="rounded bg-{{ $ticket->status_color }}-200 py-1 px-3  text-{{ $ticket->status_color }}-500 font-bold text-center" @else  class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold text-center" @endif>
                            {{ $ticket->status }}
                        </div>
                        <div @if ($ticket->falla->prioridad->name == 'Bajo') class="bg-green-400 text-white p-1 rounded w-auto text-center" @endif
                            @if ($ticket->falla->prioridad->name == 'Medio') class="bg-yellow-400 text-white p-1 rounded w-auto text-center" @endif
                            @if ($ticket->falla->prioridad->name == 'Alto') class="bg-orange-400 text-white p-1 rounded w-auto text-center" @endif
                            @if ($ticket->falla->prioridad->name == 'Crítico') class="bg-red-400 text-white p-1 rounded w-auto text-center" @endif
                            @if ($ticket->falla->prioridad->name == 'Alto Crítico') class="bg-red-700 text-white p-1 rounded w-auto text-center" @endif>
                            {{ $ticket->falla->prioridad->name }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex justify-center items-center space-x-2">
                    <x-icons.inbox class="w-8 h-8 text-gray-300" />
                    <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron
                        resultados...</span>
                </div>
            @endforelse

            <div class="py-4 px-3">
                <div class="flex space-x-4 items-center mb-3">
                    <x-label class="text-sm font-medium text-gray-600">Mostrar</x-label>
                    <select wire:model.live="perPage"
                        class="bg-gray-50 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
