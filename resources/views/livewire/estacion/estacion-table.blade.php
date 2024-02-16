<div>
    <div class="py-4 space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Barra de Busqueda --}}
            <div>
                <x-input wire:model="search" type="text" class="w-auto" placeholder="Buscar estaciones..." />
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
                                    <x-dropdown-link href="#" wire:click="deleteEstaciones">
                                        {{ __('Eliminar Estación') }}
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
            <div class="hidden md:flex items-center justify-center overflow-auto">
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
                    Se han seleccionado <strong>{{ $estaciones->total() }}</strong> elementos.
                </div>
            @else
                <div class="text-gray-400 text-xs">
                    Se han seleccionado <strong>{{ count($checked) }}</strong> elementos, ¿Deseas seleccionar los
                    <strong>{{ $estaciones->total() }}</strong>?
                    <a href="#" class="text-blue-500 hover:underline" wire:click="selectAll">Seleccionar todo</a>
                </div>
            @endif
        @endif

        <div class="overflow-auto rounded-lg shadow hidden md:block">
            {{-- Componente tabla --}}
            <x-table>
                <x-slot name="head">
                    {{-- Componente Heading  --}}
                    <x-heading><x-input type="checkbox" wire:model="selectPage" /></x-heading>
                    <x-heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">ID</x-heading>
                    <x-heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">ESTACIÓN</x-heading>
                    <x-heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">GERENTE</x-heading>
                    <x-heading sortable wire:click="sortBy('supervisor_id')" :direction="$sortField === 'supervisor_id' ? $sortDirection : null">SUPERVISOR</x-heading>
                    <x-heading sortable wire:click="sortBy('zona_id')" :direction="$sortField === 'zona_id' ? $sortDirection : null">ZONA</x-heading>
                    <x-heading sortable wire:click="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">ESTADO</x-heading>
                    {{-- <x-heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">FECHA REGISTRO</x-heading> --}}
                    <x-heading>OPCIONES</x-heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($estaciones as $esta)
                        {{-- Componente Row --}}
                        <x-row wire:loading.class.delay="opacity-75">
                            {{-- Componente Column --}}
                            <x-cell> <x-input type="checkbox" value="{{ $esta->id }}" wire:model="checked" />
                            </x-cell>
                            <x-cell>{{ $esta->id }} </x-cell>
                            <x-cell class="font-bold">{{ $esta->name }}</x-cell>
                            <x-cell>
                                @if ($esta->user_id != 0 || $esta->user_id != null)
                                    @if ($esta->user->permiso_id == 3 && $esta->user->status == 'Activo')
                                        {{ $esta->user->name }}
                                    @else
                                        <p class="text-danger p-0 m-0">
                                            {{ $esta->user->name }}
                                            <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                                                data-bs-trigger="hover focus"
                                                data-bs-content="Este gerente ha sido movido a la papelera"
                                                data-bs-placement="top">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4 text-blue-400">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                        </p>
                                    @endif
                                @else
                                    <p class="text-red-500">
                                        {{ __('Sin Gerente') }}
                                    </p>
                                @endif
                            </x-cell>
                            <x-cell>
                                @if ($esta->supervisor_id != 0 || $esta->supervisor_id != null)
                                    @if ($esta->supervisor->permiso_id == 2 && $esta->supervisor->status == 'Activo')
                                        {{ $esta->supervisor->name }}
                                    @else
                                        <p class="text-danger p-0 m-0">
                                            {{ $esta->supervisor->name }}
                                            <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                                                data-bs-trigger="hover focus"
                                                data-bs-content="Este supervisor ha sido movido a la papelera"
                                                data-bs-placement="top">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4 text-blue-400">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                        </p>
                                    @endif
                                @else
                                    <p class="text-red-500">
                                        {{ __('Sin Supervisor') }}
                                    </p>
                                @endif
                            </x-cell>
                            <x-cell>
                                @if ($esta->zona->status == 'Inactivo')
                                    <p class="text-red-500">
                                        {{ $esta->zona->name }}
                                        <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                                            data-bs-trigger="hover focus"
                                            data-bs-content="Esta zona ha sido movida a la papelera"
                                            data-bs-placement="top">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4 text-blue-400">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </p>
                                @else
                                    {{ $esta->zona->name }}
                                @endif
                            </x-cell>
                            <x-cell>
                                <span
                                    class="rounded bg-{{ $esta->status_color }}-200 py-1 px-3 text-xs text-{{ $esta->status_color }}-500 font-bold">
                                    {{ $esta->status }}
                                </span>
                            </x-cell>
                            {{-- <x-cell> {{ $esta->created_at->locale('es')->isoFormat('D  MMMM  YYYY') }}
                            </x-cell> --}}
                            <x-cell>
                                <div class="flex gap-2 justify-center items-center">
                                    <div>
                                        @if ($valid->pivot->vermas == 1)
                                            @livewire('estacion.show-estacion', ['estacion_show_id' => $esta->id], key('show'.$esta->id))
                                        @endif
                                    </div>
                                    <div>
                                        @if ($valid->pivot->ed == 1)
                                            @livewire('estacion.estacion-edit', ['estacion_id' => $esta->id], key('ed'.$esta->id))
                                        @endif
                                    </div>
                                    <div>
                                        @if ($valid->pivot->de == 1)
                                            @livewire('estacion.estacion-delete', ['estaID' => $esta->id], key('del'.$esta->id))
                                        @endif
                                    </div>
                                </div>
                            </x-cell>
                        </x-row>
                    @empty
                        <x-row>
                            <x-cell colspan="8">
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
                        class="bg-gray-50 dark:bg-slate-800 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $estaciones->links() }}
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
            @forelse($estaciones as $esta)
                <div class="bg-white dark:bg-slate-900 space-y-3 p-4 rounded-lg shadow">
                    <div class="flex float-right">
                        <div x-data="{ open: false }">
                            <div class="relative inline-block text-left">
                                <div>
                                    <button @click="open = !open" type="button"
                                        class="inline-flex w-full justify-center gap-x-1.5 p-2 text-sm font-semibold text-gray-900 dark:text-gray-400 hover:text-blue-500 dark:hover:text-indigo-500"
                                        :aria-expanded="open.toString()" aria-haspopup="true">
                                        <svg class="w-10 h-10" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="1.5"
                                                d="M12.25 12h-.5m.5-4h-.5m.5 8h-.5" />
                                        </svg>
                                    </button>
                                </div>

                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 z-10 w-56 origin-top-right rounded-md bg-gray-100 p-2 dark:bg-slate-800 overflow-auto"
                                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                    tabindex="-1">
                                    <div class="flex gap-2 justify-center items-center">
                                        <div>
                                            @if ($valid->pivot->vermas == 1)
                                                @livewire('estacion.show-estacion', ['estacion_show_id' => $esta->id], key('showesta'.$esta->id))
                                            @endif
                                        </div>
                                        <div>
                                            @if ($valid->pivot->ed == 1)
                                                @livewire('estacion.estacion-edit', ['estacion_id' => $esta->id], key('edit'.$esta->id))
                                            @endif
                                        </div>
                                        <div>
                                            @if ($valid->pivot->de == 1)
                                                @livewire('estacion.estacion-delete', ['estaID' => $esta->id], key('delete'.$esta->id))
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 text-sm">
                        <div class="font-bold">#{{ $esta->id }}</div>
                        <div class="font-bold truncate">
                            {{ $esta->name }}
                        </div>
                    </div>
                    <div class="flex gap-4 justify-center items-center md:flex-row md:items-center md:justify-center ">
                        <span
                            class="rounded bg-{{ $esta->status_color }}-200 py-1 px-3 text-xs text-{{ $esta->status_color }}-500 font-bold">
                            {{ $esta->status }}
                        </span>
                        <div>
                            @if ($esta->zona->status == 'Inactivo')
                            <p class="text-red-500">
                                {{ $esta->zona->name }}
                                <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                                    data-bs-trigger="hover focus"
                                    data-bs-content="Esta zona ha sido movida a la papelera"
                                    data-bs-placement="top">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" class="w-4 h-4 text-blue-400">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </p>
                        @else
                            {{ $esta->zona->name }}
                        @endif
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
                        class="bg-gray-50 dark:bg-slate-800 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $estaciones->links() }}
            </div>
        </div>

    </div>
</div>
