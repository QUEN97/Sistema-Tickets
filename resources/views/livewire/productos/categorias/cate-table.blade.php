<div>
    <div class="py-4 space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Barra de Busqueda --}}
            <div>
                <x-input wire:model="search" type="text" class="w-auto" placeholder="Buscar categorías..." />
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
                                    <x-dropdown-link href="#" wire:click="deleteCategorias">
                                        {{ __('Eliminar Categoría') }}
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
                    Se han seleccionado <strong>{{ $categorias->total() }}</strong> elementos.
                </div>
            @else
                <div class="text-gray-400 text-xs">
                    Se han seleccionado <strong>{{ count($checked) }}</strong> elementos, ¿Deseas seleccionar los
                    <strong>{{ $categorias->total() }}</strong>?
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
                    <x-heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">CATEGORÍA</x-heading>
                    <x-heading sortable wire:click="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">ESTADO</x-heading>
                    <x-heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">FECHA REGISTRO</x-heading>
                    <x-heading>OPCIONES</x-heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($categorias as $categoria)
                        {{-- Componente Row --}}
                        <x-row wire:loading.class.delay="opacity-75">
                            {{-- Componente Column --}}
                            <x-cell> <x-input type="checkbox" value="{{ $categoria->id }}" wire:model="checked" />
                            </x-cell>
                            <x-cell>{{ $categoria->id }} </x-cell>
                            <x-cell>{{ $categoria->name }}</x-cell>
                            <x-cell>
                                <span
                                    class="rounded bg-{{ $categoria->status_color }}-200 py-1 px-3 text-xs text-{{ $categoria->status_color }}-500 font-bold">
                                    {{ $categoria->status }}
                                </span>
                            </x-cell>
                            <x-cell> {{ $categoria->created_at->locale('es')->isoFormat('D  MMMM  YYYY') }}
                            </x-cell>
                            <x-cell>
                                <div class="flex gap-2 justify-center items-center">
                                    <div>
                                        @if ($valid->pivot->vermas == 1)
                                            @livewire('productos.categorias.categoria-show', ['categoria_show_id' => $categoria->id], key('show'.$categoria->id))
                                        @endif
                                    </div>
                                    <div>
                                        @if ($valid->pivot->ed == 1)
                                            @livewire('productos.categorias.categoria-edit', ['categoria_id' => $categoria->id], key('ed'.$categoria->id))
                                        @endif
                                    </div>
                                    <div>
                                        @if ($valid->pivot->de == 1)
                                            @livewire('productos.categorias.categoria-delete', ['catID' => $categoria->id], key('del'.$categoria->id))
                                        @endif
                                    </div>
                                </div>
                            </x-cell>
                        </x-row>
                    @empty
                        <x-row>
                            <x-cell colspan="6">
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
                {{ $categorias->links() }}
            </div>
        </div>
    </div>
</div>

