<div>
    <div class="py-4 space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Barra de Busqueda --}}
            <div>
                <x-input wire:model="search" type="text" class="w-auto" placeholder="Buscar tickets..." />
            </div>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-center mt-5">
                @livewire('tickets.export-tck')
                {{-- Filtro de Fechas --}}
                <div class="flex items-center">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input type="date" name="start" id="from_date" wire:model="from_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <span class="mx-4 text-gray-500">a</span>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input type="date" name="end" id="to_date" wire:model="to_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <button wire:click="clearDateFilters" class="mx-4 text-gray-500">x</button>
                </div>
            </div>
        </div>
        <div class="flex-col space-y-2">
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
                    <x-heading>PRIORIDAD</x-heading>
                    <x-heading></x-heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($tickets as $ticket)
                        {{-- Componente Row --}}
                        <x-row wire:loading.class.delay="opacity-75">
                            {{-- Componente Column --}}
                            <x-cell>#{{ $ticket->id }} </x-cell>
                            <x-cell>
                                <div
                                    @if ($ticket->vencido == 0) class="rounded bg-{{ $ticket->status_color }}-200 py-1 px-3 text-xs text-{{ $ticket->status_color }}-500 font-bold" @else  class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold" @endif>
                                    {{ $ticket->status }}
                                </div>
                            </x-cell>
                            <x-cell>{{ $ticket->falla->name }} </x-cell>
                            <x-cell>{{ $ticket->cliente->name }} </x-cell>
                            <x-cell>{{ $ticket->agente->name }} </x-cell>
                            <x-cell>
                                {{ $ticket->created_at->locale('es')->isoFormat('D  MMMM  YYYY H:mm:ss a') }}</x-cell>
                            <x-cell>
                                {{ \Carbon\Carbon::parse($ticket->fecha_cierre)->locale('es')->isoFormat('D  MMMM YYYY H:mm:ss a') }}
                            </x-cell>
                            <x-cell>
                                <div @if ($ticket->falla->prioridad->name == 'Bajo') class="bg-green-400 text-white p-1 rounded w-auto" @endif
                                    @if ($ticket->falla->prioridad->name == 'Medio') class="bg-yellow-400 text-white p-1 rounded w-auto" @endif
                                    @if ($ticket->falla->prioridad->name == 'Alto') class="bg-orange-400 text-white p-1 rounded w-auto" @endif
                                    @if ($ticket->falla->prioridad->name == 'Crítico') class="bg-red-400 text-white p-1 rounded w-auto" @endif
                                    @if ($ticket->falla->prioridad->name == 'Alto Crítico') class="bg-red-700 text-white p-1 rounded w-auto" @endif>
                                    {{ $ticket->falla->prioridad->name }}
                                </div>
                            </x-cell>
                            <x-cell>
                                <div x-data="{ open: false }">
                                    <div class="relative inline-block text-left">
                                        <div>
                                            <button @click="open = !open" type="button"
                                                class="inline-flex w-full justify-center gap-x-1.5 p-2 text-sm font-semibold text-gray-900 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-500"
                                                :aria-expanded="open.toString()" aria-haspopup="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M6.955 1.45A.5.5 0 0 1 7.452 1h1.096a.5.5 0 0 1 .497.45l.17 1.699c.484.12.94.312 1.356.562l1.321-1.081a.5.5 0 0 1 .67.033l.774.775a.5.5 0 0 1 .034.67l-1.08 1.32c.25.417.44.873.561 1.357l1.699.17a.5.5 0 0 1 .45.497v1.096a.5.5 0 0 1-.45.497l-1.699.17c-.12.484-.312.94-.562 1.356l1.082 1.322a.5.5 0 0 1-.034.67l-.774.774a.5.5 0 0 1-.67.033l-1.322-1.08c-.416.25-.872.44-1.356.561l-.17 1.699a.5.5 0 0 1-.497.45H7.452a.5.5 0 0 1-.497-.45l-.17-1.699a4.973 4.973 0 0 1-1.356-.562L4.108 13.37a.5.5 0 0 1-.67-.033l-.774-.775a.5.5 0 0 1-.034-.67l1.08-1.32a4.971 4.971 0 0 1-.561-1.357l-1.699-.17A.5.5 0 0 1 1 8.548V7.452a.5.5 0 0 1 .45-.497l1.699-.17c.12-.484.312-.94.562-1.356L2.629 4.107a.5.5 0 0 1 .034-.67l.774-.774a.5.5 0 0 1 .67-.033L5.43 3.71a4.97 4.97 0 0 1 1.356-.561l.17-1.699ZM6 8c0 .538.212 1.026.558 1.385l.057.057a2 2 0 0 0 2.828-2.828l-.058-.056A2 2 0 0 0 6 8Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>

                                        <div x-show="open" @click.away="open = false"
                                            class="absolute right-0 z-10 mt-1 w-56 origin-top-right rounded-md bg-gray-100 overflow-auto"
                                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                            tabindex="-1">
                                            <div class="py-2 text-center" role="none">
                                                {{-- Editar --}}
                                                <a href="{{ route('tck.editar', $ticket->id) }}">
                                                    Editar Ticket
                                                </a>
                                                {{-- Reasignar --}}
                                                @livewire('tickets.reasignar', ['ticketID' => $ticket->id], key('reasignar' . $ticket->id))
                                                {{-- Ver Más --}}
                                                <a class="tooltip" href="{{ route('tck.ver', $ticket->id) }}">
                                                    Ver Más
                                                </a>
                                                {{-- Requisiciones --}}
                                                @livewire('tickets.compras.show-compras', ['ticketID' => $ticket->id], key('compra' . $ticket->id))
                                                {{-- Desbloquear --}}
                                                @livewire('tickets.unlock-ticket', ['ticketID' => $ticket->id], key('unlock' . $ticket->id))
                                                {{-- Tareas --}}
                                                <a class="tooltip"
                                                    href="{{ route('tck.tarea', $ticket->id) }}">
                                                    @if ($ticket->tareas->count())
                                                        <div class="relative">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor"
                                                                class="w-6 h-6 text-black hover:text-gray-600 dark:text-white">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                            </svg>
                                                            <span
                                                                class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full">
                                                            </span>
                                                        </div>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6 text-black hover:text-gray-600 dark:text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                        </svg>
                                                    @endif
                                                </a>
                                            </div>
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
