<div>
    <div class="py-4 space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Barra de Busqueda --}}
            <div>
                <x-input wire:model="search" type="text" class="w-auto" placeholder="Buscar prioridades..." />
            </div>
            {{-- Acciones Masivas --}}
            @if ($checked)
                <x-dropdown align="right" width="60">
                    <x-slot name="trigger">
                        <button type="button"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            Seleccionados
                            <span
                                class="inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full">
                                {{ count($checked) }}
                            </span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="w-60">
                            <!-- Encabezado -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Opciones') }}
                            </div>
                            <!-- Eliminar y Exportar-->
                            <div>
                                @if ($valid->pivot->de == 1)
                                    <x-dropdown-link href="#" wire:click="deletePrioridades">
                                        {{ __('Eliminar Prioridad') }}
                                    </x-dropdown-link>
                                @endif
                                <x-dropdown-link href="#" wire:click="exportSelected">
                                    {{ __('Exportar a Excel') }}
                                </x-dropdown-link>
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>
            @endif
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
        @if ($selectPage)
            @if ($selectAll)
                <div class="text-gray-400 text-xs">
                    Se han seleccionado <strong>{{ $prioridades->total() }}</strong> elementos.
                </div>
            @else
                <div class="text-gray-400 text-xs">
                    Se han seleccionado <strong>{{ count($checked) }}</strong> elementos, ¿Deseas seleccionar los
                    <strong>{{ $prioridades->total() }}</strong>?
                    <a href="#" class="text-blue-500 hover:underline" wire:click="selectAll">Seleccionar todo</a>
                </div>
            @endif
        @endif

        <div class="flex-col space-y-4">
            {{-- Componente tabla --}}
            <x-table>
                <x-slot name="head">
                    {{-- Componente Heading  --}}
                    <x-heading><x-input type="checkbox" wire:model="selectPage" /></x-heading>
                    <x-heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">ID</x-heading>
                    <x-heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">TIPO-PRIORIDAD</x-heading>
                    <x-heading sortable wire:click="sortBy('tiempo')" :direction="$sortField === 'tiempo' ? $sortDirection : null">TIEMPO RESPUESTA</x-heading>
                    <x-heading sortable wire:click="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">ESTADO</x-heading>
                    <x-heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">FECHA REGISTRO</x-heading>
                    <x-heading>OPCIONES</x-heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($prioridades as $prioridad)
                        {{-- Componente Row --}}
                        <x-row wire:loading.class.delay="opacity-75">
                            {{-- Componente Column --}}
                            <x-cell> <x-input type="checkbox" value="{{ $prioridad->id }}" wire:model="checked" />
                            </x-cell>
                            <x-cell>{{ $prioridad->id }} </x-cell>
                            <x-cell> {{ $prioridad->clase->name }} - {{ $prioridad->name }}</x-cell>
                            <x-cell>
                                <div style="display: flex; justify-content: center;">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Tiempo de respuesta
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @if ($prioridad->tiempo == 1)
                                        {{ $prioridad->tiempo }} hora
                                    @else
                                        {{ $prioridad->tiempo }} horas
                                    @endif
                                </div>
                            </x-cell>
                            <x-cell>
                                <span
                                    class="rounded bg-{{ $prioridad->status_color }}-200 py-1 px-3 text-xs text-{{ $prioridad->status_color }}-500 font-bold">
                                    {{ $prioridad->status }}
                                </span>
                            </x-cell>
                            <x-cell> {{ $prioridad->created_at->locale('es')->isoFormat('D  MMMM  YYYY') }}
                            </x-cell>
                            <x-cell>
                                <div class="flex gap-2 justify-center items-center">
                                    @if ($valid->pivot->vermas == 1)
                                        @livewire('prioridades.show-prioridad', ['prioridadID' => $prioridad->id],  key('show'.$prioridad->id))
                                    @endif
                                    @if ($valid->pivot->ed == 1)
                                        @livewire('prioridades.edit-prioridad', ['prioridadID' => $prioridad->id], key('ed'.$prioridad->id))
                                    @endif
                                    @if ($valid->pivot->de == 1)
                                        @livewire('prioridades.delete-prioridad', ['prioridadID' => $prioridad->id], key('del'.$prioridad->id))
                                    @endif
                                </div>
                            </x-cell>
                        </x-row>
                    @empty
                        <x-row>
                            <x-cell colspan="7">
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
                {{ $prioridades->links() }}
            </div>
        </div>
    </div>
</div>



